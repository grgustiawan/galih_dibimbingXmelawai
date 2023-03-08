<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResepController extends Controller
{
    public function index(){

        $resep = DB::table('prescriptions')
                ->join('customers', 'prescriptions.id_customer', '=', 'customers.id')
                ->join('users', 'prescriptions.id_user', '=', 'users.id')
                ->join('obats', 'prescriptions.id_obat', '=', 'obats.id')
                ->select('*')
                ->get();


        return response()->json([
            'data' => $resep
        ], 200);
    }
}
