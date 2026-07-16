<?php

namespace App\Http\Middleware;

use App\Models\PageView;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisit
{
    /**
     * Logs a lightweight, privacy-friendly page view.
     * IP is hashed (never stored raw) and only GET page loads are counted,
     * not API/asset requests.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethod('get')
            && ! $request->is('api/*')
            && ! $request->is('build/*')
            && ! $request->is('storage/*')
            && ! $request->ajax()) {
            try {
                PageView::create([
                    'path' => '/' . ltrim($request->path(), '/'),
                    'ip_hash' => hash('sha256', $request->ip() . config('app.key')),
                    'user_agent' => substr((string) $request->userAgent(), 0, 255),
                    'visited_at' => now(),
                ]);
            } catch (\Throwable $e) {
                // Never let analytics break the site.
                report($e);
            }
        }

        return $next($request);
    }
}
