<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title','slug','summary','description',
        'listing_type','property_type',
        'province','canton','district','neighborhood','address_line','postal_code','lat','lng',
        'inec_province_code','inec_canton_code','inec_district_code',
        'folio_real','plano_catastrado','land_use_zoning','has_easements','easements_notes','has_mortgage','legal_notes',
        'land_area_m2','construction_area_m2','frontage_m','depth_m','topography','view_type','road_front',
        'gated_community','is_condominium','hoa_fee_month_crc',
        'water','water_provider','electricity','internet','sewage','paved_access',
        'bedrooms','bathrooms','parking','floors','year_built','year_renovated','amenities',
        'currency','price_crc','price_usd','price_per_m2_crc','price_per_m2_usd','negotiable','owner_financing','bank_options',
        'status','available_from','cover_photo_id',
        'user_id','contact_name','contact_phone','contact_email','contact_whatsapp',
        'seo_title','seo_description','tags',
    ];

    protected $casts = [
        'lat' => 'decimal:7',
        'lng' => 'decimal:7',
        'has_easements' => 'boolean',
        'has_mortgage' => 'boolean',
        'gated_community' => 'boolean',
        'is_condominium' => 'boolean',
        'water' => 'boolean',
        'electricity' => 'boolean',
        'internet' => 'boolean',
        'sewage' => 'boolean',
        'paved_access' => 'boolean',
        'negotiable' => 'boolean',
        'owner_financing' => 'boolean',
        'amenities' => 'array',
        'tags' => 'array',
        'available_from' => 'date',
    ];

    public function photos()
    {
        return $this->hasMany(ProductPhoto::class)->orderBy('sort_order');
    }

    public function coverPhoto()
    {
        return $this->belongsTo(ProductPhoto::class, 'cover_photo_id');
    }
}
