@extends('layouts.app')

@section('title', 'Add a Service')

@section('content')
    <div class="max-w-xl mx-auto bg-white border rounded-lg p-6">
        <h1 class="text-xl font-bold mb-4">Add a new service</h1>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('services.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="text-sm font-medium block mb-1">Category</label>
                <select name="category_id" required class="border rounded px-3 py-2 w-full">
                    <option value="">Select a category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @if ($categories->isEmpty())
                    <p class="text-xs text-gray-500 mt-1">
                        No categories yet — add one first (e.g. via <code>php artisan tinker</code>
                        or a seeder: <code>Category::create(['name' => 'Web Development', 'slug' => 'web-development']);</code>)
                    </p>
                @endif
            </div>

            <div>
                <label class="text-sm font-medium block mb-1">Title</label>
                <input type="text" name="title" value="{{ old('title') }}" required
                       placeholder="e.g. I will build your Laravel + Angular app"
                       class="border rounded px-3 py-2 w-full">
            </div>

            <div>
                <label class="text-sm font-medium block mb-1">Description</label>
                <textarea name="description" rows="5" required
                          class="border rounded px-3 py-2 w-full">{{ old('description') }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium block mb-1">Price ($)</label>
                    <input type="number" name="price" step="0.01" min="0" value="{{ old('price') }}" required
                           class="border rounded px-3 py-2 w-full">
                </div>
                <div>
                    <label class="text-sm font-medium block mb-1">Delivery (days)</label>
                    <input type="number" name="delivery_days" min="1" value="{{ old('delivery_days', 3) }}" required
                           class="border rounded px-3 py-2 w-full">
                </div>
            </div>

            <button class="bg-blue-600 text-white w-full py-2 rounded hover:bg-blue-700">
                Publish service
            </button>
        </form>
    </div>
@endsection
