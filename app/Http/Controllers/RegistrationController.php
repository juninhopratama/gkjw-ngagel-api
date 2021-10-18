<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $registrations = Registration::all();

        if($registrations->isEmpty()){
            return response()->json([
                'message' => 'No Registrations Found'
            ], 404);
        };
        return response()->json([
            'data' => $registrations,
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
        // generate uuid
        $uuid = Uuid::uuid4();

        // check if generated uuid already exists
        do{
            $uuid = Uuid::uuid4();
            $uuidChecker = Registration::where('uuid', $uuid);
        }while($uuidChecker->count());

        $id_ibadah = $request->id_ibadah;
        $nik = $request->nik;
        $date_registered = Carbon::now();

        // select from db where id and nik
        $checker = Registration::where('id_ibadah', $id_ibadah)
            ->where('nik',$nik)
            ->get();

        // if user hasn't registered, store data
        if($checker->isEmpty()){
            $validator = Validator::make($request->all(), [
                'nama_jemaat' => 'required',
                'nik' => 'required',
                'id_ibadah' => 'required'
            ]);
    
            if($validator->fails()){
                return response()->json([
                    $validator->errors()
                ], 400);
            };

            $registration = Registration::create([
                'uuid' => $uuid,
                'nama_jemaat' =>$request->nama_jemaat,
                'nik' => $nik,
                'id_ibadah' => $id_ibadah,
                'date_registered' => $date_registered,
                'wilayah' => $request->wilayah,
                'kelompok' => $request->kelompok,
                'gereja_asal' => $request->gereja_asal,
                'isScanned' => false
            ]);

            if($registration){
                return response()->json([
                    'data' => $registration,
                    'message' => 'Created Successfully'
                ], 201);
            };

            return response()->json([
                'message' => 'Failed to create Ibadah'
            ], 409);
        }

        return response()->json([
            'message' => 'Error, already registered!'
        ], 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $registration = Registration::find($id);

        if(!$registration){
            return response()->json([
                'message' => 'No registration found'
            ], 404);
        };

        return response()->json([
            'data' => $registration,
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
            'nama_jemaat' => 'required',
            'nik' => 'required',
            'id_ibadah' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                $validator->errors()
            ], 400);
        };

        $registration = Registration::find($id);

        if(!$registration){
            return response()->json([
                'message' => 'No registration found'
            ], 404);
        };

        $registration->update([
            'nama_jemaat' =>$request->nama_jemaat,
            'nik' => $request->nik,
            'id_ibadah' => $request->id_ibadah,
            'wilayah' => $request->wilayah,
            'kelompok' => $request->kelompok,
            'gereja_asal' => $request->gereja_asal,
            'isScanned' => false
        ]);

        if($registration){
            return response()->json([
                'data' => $registration,
                'message' => 'Updated Successfully'
            ], 200);
        };

        return response()->json([
            'message' => 'Failed to update Ibadah'
        ], 409);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $registration = Registration::find($id);

        if(!$registration){
            return response()->json([
                'message' => 'No ibadah found'
            ], 404);
        };

        Registration::destroy($id);
        return response()->json([
            'message' => 'Ibadah Deleted',
            'deleted data' => $registration  
        ], 200);
    }

    public function uuid()
    {
        $uuid = Uuid::uuid4();
        $date_registered = Carbon::now();
        return response()->json([
            'uuid' => $uuid,
            'date' => $date_registered,
            'message' => 'Retrieved Successfully'
        ], 200);
    }
}
