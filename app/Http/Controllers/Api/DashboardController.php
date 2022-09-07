<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

class DashboardController extends Controller
{

    public function index()
    {
        $user_count = User::count();
        return response()->json([
            'data' => [
                'user_count' => $user_count,
            ]
        ]);
    }
}
