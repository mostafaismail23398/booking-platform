@extends('layouts.app')

@section('title', 'Visitor Stats')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Visitor stats</h1>

    <div class="grid sm:grid-cols-3 gap-4 mb-8">
        <div class="border rounded-lg p-5 bg-white">
            <p class="text-sm text-gray-500">Total page views</p>
            <p class="text-3xl font-bold">{{ number_format($totalViews) }}</p>
        </div>
        <div class="border rounded-lg p-5 bg-white">
            <p class="text-sm text-gray-500">Views today</p>
            <p class="text-3xl font-bold">{{ number_format($todayViews) }}</p>
        </div>
        <div class="border rounded-lg p-5 bg-white">
            <p class="text-sm text-gray-500">Unique visitors today</p>
            <p class="text-3xl font-bold">{{ number_format($uniqueVisitorsToday) }}</p>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <div class="border rounded-lg p-5 bg-white">
            <h2 class="font-semibold mb-3">Top pages</h2>
            <ul class="text-sm divide-y">
                @foreach ($topPages as $page)
                    <li class="flex justify-between py-1.5">
                        <span>{{ $page->path }}</span>
                        <span class="text-gray-500">{{ $page->views }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="border rounded-lg p-5 bg-white">
            <h2 class="font-semibold mb-3">Last 7 days</h2>
            <ul class="text-sm divide-y">
                @foreach ($last7Days as $day)
                    <li class="flex justify-between py-1.5">
                        <span>{{ $day->day }}</span>
                        <span class="text-gray-500">{{ $day->views }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
