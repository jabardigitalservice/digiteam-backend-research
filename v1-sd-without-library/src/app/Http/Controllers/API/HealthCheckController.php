<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HealthCheckController extends Controller
{
    public function __invoke(Request $request)
    {
        return [
            'application' => config('app.name'),
        ];
    }
}
