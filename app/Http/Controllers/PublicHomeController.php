<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Property;
use App\Models\PropertyType;

class PublicHomeController extends Controller
{
    public function index()
    {
        $heroProperty = Property::published()
            ->where('is_featured', true)
            ->with(['propertyType', 'agency'])
            ->inRandomOrder()
            ->first();

        $featuredProperties = Property::published()
            ->where('is_featured', true)
            ->with(['propertyType', 'agency'])
            ->latest()
            ->take(4)
            ->get();

        $latestProperties = Property::published()
            ->with(['propertyType', 'agency'])
            ->latest()
            ->take(3)
            ->get();

        $propertyTypes = PropertyType::where('is_active', true)
            ->whereHas('properties', fn($q) => $q->published())
            ->withCount(['properties' => fn($q) => $q->published()])
            ->orderBy('sort_order')
            ->get();

        $cities = Property::published()
            ->distinct('city')
            ->orderBy('city')
            ->pluck('city');

        $stats = [
            'properties'      => Property::published()->count(),
            'agencies'        => Agency::where('is_active', true)->count(),
            'cities'          => Property::published()->distinct('city')->count('city'),
            'properties_sale' => Property::published()->where('deal_type', 'sale')->count(),
            'properties_rent' => Property::published()->where('deal_type', 'rent')->count(),
            'featured'        => Property::published()->where('is_featured', true)->count(),
            'new_this_month'  => Property::published()
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month)
                ->count(),
        ];

        $maxBedrooms = Property::published()->max('bedrooms') ?? 0;
        $maxBathrooms = Property::published()->max('bathrooms') ?? 0;

        $aggregates = Property::published()
            ->selectRaw("
                deal_type,
                bool_or(has_garage) as has_garage,
                bool_or(has_storage) as has_storage,
                bool_or(is_featured) as is_featured,
                string_agg(distinct energy_certificate, ',') as energy_certificates,
                string_agg(distinct orientation, ',') as orientations
            ")
            ->groupBy('deal_type')
            ->get()
            ->keyBy(fn($item) => is_object($item->deal_type) ? $item->deal_type->value : $item->deal_type);

        $saleAgg = $aggregates->get('sale');
        $rentAgg = $aggregates->get('rent');

        $filtersAvailableSale = [
            'has_garage' => (bool) ($saleAgg?->has_garage ?? false),
            'has_storage' => (bool) ($saleAgg?->has_storage ?? false),
            'is_featured' => (bool) ($saleAgg?->is_featured ?? false),
            'energy_certificate' => $saleAgg?->energy_certificates ? explode(',', $saleAgg->energy_certificates) : [],
            'orientation' => $saleAgg?->orientations ? explode(',', $saleAgg->orientations) : [],
        ];

        $filtersAvailableRent = [
            'has_garage' => (bool) ($rentAgg?->has_garage ?? false),
            'has_storage' => (bool) ($rentAgg?->has_storage ?? false),
            'is_featured' => (bool) ($rentAgg?->is_featured ?? false),
            'energy_certificate' => $rentAgg?->energy_certificates ? explode(',', $rentAgg->energy_certificates) : [],
            'orientation' => $rentAgg?->orientations ? explode(',', $rentAgg->orientations) : [],
        ];

        return view('public.home', compact(
            'heroProperty',
            'featuredProperties',
            'latestProperties',
            'propertyTypes',
            'cities',
            'stats',
            'maxBedrooms',
            'maxBathrooms',
            'filtersAvailableSale',
            'filtersAvailableRent',
        ));
    }
}
