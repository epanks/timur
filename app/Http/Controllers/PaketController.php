<?php

namespace App\Http\Controllers;

use App\Paket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dtpaket = Paket::where('wilayah_id',2)->paginate();
        return response()->json($dtpaket, 200);
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
            'nmpaket' => 'required|min:3',
            'image' => 'required|image|mimes:jpeg,png,jpg'
        ]);

        $paket = new Paket();
        $paket->nmpaket = $request->nmpaket;

        $path = $request->file('image')->store('paket_images');

        $paket->image = $path;

        if ($paket->save()) {
            return response()->json($paket, 200);
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
     * @param  \App\Paket  $paket
     * @return \Illuminate\Http\Response
     */
    public function show(Paket $paket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Paket  $paket
     * @return \Illuminate\Http\Response
     */
    public function edit(Paket $paket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Paket  $paket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Paket $paket)
    {
        $request->validate([
            'nmpaket' => 'required|min:3',
        ]);

        $paket->nmpaket = $request->nmpaket;

        $oldPath = $paket->image;
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg',
            ]);
            $path = $request->file('image')->store('paket_images');
            $paket->image = $path;

            Storage::delete($oldPath);
        }
        
        if ($paket->save()) {
            return response()->json($paket, 200);
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
     * @param  \App\Paket  $paket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Paket $paket)
    {
        if ($paket->delete()) {
            Storage::delete($paket->image);
            return response()->json([
                'message' => 'paket delete subggcgxy  ujadjappppsdjjjddddddddddjwsjd9',
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
