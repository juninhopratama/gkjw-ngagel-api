<?php

namespace App\Http\Controllers;

use App\Models\Ibadah;
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
        $nama_jemaat = $request->nama_jemaat;
        $dob = $request->dob;
        $date_registered = Carbon::now();

        // select from db where id and nik
        $checker = Registration::where('id_ibadah', $id_ibadah)
            ->where('dob',$dob)
            ->where('nama_jemaat', $nama_jemaat)
            ->get();

        // check if quota still available
        $ibadah = Ibadah::where('id', $id_ibadah)->first();
        $quota = $ibadah->quota;
        $registration = Registration::where('id_ibadah', $id_ibadah)->get();
        $registered = count($registration);
        $remaining = $quota - $registered;
        if ($remaining <= 0) {
            return response()->json([
                'message' => 'Quota Penuh!'
            ], 400);
        }else {
             // if user hasn't registered, store data
            if($checker->isEmpty()){
                $validator = Validator::make($request->all(), [
                    'nama_jemaat' => 'required',
                    'dob' => 'required',
                    'id_ibadah' => 'required'
                ]);

                if($validator->fails()){
                    return response()->json([
                        $validator->errors()
                    ], 400);
                };

                $gereja_asal = $request->gereja_asal;
                if(!$gereja_asal){
                    $gereja_asal = 'GKJW Ngagel';
                }

                $wilayah = $request->wilayah;
                if(!$wilayah){
                    $wilayah = '0';
                }

                $kelompok = $request->kelompok;
                if(!$kelompok){
                    $kelompok = '0';
                }

                $registration = Registration::create([
                    'uuid' => $uuid,
                    'nama_jemaat' =>$request->nama_jemaat,
                    'dob' => $dob,
                    'id_ibadah' => $id_ibadah,
                    'date_registered' => $date_registered,
                    'wilayah' => $wilayah,
                    'kelompok' => $kelompok,
                    'gereja_asal' => $gereja_asal,
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
            }else {
                return response()->json([
                    'message' => 'Error, already registered!'
                ], 400);
            }
        }
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
            'dob' => 'required',
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

        $gereja_asal = $request->gereja_asal;
            if(!$gereja_asal){
                $gereja_asal = 'GKJW Ngagel';
            }

            $wilayah = $request->wilayah;
            if(!$wilayah){
                $wilayah = '0';
            }

            $kelompok = $request->kelompok;
            if(!$kelompok){
                $kelompok = '0';
            }

        $registration->update([
            'nama_jemaat' =>$request->nama_jemaat,
            'dob' => $request->dob,
            'id_ibadah' => $request->id_ibadah,
            'wilayah' => $wilayah,
            'kelompok' => $kelompok,
            'gereja_asal' => $gereja_asal,
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
