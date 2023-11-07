<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
     if($request->header('api_key') =='123'){
        return $next($request);
     }
     else{
        $data=[
            'status'=>200,
            'message'=>'Unauthorized',
        ];
        return response()->json($data);
     }

      
    }
}
