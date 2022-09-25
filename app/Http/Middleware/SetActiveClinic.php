<?php

namespace App\Http\Middleware;

use App\Models\Clinic;
use Closure;
use Illuminate\Http\Request;

class SetActiveClinic
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $domain = $request->getHost();
        $arr = explode('.', $domain);
        $subDomain = $arr[0];
        $clinic = Clinic::where('domain', $subDomain)->Where('active',1)->firstOrFail();
        app()->instance('clinic.active',$clinic);
        return $next($request);
    }
}
