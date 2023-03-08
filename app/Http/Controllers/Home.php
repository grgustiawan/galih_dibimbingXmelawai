<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Home extends Controller
{
    public function index(){
        $customers = DB::table('customers')
                    ->select('*')
                    ->get();

        $countCustomers = count($customers);

        $obat = DB::table('obats')
                ->select('*')
                ->get();
        
        $countObat = count($obat);

        $resep = DB::table('prescriptions')
                ->select('*')
                ->get();
        
        $countResep = count($resep);

        $transaction = DB::table('transactions')
                     ->select('*')
                     ->get();
        
        $countTransaction = count($transaction);

        return response()->json([
            'obat'          => $countObat,
            'resep'         => $countResep,
            'transaction'   => $countTransaction,
            'customers'     => $countCustomers
        ], 200);
    }
}
