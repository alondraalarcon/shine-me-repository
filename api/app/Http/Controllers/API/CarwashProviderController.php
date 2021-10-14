<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class CarwashProviderController extends Controller
{
    public function getcarwasher()
    {
        return response()->json([
            'customer' => User::all()->where('account_type','3'),
        ], 200); 
    }
}
