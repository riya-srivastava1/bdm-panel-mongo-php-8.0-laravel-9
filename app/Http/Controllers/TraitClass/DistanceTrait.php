<?php

namespace App\Http\Controllers\TraitClass;

trait DistanceTrait
{
    public function getDistanceWithLatLng($lat1, $lon1, $lat2, $lon2, $unit = 'K')
    {
        if (empty($lat1) || empty($lon1) || empty($lat2) || empty($lon2)) {
            return null;
        }
        $result = 0;
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            $result = 0;
        } else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $result = $miles / 0.00062137;
        }
        return $result;
    }
}
