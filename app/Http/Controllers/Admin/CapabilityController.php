<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Capability;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CapabilityController extends Controller
{
    public function index()
    {
        $capabilities = Capability::orderBy('sort_order')->paginate(15);

        return view('admin.capabilities.index', compact('capabilities'));
    }

    public function create()
    {
        return view('admin.capabilities.form', ['capability' => new Capability()]);
    }

    public function store(Request $request)
    {
        Capability::create($this->validated($request));

        return redirect()->route('admin.capabilities.index')->with('status', 'Capability created.');
    }

    public function edit(Capability $capability)
    {
        return view('admin.capabilities.form', compact('capability'));
    }

    public function update(Request $request, Capability $capability)
    {
        $capability->update($this->validated($request));

        return redirect()->route('admin.capabilities.index')->with('status', 'Capability updated.');
    }

    public function destroy(Capability $capability)
    {
        $capability->delete();

        return redirect()->route('admin.capabilities.index')->with('status', 'Capability deleted.');
    }

    protected function validated(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:160'],
            'slug' => ['nullable', 'string', 'max:160'],
            'icon' => ['required', 'string', 'max:40'],
            'summary' => ['required', 'string', 'max:500'],
            'body' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $data['slug'] = Str::slug($data['slug'] ?: $data['title']);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_published'] = $request->boolean('is_published');

        return $data;
    }
}
