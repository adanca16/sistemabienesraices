<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function show(Request $request)
    {
        $reservation = Reservation::where('id', $request->id)->first();

        $product = Product::where('id', $reservation->property_id)->first();
        $reservation->property = $product;

        return view('reservations.show', compact('reservation'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,confirmed,cancelled']
        ]);

        $reservation->update([
            'status' => $validated['status']
        ]);

        return redirect()->route('reservations.showEvent',['id' =>$reservation->id])
            ->with('success', 'Estado actualizado correctamente.');
    }

    public function index()
    {
        return view('reservations.index');
    }

    /** JSON de eventos para FullCalendar (soporta ?start= & end= ISO) */
    public function events(Request $request)
    {
        $start = $request->query('start'); // ISO
        $end   = $request->query('end');   // ISO

        $query = Reservation::with('property')->where('status', '!=', 'deleted');

        if ($start && $end) {
            $query->between($start, $end);
        }

        $reservations = $query->orderBy('reserved_at')->get();

        $events = $reservations->map(function ($r) {
            return [
                'id'    => $r->id,
                'title' => "{$r->property->title} • {$r->interested_name}",
                'start' => $r->reserved_at->toIso8601String(),
                'end'   => $r->end_at?->toIso8601String(),
                'extendedProps' => [
                    'type'   => $r->type,
                    'status' => $r->status,
                    'phone'  => $r->interested_phone,
                    'email'  => $r->interested_email,
                ],
            ];
        });

        return response()->json($events);
    }

      public function destroy(Reservation $reservation)
    {
        // Borrar la reserva
        $reservation->status = 'deleted';
        $reservation->update();

        // Redirigir con mensaje de éxito
        return redirect()
            ->route('reservations.index')
            ->with('success', 'La reserva se eliminó correctamente.');
    }

}
