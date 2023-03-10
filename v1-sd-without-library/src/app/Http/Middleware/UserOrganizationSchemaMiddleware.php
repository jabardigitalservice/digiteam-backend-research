<?php

namespace App\Http\Middleware;

use App\Models\Organization;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class UserOrganizationSchemaMiddleware
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
        $organizations = $request->user()->organization->pluck('schema')->toArray();
        $organizationRequest = Organization::where('slug', $request->organization)->first();

        $schema = $organizationRequest?->schema;
        if (!in_array($schema, $organizations)) {
            return response()->format(Response::HTTP_FORBIDDEN, 'Permission Denied For Access Schema');
        }

        Config::set('database.connections.pgsql.search_path', $schema);

        return $next($request);
    }
}
