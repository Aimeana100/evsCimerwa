<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\CardTap;
use App\Models\Admin\Vistor;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function createDateString($dates)
    {
        $dates = date('Y-m-d', strtotime($dates));
        return $dates;
    }

    public function index()
    {
        // $vistors = Vistor::with('taps')->paginate(3);
        $vistors = Vistor::with('taps')->get();
        // dd($vistors[0]->taps);

        $ArrSorted = [];

        foreach ($vistors as $Cvistitor) {

            $v_id = '';
            foreach ($Cvistitor->taps as $CvistitorTap) {



                if (isset($ArrSorted[date('Y-m-d', strtotime($CvistitorTap->tapped_at))])) {

                    if (isset($CvistitorTap['dayTap'])) {

                        array_push($CvistitorTap['dayTap'], $CvistitorTap);
                    } else {
                        $CvistitorTap['dayTap'] = $CvistitorTap;
                    }

                    array_push($ArrSorted[date('Y-m-d', strtotime($CvistitorTap->tapped_at))], $Cvistitor);
                } else {
                    if (isset($CvistitorTap['dayTap'])) {
                        array_push($CvistitorTap['dayTap'], $CvistitorTap->tapped_at);
                    } else {
                        $CvistitorTap['dayTap'] = $CvistitorTap->tapped_at;
                    }


                    $ArrSorted[date('Y-m-d', strtotime($CvistitorTap->tapped_at))] = [$Cvistitor];
                }
            }
            // else{
            //     $v_id = $Cvistitor->ID_Card;
            //     continue;
            // }

            // array_push( $ArrSorted, $CvistitorTap);



            // echo ($v_id );

        }

        // dd($ArrSorted);

        // dd(Vistor::distinct()->get(['ID_Card']));
        dd(Vistor::with('taps')->where('ID_Card','1197880049446058')->get());
        dd(count(Vistor::where('status','IN')->get()) , count(Vistor::where('status','OUT')->get()));
        

        return view('report', ['vistors' => $ArrSorted]);
    }
}
