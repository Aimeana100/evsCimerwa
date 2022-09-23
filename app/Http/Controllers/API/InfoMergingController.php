<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Admin\Vistor;
use Illuminate\Http\Request;
use App\Models\Admin\CardTap;
use App\Models\Admin\Employee;
use App\Http\Controllers\Controller;

class InfoMergingController extends Controller
{

    public function tap(Request $request)
    {
        // date_default_timezone_set('Africa/kigali');
       

        $employee = new Employee();
        $tap = new CardTap();
        $visitor = new Vistor();

        $currentTime = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));

        $tap_date = $request->tappedAt;

        // return response()->json(["data" => $request->key]);

        if ($request->key === "staff") {

            $staff = Employee::where(['ID_Card' => $request->idnumber])->get();


            if (count($staff) < 1) {
                $employee->names = $request->fullname;
                // $employee->gender = $request->gender;
                $employee->phone = $request->phonenumber;
                $employee->ID_Card = $request->idnumber;
                $employee->company = $request->residance;
                $employee->status = "IN";
                $employee->dateJoined = $currentTime;
                $employee->latestTap = $tap_date;
                try {
                    $employee->save();
                    $tap->user_id = $employee->id;
                    $tap->tapped_at = $request->tappedAt;
                    $tap->ID_Card = $employee->ID_Card;
                    $tap->card_type = "STAFF";
                    $tap->status = "ENTERING";
                    $tap->save();
                } catch (\Throwable $th) {
                    return response()->json(["error" => $th->errorInfo], 500);
                }

                return response()->json(["data" => ["user" => $employee, "previousTap" => null, "status" => "ENTERING"]]);
            } else {

                $tap->user_id = $staff[0]['id'];
                $tap->ID_Card = $staff[0]['ID_Card'];
                $tap->tapped_at = $request->tappedAt;
                $tap->card_type = "STAFF";
                $tap->status =  $staff[0]['status'] == "IN" ? "EXITING" : "ENTERING";
                Employee::where('ID_Card', $staff[0]['ID_Card'])->update(['status' => $staff[0]['status'] == "IN" ? "OUT" : "IN"]);
                Employee::where('ID_Card', $staff[0]['ID_Card'])->update(['latestTap' => $tap_date]);

                // $staff[0]->status = $staff[0]->status == "OUT" ? "IN" : "OUT";
                // try {
                //     $tap->save();
                // } catch (\Throwable $th) {
                //     return response()->json(["error" => $th->errorInfo], 500);
                // }
                return response()->json(["data" => ["user" => Employee::where('ID_Card', $staff[0]['ID_Card'])->get()[0], "previousTap" => null, "status" => $tap->status]]);
            }
        }


        //     \\ 
        // Vistor\\
        //\\
        //  \\


        if ($request->key === "visitor") {
            
            $currentTime = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
            $affectedRows = 0;
            $existingRecords = [];


            for ($i = 0; $i < count($request->all())-1; $i++) {
                // return response()->json(["cardTaps"=> count(CardTap::all()), "visitor"=> count(Vistor::all()) ]);

                $tap_date = $request[$i]['tappedAt'];

                $tap = new CardTap();
                $visitor = new Vistor();

                $visitor_staff = Vistor::where(['ID_Card' => $request[$i]['idnumber']])->first();


                // if (!in_array($request->reason, ["OWNS", "LOST", "UNDER"])) {
                //     return response()->json(["data" => $request->all(), "status" => "error", "message" => "Reason Error"], 201);
                // }

                if (!$visitor_staff) {

                    $visitor->names = $request[$i]['fullname'];
                    // $visitor->gender = $request[$i]['gender'];
                    $visitor->phone = $request[$i]['phonenumber'];
                    $visitor->ID_Card = $request[$i]['idnumber'];
                    $visitor->destination = $request[$i]['destination'];
                    $visitor->reason = "OWNS";
                    $visitor->status = "IN";
                    $visitor->dateJoined = $tap_date;
                    $visitor->latestTap = $tap_date;

                    // return response()->json(["data" => $visitor->save()]);

                    try {

                        $visitor->save();
                        $tap->user_id = $visitor->id;
                        $tap->ID_Card = $visitor->ID_Card;
                        $tap->tapped_at = $request[$i]['tappedAt'];
                        $tap->card_type = "VISTOR";
                        $tap->status = "ENTERING";

                        if($tap->save())
                        {$affectedRows++;}
                        
                    } catch (\Throwable $th) {
                        return response()->json(["error" => $th->errorInfo], 500);
                    }

                    // return response()->json(["data" => ["user" => "VISITOR", "previousTap" => null, "status" => "ENTERING"]], 200);
                } 
                else {

                    $existing_record = Vistor::where(['ID_Card' => $request[$i]['idnumber']])->get();

                    if ($visitor_staff->latestTap == $request[$i]['tappedAt']) {

                        // return response()->json(["data" => "skipped"]);
                        $affectedRows++;
                        array_push($existingRecords, $existing_record);

                        continue;
                    } else {

                        $tap->user_id = $visitor_staff['id'];
                        $tap->ID_Card = $visitor_staff['ID_Card'];
                        $tap->tapped_at = $request[$i]['tappedAt'];
                        $tap->card_type = "VISITOR";
                        $tap->status =  $visitor_staff['status'] == "IN" ? "EXITING" : "ENTERING";
                        Vistor::where('ID_Card', $visitor_staff['ID_Card'])->update(['status' => $visitor_staff['status'] == "IN" ? "OUT" : "IN"]);
                        Vistor::where('ID_Card', $visitor_staff['ID_Card'])->update(['latestTap' => $tap_date]);

                        try {
                        if($tap->save())
                        {$affectedRows++;}
                        } catch (\Throwable $th) {
                            return response()->json(["error" => $th->errorInfo], 500);
                        }
                        // return response()->json(["data" => ["user" => "VISITOR", "status" => "Updated"]]);
                    }
                }

                // return response()->json(["data" => $request->all('key')]);

            }
            return response()->json(["data" => $affectedRows, "repeated"=> $existingRecords]);
        } elseif ($request->key === "noid") {

            return response()->json(["data" => $request->all('key')]);
        } else {

            return response()->json(["data" => ['result' => "no id"]]);
        }
    }
}
