<?php

namespace App\Http\Controllers;

use App\Models\employee;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getDistance($lat1, $lng1, $lat2, $lng2, $unit = 'miles')
    {
        $theta = $lng1 - $lng2;
        $distance = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $distance = acos($distance);
        $distance = rad2deg($distance);
        $distance = $distance * 60 * 1.1515;
        switch ($unit) {
            case 'miles': {
                    break;
                }
            case 'kilometers': {
                    $distance = $distance * 1.609344;
                }
        }
        return (round($distance, 2));
    }

 
}
