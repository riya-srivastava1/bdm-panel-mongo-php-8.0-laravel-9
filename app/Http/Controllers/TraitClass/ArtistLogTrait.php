<?php

namespace App\Http\Controllers\TraitClass;

use App\WahArtistLog;

trait ArtistLogTrait
{
    public function UpdateArtistLog($wah_artist_id, $title, $description, $color_code)
    {
        $artist = new WahArtistLog();
        $artist->wah_artist_id = $wah_artist_id;
        $artist->title = $title;
        $artist->description = $description;
        $artist->color_code = $color_code;
        $artist->save();
    }
}
