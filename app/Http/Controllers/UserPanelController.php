<?php

namespace App\Http\Controllers;

use App\Enums\PropertyStatus;
use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserPanelController extends Controller
{
    // --- Profile ---

    public function profile()
    {
        $user       = auth()->user();
        $properties = $user->properties()->with(['propertyType'])->latest()->get();
        // Show all favorited properties regardless of their publication status
        $favorites  = $user->favorites()->with(['propertyType'])->latest('property_user_favorites.created_at')->paginate(4);

        return view('public.user.profile', compact('user', 'properties', 'favorites'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:30'],
        ]);

        $user->update($data);

        return back()->with('success', __('Tu perfil ha sido actualizado.'));
    }

    // --- Favorites ---

    public function favorites()
    {
        // Show all favorited properties (any status) so user can see what they saved
        $favorites = auth()->user()
            ->favorites()
            ->with(['propertyType', 'agency'])
            ->latest('property_user_favorites.created_at')
            ->paginate(12);

        return view('public.user.favorites', compact('favorites'));
    }

    public function toggleFavorite(Property $property)
    {
        $changes = auth()->user()->favorites()->toggle([$property->id]);

        $isFavorite = !empty($changes['attached']); // true = added, false = removed

        // AJAX request — return JSON
        if (request()->expectsJson()) {
            return response()->json(['is_favorite' => $isFavorite]);
        }

        return back();
    }

    // --- My Properties (CRUD) ---

    public function propertiesIndex()
    {
        $properties = auth()->user()
            ->properties()
            ->with(['propertyType'])
            ->latest()
            ->get();

        return view('public.user.properties.index', compact('properties'));
    }

    public function propertyCreate()
    {
        // Enforce 2-property limit for regular users
        if (auth()->user()->properties()->count() >= 2) {
            return redirect()->route('user.properties.index')
                ->with('error', __('Has alcanzado el límite de 2 propiedades para cuentas personales.'));
        }

        $propertyTypes = PropertyType::all(['id', 'name_es']);
        $features = \App\Models\Feature::active()->orderBy('sort_order')->get()->groupBy('category');

        return view('public.user.properties.form', [
            'property'      => null,
            'propertyTypes' => $propertyTypes,
            'features'      => $features,
        ]);
    }

    public function propertyStore(Request $request)
    {
        // Enforce 2-property limit
        if (auth()->user()->properties()->count() >= 2) {
            return redirect()->route('user.properties.index')
                ->with('error', __('Has alcanzado el límite de 2 propiedades para cuentas personales.'));
        }

        $data = $request->validate([
            'title'              => ['required', 'string', 'max:255'],
            'deal_type'          => ['required', 'in:sale,rent'],
            'property_type_id'   => ['required', 'exists:property_types,id'],
            'price'              => ['required', 'numeric', 'min:1'],
            'description'        => ['nullable', 'string', 'max:5000'],
            'city'               => ['required', 'string', 'max:255'],
            'province'           => ['required', 'string', 'max:255'],
            'address_line'       => ['nullable', 'string', 'max:255'],
            'neighborhood'       => ['nullable', 'string', 'max:255'],
            'zip_code'           => ['nullable', 'string', 'max:10'],
            'hide_exact_address' => ['nullable', 'boolean'],
            'bedrooms'           => ['nullable', 'integer', 'min:0'],
            'bathrooms'          => ['nullable', 'integer', 'min:0'],
            'toilets'            => ['nullable', 'integer', 'min:0'],
            'area_total'         => ['required', 'integer', 'min:1'],
            'area_useful'        => ['nullable', 'integer', 'min:1'],
            'floor_number'       => ['nullable', 'string', 'max:50'],
            'total_floors'       => ['nullable', 'integer', 'min:1'],
            'year_built'         => ['nullable', 'integer', 'min:1800', 'max:' . date('Y')],
            'has_garage'         => ['nullable', 'boolean'],
            'has_storage'        => ['nullable', 'boolean'],
            'community_fees'     => ['nullable', 'numeric', 'min:0'],
            'ibi_tax'            => ['nullable', 'numeric', 'min:0'],
            'energy_certificate' => ['nullable', 'string'],
            'orientation'        => ['nullable', 'string'],
            'video_url'          => ['nullable', 'url', 'max:500'],
            'features'           => ['nullable', 'array'],
            'features.*'         => ['exists:features,id'],
            'photos'             => ['nullable', 'array', 'max:10'],
            'photos.*'           => ['image', 'max:5120'],
        ]);

        // Normalise checkboxes (unchecked = absent from request)
        $data['has_garage']         = $request->boolean('has_garage');
        $data['has_storage']        = $request->boolean('has_storage');
        $data['hide_exact_address'] = $request->boolean('hide_exact_address');

        $data['user_id'] = auth()->id();
        $data['status']  = PropertyStatus::Pending->value; // Always pending moderation
        $data['slug']    = Str::slug($data['title']) . '-' . uniqid();

        $property = Property::create($data);

        // Sync features
        if ($request->has('features')) {
            $property->features()->sync($request->input('features'));
        }

        // Save photos
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                if ($file->isValid()) {
                    $property->addMedia($file)->toMediaCollection('photos');
                }
            }
        }

        // Generate proper slug after ID is available
        $property->generateSlug();

        return redirect()->route('user.properties.index')
            ->with('success', __('Tu propiedad ha sido enviada para revisión.'));
    }

    public function propertyEdit(Property $property)
    {
        // Ensure user owns this property
        abort_if($property->user_id !== auth()->id(), 403);

        $propertyTypes = PropertyType::all(['id', 'name_es']);
        $features = \App\Models\Feature::active()->orderBy('sort_order')->get()->groupBy('category');

        return view('public.user.properties.form', compact('property', 'propertyTypes', 'features'));
    }

    public function propertyUpdate(Request $request, Property $property)
    {
        abort_if($property->user_id !== auth()->id(), 403);

        $data = $request->validate([
            'title'              => ['required', 'string', 'max:255'],
            'deal_type'          => ['required', 'in:sale,rent'],
            'property_type_id'   => ['required', 'exists:property_types,id'],
            'price'              => ['required', 'numeric', 'min:1'],
            'description'        => ['nullable', 'string', 'max:5000'],
            'city'               => ['required', 'string', 'max:255'],
            'province'           => ['required', 'string', 'max:255'],
            'address_line'       => ['nullable', 'string', 'max:255'],
            'neighborhood'       => ['nullable', 'string', 'max:255'],
            'zip_code'           => ['nullable', 'string', 'max:10'],
            'hide_exact_address' => ['nullable', 'boolean'],
            'bedrooms'           => ['nullable', 'integer', 'min:0'],
            'bathrooms'          => ['nullable', 'integer', 'min:0'],
            'toilets'            => ['nullable', 'integer', 'min:0'],
            'area_total'         => ['required', 'integer', 'min:1'],
            'area_useful'        => ['nullable', 'integer', 'min:1'],
            'floor_number'       => ['nullable', 'string', 'max:50'],
            'total_floors'       => ['nullable', 'integer', 'min:1'],
            'year_built'         => ['nullable', 'integer', 'min:1800', 'max:' . date('Y')],
            'has_garage'         => ['nullable', 'boolean'],
            'has_storage'        => ['nullable', 'boolean'],
            'community_fees'     => ['nullable', 'numeric', 'min:0'],
            'ibi_tax'            => ['nullable', 'numeric', 'min:0'],
            'energy_certificate' => ['nullable', 'string'],
            'orientation'        => ['nullable', 'string'],
            'video_url'          => ['nullable', 'url', 'max:500'],
            'features'           => ['nullable', 'array'],
            'features.*'         => ['exists:features,id'],
            'photos'             => ['nullable', 'array', 'max:10'],
            'photos.*'           => ['image', 'max:5120'],
        ]);

        // Normalise checkboxes
        $data['has_garage']         = $request->boolean('has_garage');
        $data['has_storage']        = $request->boolean('has_storage');
        $data['hide_exact_address'] = $request->boolean('hide_exact_address');

        // Re-submit for review after editing
        $data['status']           = PropertyStatus::Pending->value;
        $data['rejection_reason'] = null;

        $property->update($data);

        // Sync features
        if ($request->has('features')) {
            $property->features()->sync($request->input('features'));
        } else {
            $property->features()->detach();
        }

        // Delete requested photos
        if ($request->has('delete_photos')) {
            $mediaItems = $property->getMedia('photos');
            foreach ($mediaItems as $media) {
                if (in_array((string) $media->id, $request->delete_photos)) {
                    $media->delete();
                }
            }
        }

        // Save new photos
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                if ($file->isValid()) {
                    $property->addMedia($file)->toMediaCollection('photos');
                }
            }
        }

        return redirect()->route('user.properties.index')
            ->with('success', __('Los cambios han sido enviados para revisión.'));
    }

    public function propertyDestroy(Property $property)
    {
        abort_if($property->user_id !== auth()->id(), 403);

        $property->delete();

        return redirect()->route('user.properties.index')
            ->with('success', __('Propiedad eliminada correctamente.'));
    }

    // --- Account Settings ---

    public function settings()
    {
        return view('public.user.settings', ['user' => auth()->user()]);
    }

    public function updatePersonal(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ], [], [], 'personal');

        $user->update($data);

        return back()->with('success', __('Datos personales actualizados.'));
    }

    public function updateContact(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'phone'                => ['nullable', 'string', 'max:30'],
            'whatsapp'             => ['nullable', 'string', 'max:30'],
            'contact_preferences'  => ['nullable', 'array'],
            'contact_preferences.*' => ['in:email,phone,whatsapp'],
        ], [], [], 'contact');

        $data['contact_preferences'] = $data['contact_preferences'] ?? [];

        $user->update($data);

        return back()->with('success', __('Información de contacto actualizada.'));
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'current_password'         => ['required', 'string'],
            'new_password'             => ['required', 'string', 'min:8', 'confirmed'],
            'new_password_confirmation' => ['required', 'string'],
        ], [], [], 'password');

        if (!Hash::check($data['current_password'], $user->password)) {
            return back()->withErrors(
                ['current_password' => __('La contraseña actual no es correcta.')],
                'password'
            );
        }

        $user->update(['password' => $data['new_password']]);

        return back()->with('success', __('Contraseña actualizada correctamente.'));
    }

    public function deleteAccount(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'delete_password' => ['required', 'string'],
        ], [], [], 'delete_account');

        if (!Hash::check($data['delete_password'], $user->password)) {
            return back()->withErrors(
                ['delete_password' => __('La contraseña es incorrecta.')],
                'delete_account'
            );
        }

        // Clean Spatie media files and force delete user's properties
        foreach ($user->properties as $property) {
            $property->clearMediaCollection('photos');
            $property->clearMediaCollection('floor_plans');
            $property->forceDelete();
        }

        // Log out user
        auth()->logout();

        // Force delete user account
        $user->forceDelete();

        return redirect()->route('home')
            ->with('success', __('Tu cuenta y todas tus propiedades han sido eliminadas.'));
    }
}
