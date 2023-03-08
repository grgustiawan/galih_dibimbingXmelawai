<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer = Customer::paginate(10);
        return response()->json([
            'data' => $customer
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
            'nama_customer' => 'required|max:150',
            'dob'           => 'required',
            'email'         => 'required|email',
            'alamat'        => 'required'
        ],[
            'nama_customer.required'   => 'Nama harus diisi',
            'nama_customer.max'        => 'Nama maksimal 150 karakter',
            'dob.requried'    => 'Tanggal lahir harus diisi',
            'email.required'  => 'Email harus diisi',
            'email.email'     => 'Format email tidak valid',
            'alamat.requried' => 'Alamat harus diisi'
        ]);

        if($validation->fails()){
            return response()->json([
                'error' => $validation->errors()
            ], 400);
        }

        $customer = Customer::create([
            'nama_customer' => $request->nama_customer,
            'id_customer'   => Str::uuid(),
            'dob'           => $request->dob,
            'email'         => $request->email,
            'alamat'        => $request->alamat
        ]);

        return response()->json([
            'message' => 'Tambah customer berhasil',
            'data' => $customer
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        return response()->json([
            'data' => $customer
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $validation = Validator::make($request->all(),[
            'nama_customer' => 'required|max:150',
            'dob'           => 'required',
            'email'         => 'required|email',
            'alamat'        => 'required'
        ],[
            'nama_customer.required'   => 'Nama harus diisi',
            'nama_customer.regex'      => 'Nama hanya boleh mengandung huruf',
            'dob.requried'    => 'Tanggal lahir harus diisi',
            'email.required'  => 'Email harus diisi',
            'email.email'     => 'Format email tidak valid',
            'alamat.requried' => 'Alamat harus diisi'
        ]);

        if($validation->fails()){
            return response()->json([
                'error' => $validation->errors()
            ], 400);
        }

        $customer->nama_customer   = $request->nama_customer;
        $customer->dob    = $request->dob;
        $customer->email  = $request->email;
        $customer->alamat = $request->alamat; 
        $customer->save();

        return response()->json([
            'message' => 'Update customer berhasil',
            'data' => $customer
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return response()->json([
            'message' => 'Customer deleted'
        ], 204);
    }
}
