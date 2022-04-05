<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\Ibadah;
use Carbon\Carbon;

class CheckControllerV2 extends Controller
{
    public function nearestV2()
    {
        $nextSunday = strtotime('next sunday');
        $n = gmdate('Y-m-d', $nextSunday);

        $now = Carbon::now()
            ->isoFormat('YYYY-MM-DD');

        $ibadah = Ibadah::whereBetween('tanggal_ibadah', [$now, $n])
        ->orderBy('tanggal_ibadah', 'ASC')
        ->get();

        // $quota = $ibadah->quota;
        // $registration = Registration::where('id_ibadah', $ibadah->id)->get();
        // $registered = count($registration);
        // $remaining = $quota - $registered;
        // $nextDate = Carbon::parse($ibadah->tanggal_ibadah)->isoFormat('dddd, DD-M-YYYY');

        $ibadahs = array();

        // $ibadahs["ibadahs"] = array(
        //     "id5" => "q",
        //     "id6" => "e");

        // $ibadahs["ibadahse"] = array(
        //     "id5" => "q",
        //     "id6" => "e");

        foreach ($ibadah as $i) {
            $quota = $i->quota;
            $registration = Registration::where('id_ibadah', $i->id)->get();
            $registered = count($registration);
            $remaining = $quota - $registered;
            $nextDate = Carbon::parse($i->tanggal_ibadah)->isoFormat('dddd, DD-M-YYYY');
            $ibadahs[$i->id] = array(
                'nama_ibadah' => $i->nama_ibadah,
                'next' => $nextDate,
                'jam_ibadah' => $i->jam_ibadah,
                'id_ibadah' => $i->id,
                'registered' => $registered,
                'quota' => $quota,
                'remaining' => $remaining);
        }

        if(!$ibadah){
            return response()->json([
                'message' => 'No ibadah found',
            ], 404);
        }

        return response()->json([
            'ibadah' => $ibadahs
        ], 200);
    }
}
