<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\Ibadah;
use Carbon\Carbon;
use Exception;

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
        $nextDate = Carbon::parse($ibadah->tanggal_ibadah)->isoFormat('dddd, DD-M-YYYY');

        if(!$ibadah){
            return response()->json([
                'message' => 'No ibadah found',
            ], 404);
        }

        return response()->json([
            'now' => $now,
            'next' => $nextDate,
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

    public function nearestRegistered()
    {
        $now = Carbon::now()
            ->isoFormat('YYYY-MM-DD');

        $ibadah = Ibadah::where('tanggal_ibadah', '>=', $now)
            ->orderBy('tanggal_ibadah', 'ASC')
            ->first();

        $registration = Registration::where('id_ibadah', $ibadah->id)->get();

        return response()->json([
            'data' => $registration
        ], 200);
    }

    public function registered($id_ibadah)
    {
        try {
            $registration = Registration::where('id_ibadah', $id_ibadah)->orderBy('nama_jemaat', 'asc')->get();
            $ibadah = Ibadah::where('id', $id_ibadah)->first();
            if (!$ibadah) {
                return response()->json([
                    'error' => 'ID Ibadah Tidak Ditemukan!'
                ], 404);
            }else{
                return response()->json([
                    'nama_ibadah' => $ibadah->nama_ibadah,
                    'tanggal_ibadah' => Carbon::parse($ibadah->tanggal_ibadah)->isoFormat('dddd, DD-M-YYYY'),
                    'jam_ibadah' => $ibadah->jam_ibadah,
                    'data' => $registration
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
