<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CountWebsiteViews
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($request->isMethod('GET') && ! $request->routeIs('admin.*')
            && $response->getStatusCode() === 200
            && str_starts_with((string) $response->headers->get('Content-Type'), 'text/html')) {
            DB::table('daily_page_views')->upsert(
                [['view_date' => now('Asia/Manila')->toDateString(), 'views' => 1]],
                ['view_date'],
                ['views' => DB::raw('views + 1')]
            );
        }

        return $response;
    }
}
