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

    public function create(Request $request)
    {
        abort_unless($request->user()->isProvider(), 403, 'Only providers can add services.');

        $categories = Category::orderBy('name')->get();

        return view('services.create', compact('categories'));
    }

    public function store(Request $request)
    {
        abort_unless($request->user()->isProvider(), 403, 'Only providers can add services.');

        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'delivery_days' => ['required', 'integer', 'min:1'],
        ]);

        $data['provider_id'] = $request->user()->id;

        Service::create($data);

        return redirect()->route('dashboard')->with('status', 'Service added successfully.');
    }
}
