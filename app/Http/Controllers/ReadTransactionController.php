<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ReadTransactionController extends Controller
{
    public function index(){
        $transaction = DB::table('transactions')
                        ->join('customers', 'transactions.id_customer', '=', 'customers.id')
                        ->join('users', 'transactions.id_user', '=', 'users.id')
                        ->join('prescriptions', 'transactions.id_prescription', '=', 'prescriptions.id')
                        ->join('obats', 'prescriptions.id_obat', '=', 'obats.id')
                        ->select('*')
                        ->get();

        return response()->json([
            'data' => $transaction
        ], 200);
    }

    public function getTransaction(Request $request){
        $validation = Validator::make($request->all(),[
            "id_prescription" => 'required'
        ]);

        if($validation->fails()){
            return response()->json([
                'error' => $validation->errors()
            ], 400);
        }

        $id = $request->id_prescription;

        $getTrans = DB::table('prescriptions')
                    ->where('prescriptions.id_resep', '=', $id)
                    ->join('obats', 'prescriptions.id_obat', '=', 'obats.id')
                    ->select('prescriptions.id', 'prescriptions.jumlah_obat', 'obats.harga')
                    ->get();

        return response()->json([
            'data' => $getTrans
        ], 200);
    }
}
