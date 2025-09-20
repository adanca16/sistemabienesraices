<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $q = Product::query()
            ->when($request->filled('search'), function ($qq) use ($request) {
                $term = '%' . $request->search . '%';
                $qq->where(function ($w) use ($term) {
                    $w->where('title', 'like', $term)
                        ->orWhere('province', 'like', $term)
                        ->orWhere('canton', 'like', $term)
                        ->orWhere('district', 'like', $term)
                        ->orWhere('folio_real', 'like', $term);
                });
            })
            ->orderByDesc('id');

        $products = $q->paginate(12)->withQueryString();

        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create', ['product' => new Product()]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request, isUpdate: false);

        // slug
        $data['slug'] = Str::slug($data['title']) . '-' . Str::random(6);

        // normalizar amenities/tags desde CSV (si viene en texto)
        $data['amenities'] = $this->csvOrJsonToArray($request->input('amenities'));
        $data['tags'] = $this->csvOrJsonToArray($request->input('tags'));

        DB::transaction(function () use ($request, &$product, $data) {
            $product = Product::create($data);

            // manejar fotos “a pie”
            if ($request->hasFile('photos')) {
                $order = 0;
                foreach ($request->file('photos') as $photo) {
                    $pp = $this->saveUploadedPhoto(
                        $product,
                        $photo,
                        $order,
                        $request->input('photo_captions.' . $order),
                        $order === 0 // primera como portada
                    );

                    if ($order === 0) {
                        $product->cover_photo_id = $pp->id;
                        $product->save();
                    }
                    $order++;
                }
            }
        });

        return redirect()->route('products.show', $product)->with('ok', 'Producto creado.');
    }

    public function show(Product $product)
    {
        $product->load('photos', 'coverPhoto');
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $product->load('photos');
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validateData($request, isUpdate: true, productId: $product->id);

        // amenities/tags
        $data['amenities'] = $this->csvOrJsonToArray($request->input('amenities'));
        $data['tags'] = $this->csvOrJsonToArray($request->input('tags'));

        DB::transaction(function () use ($request, $product, $data) {
            $product->update($data);

            // nuevas fotos “a pie”
            if ($request->hasFile('photos')) {
                $startOrder = (int) ($product->photos()->max('sort_order') ?? -1) + 1;
                foreach ($request->file('photos') as $idx => $photo) {
                    $pp = $this->saveUploadedPhoto(
                        $product,
                        $photo,
                        $startOrder + $idx,
                        $request->input('photo_captions.' . $idx),
                        false
                    );
                    if (!$product->cover_photo_id) {
                        $product->cover_photo_id = $pp->id;
                        $product->save();
                    }
                }
            }

            // establecer portada si se envía photo_cover_id
            if ($request->filled('photo_cover_id')) {
                $coverId = (int) $request->photo_cover_id;
                $product->photos()->update(['is_cover' => false]);
                $product->photos()->where('id', $coverId)->update(['is_cover' => true]);
                $product->cover_photo_id = $coverId;
                $product->save();
            }

            // eliminar fotos marcadas (físico + BD)
            if ($request->filled('photo_delete_ids')) {
                $ids = array_filter(array_map('intval', explode(',', $request->photo_delete_ids)));
                $toDelete = $product->photos()->whereIn('id', $ids)->get();
                foreach ($toDelete as $pf) {
                    $this->deletePhysicalFile($pf->path); // borrar archivo físico en /public
                    $pf->delete();                         // borrar fila
                }
                // si borraste la portada, recalcular
                if ($product->cover_photo_id && ! $product->photos()->where('id', $product->cover_photo_id)->exists()) {
                    $newCover = $product->photos()->orderBy('sort_order')->first();
                    $product->cover_photo_id = $newCover?->id;
                    if ($newCover) {
                        $newCover->is_cover = true;
                        $newCover->save();
                    }
                    $product->save();
                }
            }
        });

        return redirect()->route('products.show', $product)->with('ok', 'Producto actualizado.');
    }

    public function destroy(Product $product)
    {
        DB::transaction(function () use ($product) {
            // borrar fotos físicas + filas
            foreach ($product->photos as $pf) {
                $this->deletePhysicalFile($pf->path);
                $pf->delete();
            }
            $product->delete();
        });

        return redirect()->route('products.index')->with('ok', 'Producto eliminado.');
    }

    // ------------------ helpers de archivos ------------------

    /**
     * Guarda una foto “a pie” en public/uploads/images/products/{product_id}
     * y crea el registro en product_photos.
     */
    private function saveUploadedPhoto(Product $product, \Illuminate\Http\UploadedFile $uploaded, int $sortOrder = 0, ?string $caption = null, bool $isCover = false): ProductPhoto
    {
        // Extensión segura
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $clientExt = strtolower($uploaded->getClientOriginalExtension() ?: '');
        $mime = $uploaded->getMimeType();
        if (!in_array($clientExt, $allowed)) {
            $map = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
            $clientExt = $map[$mime] ?? 'jpg';
        }

        // Nombre de archivo
        $imageName = time() . '_' . uniqid() . '.' . $clientExt;

        // Carpeta destino pública
        $destinationPath = public_path('uploads/images/products/' . $product->id);

        // Crear carpeta si no existe
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        // Guardar archivo físico nuevo
        $binary = file_get_contents($uploaded->getRealPath());
        file_put_contents($destinationPath . '/' . $imageName, $binary);

        // Metadatos
        $fullPath = $destinationPath . '/' . $imageName;
        [$width, $height] = @getimagesize($fullPath) ?: [null, null];
        $size = @filesize($fullPath) ?: null;

        // Guardar registro en BD
        return ProductPhoto::create([
            'product_id' => $product->id,
            'disk'       => 'public', // opcional, se mantiene por compatibilidad
            'path'       => 'uploads/images/products/' . $product->id . '/' . $imageName, // ruta relativa pública
            'url'        => null,
            'caption'    => $caption,
            'sort_order' => $sortOrder,
            'is_cover'   => $isCover,
            'width'      => $width,
            'height'     => $height,
            'mime'       => $mime,
            'size_bytes' => $size,
        ]);
    }

    /**
     * Borra un archivo físico dado su path relativo (respecto a /public).
     */
    private function deletePhysicalFile(?string $relativePath): void
    {
        if (!$relativePath) return;
        $absolute = public_path($relativePath);
        if (file_exists($absolute)) {
            @unlink($absolute); // suprime errores si no puede borrar
        }
    }

    // ------------------ helpers de validación ------------------

    private function csvOrJsonToArray(?string $value): ?array
    {
        if (!$value) return null;
        $trim = trim($value);
        if (Str::startsWith($trim, '[')) {
            // JSON
            $arr = json_decode($trim, true);
            return is_array($arr) ? $arr : null;
        }
        // CSV
        return array_values(array_filter(array_map(fn($v) => trim($v), explode(',', $trim))));
    }

    private function validateData(Request $request, bool $isUpdate, ?int $productId = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'summary' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],

            'listing_type' => ['required', Rule::in(['sale', 'rent', 'presale', 'project'])],
            'property_type' => ['required', 'string', 'max:30'],

            'province' => ['required', 'string', 'max:50'],
            'canton' => ['required', 'string', 'max:80'],
            'district' => ['required', 'string', 'max:100'],
            'neighborhood' => ['nullable', 'string', 'max:120'],
            'address_line' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:10'],
            'lat' => ['nullable', 'numeric', 'between:-90,90'],
            'lng' => ['nullable', 'numeric', 'between:-180,180'],

            'folio_real' => ['nullable', 'string', 'max:30', Rule::unique('products', 'folio_real')->ignore($productId)],
            'plano_catastrado' => ['nullable', 'string', 'max:30'],
            'land_use_zoning' => ['nullable', 'string', 'max:120'],
            'has_easements' => ['nullable', 'boolean'],
            'easements_notes' => ['nullable', 'string'],
            'has_mortgage' => ['nullable', 'boolean'],
            'legal_notes' => ['nullable', 'string'],

            'land_area_m2' => ['nullable', 'numeric', 'min:0'],
            'construction_area_m2' => ['nullable', 'numeric', 'min:0'],
            'frontage_m' => ['nullable', 'numeric', 'min:0'],
            'depth_m' => ['nullable', 'numeric', 'min:0'],
            'topography' => ['nullable', 'string', 'max:40'],
            'view_type' => ['nullable', 'string', 'max:60'],
            'road_front' => ['nullable', 'string', 'max:60'],
            'gated_community' => ['nullable', 'boolean'],
            'is_condominium' => ['nullable', 'boolean'],
            'hoa_fee_month_crc' => ['nullable', 'numeric', 'min:0'],

            'water' => ['nullable', 'boolean'],
            'water_provider' => ['nullable', 'string', 'max:40'],
            'electricity' => ['nullable', 'boolean'],
            'internet' => ['nullable', 'boolean'],
            'sewage' => ['nullable', 'boolean'],
            'paved_access' => ['nullable', 'boolean'],

            'bedrooms' => ['nullable', 'integer', 'min:0', 'max:32767'],
            'bathrooms' => ['nullable', 'integer', 'min:0', 'max:32767'],
            'parking' => ['nullable', 'integer', 'min:0', 'max:32767'],
            'floors' => ['nullable', 'integer', 'min:0', 'max:32767'],
            // 'year_built' => ['nullable','integer','min:1800','max:'.date('Y')],
            // 'year_renovated' => ['nullable','integer','min:1800','max:'.date('Y')],
            'amenities' => ['nullable', 'string'], // CSV o JSON en texto

            'currency' => ['required', Rule::in(['CRC', 'USD'])],
            'price_crc' => ['nullable', 'numeric', 'min:0'],
            'price_usd' => ['nullable', 'numeric', 'min:0'],
            'price_per_m2_crc' => ['nullable', 'numeric', 'min:0'],
            'price_per_m2_usd' => ['nullable', 'numeric', 'min:0'],
            'negotiable' => ['nullable', 'boolean'],
            'owner_financing' => ['nullable', 'boolean'],
            'bank_options' => ['nullable', 'string', 'max:255'],

            'status' => ['required', Rule::in(['active', 'reserved', 'sold', 'archived'])],
            'available_from' => ['nullable', 'date'],

            'contact_name' => ['nullable', 'string', 'max:120'],
            'contact_phone' => ['nullable', 'string', 'max:30'],
            'contact_email' => ['nullable', 'email', 'max:120'],
            'contact_whatsapp' => ['nullable', 'string', 'max:30'],

            'seo_title' => ['nullable', 'string', 'max:180'],
            'seo_description' => ['nullable', 'string', 'max:255'],
            'tags' => ['nullable', 'string'], // CSV o JSON en texto

            // fotos
            'photos.*' => ['nullable', 'image', 'mimes:jpeg,png,webp,jpg', 'max:5120'], // 5MB c/u
            'photo_cover_id' => ['nullable', 'integer'],
            'photo_delete_ids' => ['nullable', 'string'], // "1,2,3"
        ]);
    }
}
