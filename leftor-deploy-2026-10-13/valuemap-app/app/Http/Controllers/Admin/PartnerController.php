<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PartnerController extends Controller
{
    public function index(): View
    {
        return view('admin.partners.index', ['partners' => Partner::orderBy('sort_order')->orderBy('name')->get()]);
    }

    public function create(): View
    {
        return view('admin.partners.form', ['partner' => new Partner]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data = $this->storeLogo($request, $data);
        Partner::create($data);

        return redirect()->route('admin.partners.index')->with('success', 'Partner created.');
    }

    public function edit(Partner $partner): View
    {
        return view('admin.partners.form', compact('partner'));
    }

    public function update(Request $request, Partner $partner): RedirectResponse
    {
        $data = $this->validated($request);
        $data = $this->storeLogo($request, $data, $partner);
        $partner->update($data);

        return redirect()->route('admin.partners.index')->with('success', 'Partner updated.');
    }

    public function destroy(Partner $partner): RedirectResponse
    {
        if ($partner->logo_path) {
            Storage::disk('public')->delete($partner->logo_path);
        }
        $partner->delete();

        return redirect()->route('admin.partners.index')->with('success', 'Partner deleted.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'initials' => ['required', 'string', 'max:20'],
            'country' => ['required', 'string', 'max:120'],
            'country_code' => ['required', 'string', 'size:3'],
            'location' => ['nullable', 'string', 'max:180'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'map_offset_x' => ['nullable', 'numeric', 'between:-100,100'],
            'map_offset_y' => ['nullable', 'numeric', 'between:-100,100'],
            'role' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'website_url' => ['nullable', 'url', 'max:500'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'contacts' => ['nullable', 'array', 'max:10'],
            'contacts.*.name' => ['nullable', 'string', 'max:180'],
            'contacts.*.position' => ['nullable', 'string', 'max:180'],
            'contacts.*.email' => ['nullable', 'email', 'max:255'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $data['country_code'] = strtoupper($data['country_code']);
        $data['map_offset_x'] ??= 0;
        $data['map_offset_y'] ??= 0;
        $data['sort_order'] ??= 0;
        $data['is_active'] = $request->boolean('is_active');
        $data['contacts'] = collect($data['contacts'] ?? [])->map(fn (array $contact) => [
            'name' => trim($contact['name'] ?? ''),
            'position' => trim($contact['position'] ?? ''),
            'email' => trim($contact['email'] ?? ''),
        ])->filter(fn (array $contact) => implode('', $contact) !== '')->values()->all();
        unset($data['logo']);

        return $data;
    }

    private function storeLogo(Request $request, array $data, ?Partner $partner = null): array
    {
        if ($request->boolean('remove_logo') && $partner?->logo_path) {
            Storage::disk('public')->delete($partner->logo_path);
            $data['logo_path'] = null;
        }

        if ($request->hasFile('logo')) {
            if ($partner?->logo_path) {
                Storage::disk('public')->delete($partner->logo_path);
            }
            $data['logo_path'] = $request->file('logo')->store('partners', 'public');
        }

        return $data;
    }
}
