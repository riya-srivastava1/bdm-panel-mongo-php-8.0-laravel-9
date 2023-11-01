<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WahArtistWwuRequest;

class WahArtistWwuRequestController extends Controller
{
    public function index(Request $request)
    {
        $artists = (new WahArtistWwuRequest())->newQuery();
        $artists->orderByDesc('created_at');
        if ($request->has('type') && $request->type == 'registered') {
            $artists->where('is_registered', true);
        } else {
            $artists->where('is_registered', '!=', true);
        }

        $artists = $artists->paginate(10);
        return view('wah.artist-wwu-request', compact('artists'));
    }
}
