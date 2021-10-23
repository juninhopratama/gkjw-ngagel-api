<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\Ibadah;
use Carbon\Carbon;

class StatsController extends Controller
{
    public function index()
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
        $next = Carbon::parse($ibadah->tanggal_ibadah)->format('d M Y');

        if(!$ibadah){
            return response()->json([
                'message' => 'No ibadah found',                
            ], 404);
        }

        return view('stats', [
            'now' => $now,
            'next' => $next,
            'id_ibadah' => $ibadah->id,
            'registered' => $registered,
            'quota' => $quota,
            'remaining' => $remaining
        ]);
    }
}
