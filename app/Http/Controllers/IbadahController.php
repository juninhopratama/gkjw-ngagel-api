<?php

namespace App\Http\Controllers;

use App\Models\Ibadah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IbadahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ibadahs = Ibadah::all();

        if($ibadahs->isEmpty()){
            return response()->json([
                'message' => 'No Ibadah Found'
            ], 404);
        };
        return response()->json([
            'data' => $ibadahs,
            'message' => 'Retrieved Successfully'
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal_ibadah' => 'required',
            'quota' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                $validator->errors()
            ], 400);
        };

        $ibadah = Ibadah::create($request->all());

        if($ibadah){
            return response()->json([
                'data' => $ibadah,
                'message' => 'Created Successfully'
            ], 201);
        };

        return response()->json([
            'message' => 'Failed to create Ibadah'
        ], 409);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ibadah = Ibadah::find($id);
        
        if(!$ibadah){
            return response()->json([
                'message' => 'No ibadah found'
            ], 404);
        };

        return response()->json([
            'data' => $ibadah,
            'message' => 'Retrieved Successfully'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'tanggal_ibadah' => 'required',
            'quota' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                $validator->errors()
            ], 400);
        };

        $ibadah = Ibadah::find($id);

        if(!$ibadah){
            return response()->json([
                'message' => 'No ibadah found'
            ], 404);
        };

        $ibadah->update([
            'tanggal_ibadah' => $request->tanggal_ibadah,
            'quota' => $request->quota
        ]);

        return response()->json([
            'message' => 'Ibadah Updated',
            'data'    => $ibadah  
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ibadah = Ibadah::find($id);

        if(!$ibadah){
            return response()->json([
                'message' => 'No ibadah found'
            ], 404);
        };

        Ibadah::destroy($id);
        return response()->json([
            'message' => 'Ibadah Deleted',
            'deleted data'    => $ibadah  
        ], 200);

    }
}
