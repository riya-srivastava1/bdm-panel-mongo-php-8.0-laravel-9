<?php

namespace App\Http\Controllers;

use App\Models\WahArtistLog;
use Illuminate\Http\Request;

class ArtistLogController extends Controller
{

    public function index(Request $request)
    {
    //    $logs=WahArtistLog::take(10)->get();

       $logsQuery = WahArtistLog::query();

       if ($request->filled('a_id')) {
           $logsQuery->where('wah_artist_id', $request->input('a_id'));
       }

       $logs = $logsQuery->orderByDesc('created_at')->paginate(300);

       return view('wah.artist-log', compact('logs'));

    }
}
