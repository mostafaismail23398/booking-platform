<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $services = Service::with('provider:id,name', 'category:id,name,slug')
            ->where('is_active', true)
            ->when($request->category, fn ($q) => $q->whereHas('category', fn ($c) => $c->where('slug', $request->category)))
            ->when($request->search, fn ($q) => $q->where('title', 'like', '%' . $request->search . '%'))
            ->latest()
            ->paginate(12);

        return response()->json($services);
    }

    public function show(Service $service)
    {
        return response()->json($service->load('provider:id,name', 'category:id,name,slug'));
    }

    public function store(Request $request)
    {
        abort_unless($request->user()->isProvider(), 403, 'Only providers can create services.');

        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'delivery_days' => ['required', 'integer', 'min:1'],
        ]);

        $data['provider_id'] = $request->user()->id;

        $service = Service::create($data);

        return response()->json($service, 201);
    }
}
