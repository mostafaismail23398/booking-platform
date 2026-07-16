<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $services = Service::with('provider', 'category')
            ->where('is_active', true)
            ->when($request->category, fn ($q) => $q->whereHas('category', fn ($c) => $c->where('slug', $request->category)))
            ->when($request->search, fn ($q) => $q->where('title', 'like', '%' . $request->search . '%'))
            ->latest()
            ->paginate(9)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('services.index', compact('services', 'categories'));
    }

    public function show(Service $service)
    {
        $service->load('provider', 'category');

        return view('services.show', compact('service'));
    }
}
