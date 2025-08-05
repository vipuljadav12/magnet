<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\URL;
use App\AuditTrail;
use Illuminate\Support\Facades\Auth;

class FilterAll
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $data["user_id"] = isset(Auth::user()->id) ? Auth::user()->id : null;
        $data["previous_url"] = URL::previous();
        $data["path"] = $request->path();
        $data["method"] = $request->method();
        $data["attributes"] = json_encode($request->all());
        // $data["response"] = json_encode($response->content());
        $data["status_code"] = $response->status();

        AuditTrail::create($data);
        return $next($request);
    }
}
