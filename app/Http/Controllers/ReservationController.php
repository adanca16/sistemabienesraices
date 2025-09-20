<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Property;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    /** Mostrar formulario de reserva */
    public function create($SLUG)
    {
        $product = Product::where([['SLUG',$SLUG],['status', 'active']])->first();

        // Si viene property_id por query, mantenerlo
        $propertyId = $product->id;

        return view('landing.reservation.create_reservation', compact('product', 'propertyId'));
    }

    /** Guardar reserva */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_id'        => ['required', Rule::exists('products', 'id')],
            'interested_name'    => ['required', 'string', 'max:150'],
            'interested_email'   => ['nullable', 'email', 'max:150'],
            'interested_phone'   => ['nullable', 'string', 'max:40'],
            'type'               => ['required', Rule::in(['visit','virtual','call'])],
            'reserved_at'        => ['required', 'date'], // ISO y zona
            'duration_minutes'   => ['nullable', 'integer', 'min:15', 'max:240'],
            'notes'              => ['nullable', 'string', 'max:5000'],
        ]);

        $duration =  (int) $validated['duration_minutes'] ?? 30;
     
        $start    = Carbon::parse($validated['reserved_at']);
        $end      = $start->copy()->addMinutes($duration);

        // Regla: evitar traslapo para la misma propiedad con reservas no canceladas
        $overlap = Reservation::where('property_id', $validated['property_id'])
            ->where('status', '!=', 'cancelled')
            ->where('reserved_at', '<', $end)
            ->whereRaw('DATE_ADD(reserved_at, INTERVAL duration_minutes MINUTE) > ?', [$start])
            ->exists();

        if ($overlap) {
            return back()
                ->withInput()
                ->withErrors(['reserved_at' => 'Ese horario ya no está disponible para la propiedad seleccionada.']);
        }

        // Crear reserva
        $reservation = null;
        DB::transaction(function () use ($validated, $duration, $start, &$reservation) {
            $reservation = Reservation::create([
                'property_id'       => $validated['property_id'],
                'user_id'           => auth()->id(),
                'interested_name'   => $validated['interested_name'],
                'interested_email'  => $validated['interested_email'] ?? null,
                'interested_phone'  => $validated['interested_phone'] ?? null,
                'type'              => $validated['type'],
                'reserved_at'       => $start,
                'duration_minutes'  => $duration,
                'status'            => 'pending',
                'notes'             => $validated['notes'] ?? null,
            ]);
        });

        // (Opcional) aquí podrías disparar notificaciones/correos

        return redirect()->route('reservations.success')
            ->with('reservation_id', $reservation->id);
    }

    /** Pantalla de gracias */
    public function success()
    {
        $reservationId = session('reservation_id');
        return view('landing.reservation.success', compact('reservationId'));
    }
}
