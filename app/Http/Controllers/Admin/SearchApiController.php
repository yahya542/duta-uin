<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;

class SearchApiController extends Controller
{
    public function getData(Request $request)
    {
        $type = $request->query('type');
        
        switch ($type) {
            case 'candidates':
                return response()->json(Candidate::orderBy('name')->get());
            case 'users':
                return response()->json(User::orderBy('name')->get());
            case 'transactions':
                return response()->json(Transaction::with(['candidate', 'vote'])->orderBy('created_at', 'desc')->get());
            default:
                return response()->json(['error' => 'Invalid type'], 400);
        }
    }
}
