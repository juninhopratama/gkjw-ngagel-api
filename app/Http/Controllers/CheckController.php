<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\Ibadah;
use Carbon\Carbon;

class CheckController extends Controller
{
    public function check($id)
    {
        $quota = Ibadah::find($id);
        $quota = $quota->quota;
        $registration = Registration::where('id_ibadah', $id)->get();
        $registered = count($registration);
        $remaining = $quota - $registered;
        return response()->json([
            'registered' => $registered,
            'quota' => $quota,
            'remaining' => $remaining
        ], 200);
    }

    public function nearest()
    {
        $now = Carbon::now()
            ->isoFormat('YYYY-MM-DD');

        $ibadah = Ibadah::where('tanggal_ibadah', '>=', $now)
            ->orderBy('tanggal_ibadah', 'ASC')
            ->first();
        
        $quota = $ibadah->quota;
        $registration = Registration::where('id_ibadah', $ibadah->id)->get();
        $registered = count($registration);
        $remaining = $quota - $registered;

        if(!$ibadah){
            return response()->json([
                'message' => 'No ibadah found',                
            ], 404);
        }
        
        return response()->json([
            'now' => $now,
            'next' => $ibadah->tanggal_ibadah,
            'id_ibadah' => $ibadah->id,
            'registered' => $registered,
            'quota' => $quota,
            'remaining' => $remaining
        ], 200);
    }

    public function qrChecker($uuid)
    {
        $registered = Registration::where('uuid', $uuid)->first();

        if(!$registered){
            return response()->json([
                'message' => 'Scan code invalid!',                
            ], 404);
        }

        $isScanned = $registered->isScanned;
        if($isScanned == 0){
            $registered->update([
                'isScanned' => true
            ]);
            return response()->json([
                'name' => $registered->nama_jemaat,
                'message' => 'QR code successfully scanned!'
            ], 200);
        }

        return response()->json([
            'name' => $registered->nama_jemaat,
            'message' => 'Code has been scanned!'
        ], 200);
    }
}
