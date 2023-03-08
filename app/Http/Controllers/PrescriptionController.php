<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PrescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prescription = Prescription::paginate(10);
        return response()->json([
            'data' => $prescription
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
            'id_customer'   => 'required',
            'id_user'       => 'required',
            'id_obat'       => 'required',
            'jumlah_obat'   => 'required'
        ],[
            'id_customer.requried'  => 'Customer harus diisi',
            'id_user.required'      => 'Pegawai harus diisi',
            'id_obat.required'      => 'Obat harus diisi',
            'jumlah_obat.required'  => 'Jumlah obat harus diisi'
        ]);

        if($validation->fails()){
            return response()->json([
                'error' => $validation->errors()
            ], 400);
        }

        $prescription = Prescription::create([
            'id_resep'      => Str::uuid(),
            'id_customer'   => $request->id_customer,
            'id_user'       => $request->id_user,
            'id_obat'       => $request->id_obat,
            'jumlah_obat'   => $request->jumlah_obat
        ]);

        return response()->json([
            'message' => 'Tambah resep berhasil',
            'data' => $prescription
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Prescription  $prescription
     * @return \Illuminate\Http\Response
     */
    public function show(Prescription $prescription)
    {
        return response()->json([
            'data' => $prescription
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Prescription  $prescription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Prescription $prescription)
    {
        $validation = Validator::make($request->all(),[
            'id_customer'   => 'required',
            'id_user'       => 'required',
            'id_obat'       => 'required',
            'jumlah_obat'   => 'required'
        ],[
            'id_customer.requried'  => 'Customer harus diisi',
            'id_user.required'      => 'Pegawai harus diisi',
            'id_obat.required'      => 'Obat harus diisi',
            'jumlah_obat.required'  => 'Jumlah obat harus diisi'
        ]);

        if($validation->fails()){
            return response()->json([
                'error' => $validation->errors()
            ], 400);
        }
        
        $prescription->id_customer  = $request->id_customer;
        $prescription->id_user      = $request->id_user;
        $prescription->id_obat      = $request->id_obat;
        $prescription->jumlah_obat  = $request->jumlah_obat;
        $prescription->save();

        return response()->json([
            'message' => 'Ubah resep berhasil',
            'data' => $prescription
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Prescription  $prescription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prescription $prescription)
    {
        $prescription->delete();
        return response()->json([
            'message' => 'Prescription deleted'
        ], 204);
    }
}
