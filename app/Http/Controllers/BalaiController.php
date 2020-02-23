<?php

namespace App\Http\Controllers;

use App\Balai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BalaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dtbalai = Balai::where('wilayah_id',2)->paginate();
        return response()->json($dtbalai, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
        ]);

        $balai = new Balai();
        $balai->name = $request->name;

        if ($balai->save()) {
            return response()->json($balai, 200);
        } else {
            return response()->json([
                'message' => 'Some error occured ulangi lagi',
                'status_code' => 500
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Balai  $balai
     * @return \Illuminate\Http\Response
     */
    public function show(Balai $balai)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Balai  $balai
     * @return \Illuminate\Http\Response
     */
    public function edit(Balai $balai)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Balai  $balai
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Balai $balai)
    {
        $request->validate([
            'name' => 'required|min:3',
        ]);

        $balai->name = $request->name;
        
        if ($balai->save()) {
            return response()->json($balai, 200);
        } else {
            return response()->json([
                'message' => 'Some error occured coba lagi',
                'status_code' => 500
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Balai  $balai
     * @return \Illuminate\Http\Response
     */
    public function destroy(Balai $balai)
    {
        if ($balai->delete()) {
            return response()->json([
                'message' => 'balai delete subggcgxy  ujadjappppsdjjjddddddddddjwsjd9',
                'status_code' => 200
            ], 200);
        } else {
            return response()->json([
                'message' => 'Gak bisa di delete',
                'status_code' => 500
            ], 500);
        }
    }
}
