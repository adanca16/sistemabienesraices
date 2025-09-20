<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function detail($SLUG)
    {
        $product = Product::where('slug', $SLUG)->first();

        return view('landing.detail.index', compact('product'));
    }
    public function index(Request $request)
    {
        // --- 1) Construir query base con filtros de búsqueda ---
        $baseQuery = Product::query()
            ->when($request->filled('search'), function ($q) use ($request) {
                $term = '%' . $request->search . '%';
                $q->where(function ($w) use ($term) {
                    $w->where('title', 'like', $term)
                        ->orWhere('province', 'like', $term)
                        ->orWhere('canton', 'like', $term)
                        ->orWhere('district', 'like', $term)
                        ->orWhere('folio_real', 'like', $term);
                });
            })
            ->when(
                $request->filled('listing_type'),
                fn($q) => $q->where('listing_type', $request->listing_type)
            )
            ->when(
                $request->filled('property_type'),
                fn($q) => $q->where('property_type', 'like', '%' . $request->property_type . '%')
            );

        // --- 2) Clonar la query para no repetir filtros ---
        $queryForOthers = clone $baseQuery;

        // --- 3) Últimas 6 propiedades ---
        $newRegister = $baseQuery->orderByDesc('created_at')
            ->take(6)
            ->get();

        // --- 4) Otras propiedades, excluyendo las anteriores ---
        $otherRegister = $queryForOthers
            ->whereNotIn('id', $newRegister->pluck('id'))
            ->orderByDesc('created_at')
            ->paginate(12)       // <- si querés paginar
            ->withQueryString(); // <- conserva filtros en la paginación

        // --- 5) Pasar datos a la vista ---
        return view('landing.index', compact('newRegister', 'otherRegister'));
    }
}
