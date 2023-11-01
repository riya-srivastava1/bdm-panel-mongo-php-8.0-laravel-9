<?php

namespace App\Http\Controllers;

use App\Mail\ArtistStatus\BlockArtistToAdminMail;
use App\Mail\ArtistStatus\UnBlockArtistToAdminMail;
use App\WahArtist;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ArtistStatusController extends Controller
{
    public function blockArtist(Request $request, $id)
    {
        $request->validate([
            'valid_till' => 'required',
            'block_type' => 'required',
            'remark' => 'required',
        ]);
        try {
            $artist = WahArtist::findOrFail($id);
            $artist->is_block = true;
            $artist->block_type = $request->block_type;
            $artist->valid_till = date('Y-m-d', strtotime($request->valid_till));
            $artist->remark = $request->remark;
            $artist->save();

            Mail::to(['isaac@zoylee.com', 'bikash@zoylee.com'])
                ->cc('vishal@zoylee.com')
                ->send(new BlockArtistToAdminMail($artist));
            return back()->with('success', 'Successfully Updated');
        } catch (Exception $ex) {
            report($ex);
            return back()->with('error', 'something went wrogn!');
        }
    }

    public function updateBlockArtist(Request $request, $id)
    {
        $request->validate([
            'valid_till' => 'required',
            'block_type' => 'required',
            'remark' => 'required',
        ]);
        try {
            $artist = WahArtist::findOrFail($id);
            $artist->is_block = true;
            $artist->block_type = $request->block_type;
            $artist->valid_till = date('Y-m-d', strtotime($request->valid_till));
            $artist->remark = $request->remark;
            $artist->save();

            Mail::to(['isaac@zoylee.com', 'bikash@zoylee.com'])
                ->cc('vishal@zoylee.com')
                ->send(new BlockArtistToAdminMail($artist, 'update'));
            return back()->with('success', 'Successfully Updated');
        } catch (Exception $ex) {
            report($ex);
            return back()->with('error', 'something went wrogn!');
        }
    }

    public function unBlockArtist(Request $request, $id)
    {
        try {
            $artist = WahArtist::findOrFail($id);
            $artist->is_block = false;
            $artist->save();

            Mail::to(['isaac@zoylee.com', 'bikash@zoylee.com'])
                ->cc('vishal@zoylee.com')
                ->send(new UnBlockArtistToAdminMail($artist));
            return back()->with('success', 'Successfully Updated');
        } catch (Exception $ex) {
            report($ex);
            return back()->with('error', 'something went wrogn!');
        }
    }
}
