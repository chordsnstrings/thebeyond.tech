<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortfolioCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PortfolioController extends Controller
{
    public function index()
    {
        $companies = PortfolioCompany::orderBy('sort_order')->paginate(15);

        return view('admin.portfolio.index', compact('companies'));
    }

    public function create()
    {
        return view('admin.portfolio.form', ['company' => new PortfolioCompany()]);
    }

    public function store(Request $request)
    {
        PortfolioCompany::create($this->validated($request));

        return redirect()->route('admin.portfolio.index')->with('status', 'Company created.');
    }

    public function edit(PortfolioCompany $company)
    {
        return view('admin.portfolio.form', compact('company'));
    }

    public function update(Request $request, PortfolioCompany $company)
    {
        $company->update($this->validated($request));

        return redirect()->route('admin.portfolio.index')->with('status', 'Company updated.');
    }

    public function destroy(PortfolioCompany $company)
    {
        $company->delete();

        return redirect()->route('admin.portfolio.index')->with('status', 'Company deleted.');
    }

    protected function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:160'],
            'slug' => ['nullable', 'string', 'max:160'],
            'sector' => ['required', 'string', 'max:120'],
            'summary' => ['required', 'string', 'max:500'],
            'body' => ['nullable', 'string'],
            'site_url' => ['nullable', 'url', 'max:300'],
            'capabilities_delivered' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $data['slug'] = Str::slug($data['slug'] ?: $data['name']);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_published'] = $request->boolean('is_published');
        // Comma/newline separated tags -> array.
        $data['capabilities_delivered'] = collect(preg_split('/[\n,]+/', (string) ($data['capabilities_delivered'] ?? '')))
            ->map(fn ($t) => trim($t))
            ->filter()
            ->values()
            ->all();

        return $data;
    }
}
