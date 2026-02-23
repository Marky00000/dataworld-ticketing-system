<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Get all tech users for assignment
     */
    public function getTechUsers()
    {
        try {
            $techs = User::where('user_type', 'tech')
                ->where('is_active', true)
                ->orderBy('name')
                ->get(['id', 'name', 'email', 'phone']);
            
            return response()->json([
                'success' => true,
                'data' => $techs,
                'count' => $techs->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading technicians: ' . $e->getMessage()
            ], 500);
        }
    }
}