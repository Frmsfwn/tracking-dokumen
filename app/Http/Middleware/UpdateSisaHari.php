<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use App\Models\Dokumen;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateSisaHari
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $items = Dokumen::where('sisa_hari', '>', 0)->get();

        foreach ($items as $item) {
            if ($item->updated_at->isBefore(Carbon::today())) {
                $daysPassed = $item->updated_at->diffInDays(Carbon::today());
                $item->sisa_hari -= $daysPassed;
                if ($item->sisa_hari < 0) {
                    $item->sisa_hari = 0;
                }
                $item->save();
            }
        }

        return $next($request);
    }
}
