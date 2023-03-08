<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ObatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $obat = Obat::paginate(10);
        return response()->json([
            'data' => $obat
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
            'nama_obat' => 'required',
            'merek'     => 'required',
            'stock'     => 'required',
            'harga'     => 'required',
            'expired_date'  => 'required',
        ]);

        if($validation->fails()){
            return response()->json([
                'error' => $validation->errors()
            ]);
        }

        $obat = Obat::create([
            'nama_obat' => $request->nama_obat,
            'merek'     => $request->merek,
            'stock'     => $request->stock,
            'harga'     => $request->harga,
            'expired_date'  => $request->expired_date,
        ]);

        return response()->json([
            'message' => 'Tambah obat berhasil',
            'data' => $obat,
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Obat  $obat
     * @return \Illuminate\Http\Response
     */
    public function show(Obat $obat)
    {
        return response()->json([
            'data' => $obat
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Obat  $obat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Obat $obat)
    {
        $validation = Validator::make($request->all(),[
            'nama_obat' => 'required',
            'merek'     => 'required',
            'stock'     => 'required',
            'harga'     => 'required',
            'expired_date'  => 'required',
        ]);

        if($validation->fails()){
            return response()->json([
                'error' => $validation->errors()
            ]);
        }
        
        $obat->nama_obat = $request->nama_obat;
        $obat->merek     = $request->merek;
        $obat->stock     = $request->stock;
        $obat->harga     = $request->harga; 
        $obat->expired_date = $request->expired_date;
        $obat->save();

        return response()->json([
            'message' => 'Obat berhasil dipudate',
            'data' => $obat
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Obat  $obat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Obat $obat)
    {
        $obat->delete();
        return response()->json([
            'message' => 'Obat berhasil dihapus'
        ]);
    }
}
