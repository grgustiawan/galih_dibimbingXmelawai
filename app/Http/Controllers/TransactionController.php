<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transaction = Transaction::paginate(10);
        return response()->json([
            'data' => $transaction
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $validation = Validator::make($request->all(),[
            'id_customer'       => 'required',
            'id_user'           => 'required',
            'id_prescription'   => 'required',
            'total'             => 'required',
            'tax'               => 'required',
            'grand'             => 'required',
        ]);

        if($validation->fails()){
            return response()->json([
                'error' => $validation->errors()
            ], 400);
        }

        $transaction = Transaction::create([
            'id_customer'       => $request->id_customer,
            'id_user'           => $request->id_user,
            'id_prescription'   => $request->id_prescription,
            'total'             => $request->total,
            'tax'               => $request->tax,
            'grand'             => $request->grand
        ]);

        return response()->json([
            'message' => 'Transaksi berhasil',
            'data' => $transaction
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        return response()->json([
            'data' => $transaction
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        $validation = Validator::make($request->all(),[
            'id_customer'       => 'required',
            'id_user'           => 'required',
            'id_prescription'   => 'required',
            'total'             => 'required',
            'tax'               => 'required',
            'grand'             => 'required',
        ]);

        if($validation->fails()){
            return response()->json([
                'error' => $validation->errors()
            ], 400);
        }

        $transaction->id_customer       = $request->id_customer;
        $transaction->id_user           = $request->id_user;
        $transaction->id_prescription   = $request->id_prescription;
        $transaction->total             = $request->total;
        $transaction->tax               = $request->tax;
        $transaction->grand             = $request->grand;
        $transaction->save();

        return response()->json([
            'message' => 'Update transaksi berhasil',
            'data' => $transaction
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return response()->json([
            'message' => 'Transaction deleted'
        ], 204);
    }
}
