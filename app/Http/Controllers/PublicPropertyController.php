<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PublicPropertyController extends Controller
{
    public function index(Request $request)
    {
        // bool_or / string_agg are PostgreSQL aggregate functions — not available in MySQL/SQLite
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

        $dealType = $request->get('deal_type', 'sale');
        $currentFilters = $dealType === 'rent' ? $filtersAvailableRent : $filtersAvailableSale;

        $query = Property::published()
            ->with(['propertyType', 'agency']);

        if ($request->filled('deal_type') && in_array($request->deal_type, ['sale', 'rent'])) {
            $query->where('deal_type', $request->deal_type);
        }

        // ilike = case-insensitive LIKE in PostgreSQL
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'ilike', "%{$search}%")
                    ->orWhere('city', 'ilike', "%{$search}%")
                    ->orWhere('province', 'ilike', "%{$search}%")
                    ->orWhere('address_line', 'ilike', "%{$search}%");
            });
        }

        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        if ($request->has('type')) {
            $types = $request->type;
            if (!is_array($types)) {
                $types = [$types];
            }
            $types = array_filter(array_map('intval', $types));
            if (!empty($types)) {
                $query->whereIn('property_type_id', $types);
            }
        }

        if ($request->filled('agency_id')) {
            $query->where('agency_id', $request->agency_id);
        }

        if ($request->filled('bedrooms') && is_numeric($request->bedrooms)) {
            $query->where('bedrooms', '>=', (int) $request->bedrooms);
        }

        if ($request->filled('bathrooms') && is_numeric($request->bathrooms)) {
            $query->where('bathrooms', '>=', (int) $request->bathrooms);
        }

        if ($request->filled('bedrooms_min') && is_numeric($request->bedrooms_min)) {
            $query->where('bedrooms', '>=', (int) $request->bedrooms_min);
        }

        if ($request->filled('bathrooms_min') && is_numeric($request->bathrooms_min)) {
            $query->where('bathrooms', '>=', (int) $request->bathrooms_min);
        }

        if ($request->filled('area_min') && is_numeric($request->area_min)) {
            $query->where('area_total', '>=', (int) $request->area_min);
        }
        if ($request->filled('area_max') && is_numeric($request->area_max)) {
            $query->where('area_total', '<=', (int) $request->area_max);
        }
        if ($request->filled('year_min') && is_numeric($request->year_min)) {
            $query->where('year_built', '>=', (int) $request->year_min);
        }

        // Values are cross-checked against the pre-computed $currentFilters to prevent injecting
        // filter values that don't exist in the current deal_type's dataset
        if ($request->has('has_garage') && $request->has_garage == '1' && $currentFilters['has_garage']) {
            $query->where('has_garage', true);
        }
        if ($request->has('has_storage') && $request->has_storage == '1' && $currentFilters['has_storage']) {
            $query->where('has_storage', true);
        }
        if ($request->has('is_featured') && $request->is_featured == '1' && $currentFilters['is_featured']) {
            $query->where('is_featured', true);
        }

        if ($request->has('energy') && is_array($request->energy)) {
            $validEnergy = array_intersect($request->energy, $currentFilters['energy_certificate']);
            if (!empty($validEnergy)) {
                $query->whereIn('energy_certificate', $validEnergy);
            }
        }
        if ($request->has('orientation') && is_array($request->orientation)) {
            $validOri = array_intersect($request->orientation, $currentFilters['orientation']);
            if (!empty($validOri)) {
                $query->whereIn('orientation', $validOri);
            }
        }

        if ($request->filled('max_price') && is_numeric($request->max_price)) {
            $query->where('price', '<=', (float) $request->max_price);
        }

        $sort = $request->get('sort', 'newest');
        match ($sort) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'area_desc' => $query->orderBy('area_total', 'desc'),
            default => $query->orderBy('created_at', 'desc'), // newest
        };

        $perPage = (int) $request->get('per_page', 12);
        if (!in_array($perPage, [12, 18, 24, 42, 60])) {
            $perPage = 12;
        }

        $properties = $query->paginate($perPage)->withQueryString();

        $cities = Property::published()
            ->select('city')
            ->distinct()
            ->orderBy('city')
            ->pluck('city');

        $maxBedrooms = Property::published()->max('bedrooms') ?? 0;
        $maxBathrooms = Property::published()->max('bathrooms') ?? 0;

        return view('public.properties.index', compact(
            'properties',
            'cities',
            'maxBedrooms',
            'maxBathrooms',
            'filtersAvailableSale',
            'filtersAvailableRent'
        ));
    }

    public function show(string $slug)
    {
        $property = Property::published()
            ->where('slug', $slug)
            ->firstOrFail();

        $property->load([
            'user',
            'agency',
            'propertyType',
            'features',
        ]);

        $photos = $property->getMedia('photos');
        $floorPlans = $property->getMedia('floor_plans');
        $documents = $property->getMedia('documents');

        $relatedProperties = Property::published()
            ->where('id', '!=', $property->id)
            ->with(['propertyType'])
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        $cities = Property::published()
            ->select('city')
            ->distinct()
            ->orderBy('city')
            ->pluck('city');

        $property->increment('views_count');

        return view('public.properties.show', compact(
            'property',
            'photos',
            'floorPlans',
            'documents',
            'relatedProperties',
            'cities'
        ));
    }
}
