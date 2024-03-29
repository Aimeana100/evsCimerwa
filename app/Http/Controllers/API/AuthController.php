<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Admin\Vistor;
use Illuminate\Http\Request;
use App\Models\Admin\CardTap;
use App\Models\Admin\Employee;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\isEmpty;
use PHPUnit\Framework\Constraint\IsEmpty;

class AuthController extends Controller
{
    public function auth(Request $request)
    {
        $credentials =  ['email' => $request->username, 'password' => $request->password];

        Auth::attempt($credentials);
        if (Auth::check()) {
            return response()->json(["data" => ["user" => Auth::user(), 'result' => "sussess"]], 200);
        } elseif (!User::where('email', '=', $request->username)->exist()) {
            return response()->json(["data" => ["user" => null, 'result' => "error", "message" => "Username doesn't matches"]], 200);
        } elseif (User::where('email', '=', $request->username)->exist()) {
            return response()->json(["data" => ["user" => null, 'result' => "error", "message" => "Password doesn't matches"]], 200);
        } else {
            return response()->json(["data" => ["user" => null, 'result' => "error", "message" => "Unknown Error"]], 200);
        }
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', Rules\Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()],
            // 'NID' => 'required|string|max:16',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'NID' => $request->NID,
            'password' => Hash::make($request->password),
        ]);
    }

    public function tap(Request $request)
    {
        date_default_timezone_set('Africa/kigali');

        $employee = new Employee();
        $tap = new CardTap();
        $visitor = new Vistor();

        $currentTime = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));

        // return response()->json(["data" => $request->key]);

        if ($request->key === "staff") {

            $staff = Employee::where(['ID_Card' => $request->idnumber])->get();

            if (count($staff) < 1) {

                $employee->names = $request->fullname;
                // $employee->gender = $request->gender;
                $employee->phone = $request->phonenumber;
                $employee->ID_Card = $request->idnumber;
                // $employee->company = $request->residance;
                $employee->category = $request->category;
                $employee->status = "IN";
                $employee->dateJoined = $currentTime;
                $employee->latestTap = $currentTime;
                try {
                    $employee->save();
                    $tap->user_id = $employee->id;
                    $tap->tapped_at = $employee->dateJoined;
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
                $tap->tapped_at = $currentTime;
                $tap->card_type = "STAFF";
                $tap->status =  $staff[0]['status'] == "IN" ? "EXITING" : "ENTERING";
                Employee::where('ID_Card', $staff[0]['ID_Card'])->update(['status' => $staff[0]['status'] == "IN" ? "OUT" : "IN"]);
                Employee::where('ID_Card', $staff[0]['ID_Card'])->update(['latestTap' => $currentTime]);

                // $staff[0]->status = $staff[0]->status == "OUT" ? "IN" : "OUT";
                try {
                    $tap->save();
                } catch (\Throwable $th) {
                    return response()->json(["error" => $th->errorInfo], 500);
                }
                return response()->json(["data" => ["user" => Employee::where('ID_Card', $staff[0]['ID_Card'])->get()[0], "previousTap" => null, "status" => $tap->status]]);
            }
        }


        return response()->json(["viditor"=> Vistor::all()->count()]);

        //     \\ 
        // Vistor \\

        if ($request->key === "visitor") {

            $visitor_staff = Vistor::where(['ID_Card' => $request->idnumber])->get();

            // if (!in_array($request->reason, ["OWNS", "LOST", "UNDER"])) {
            //     return response()->json(["data" => $request->all(), "status" => "error", "message" => "Reason Error"], 201);
            // }

            return response()->json(["viditor"=> Vistor::all()->count()]);


            if (count($visitor_staff) < 1) {

                $visitor->names = $request->fullname;
                // $visitor->gender = $request->gender;
                $visitor->phone = $request->phonenumber;
                $visitor->ID_Card = $request->idnumber;
                $visitor->destination = $request->destination;
                $visitor->reason = "OWNS";
                $visitor->status = "IN";
                $visitor->dateJoined = $currentTime;
                $visitor->latestTap = $currentTime;
                // return response()->json(["data" => $visitor->save()]);

                try {
                    $visitor->save();
                    $tap->user_id = $visitor->id;
                    $tap->ID_Card = $visitor->ID_Card;
                    $tap->tapped_at = $visitor->dateJoined;
                    $tap->card_type = "VISTOR";
                    $tap->status = "ENTERING";

                    $tap->save();
                } catch (\Throwable $th) {
                    return response()->json(["error" => $th->errorInfo], 500);
                }

                return response()->json(["data" => ["user" => "VISITOR", "previousTap" => null, "status" => "ENTERING"]], 200);
            } else {
                $tap->user_id = $visitor_staff[0]['id'];
                $tap->ID_Card = $visitor_staff[0]['ID_Card'];
                $tap->tapped_at = $currentTime;
                $tap->card_type = "STAFF";
                $tap->status =  $visitor_staff[0]['status'] == "IN" ? "EXITING" : "ENTERING";
                Vistor::where('ID_Card', $visitor_staff[0]['ID_Card'])->update(['status' => $visitor_staff[0]['status'] == "IN" ? "OUT" : "IN"]);
                Vistor::where('ID_Card', $visitor_staff[0]['ID_Card'])->update(['latestTap' => $currentTime]);

                try {
                    $tap->save();
                } catch (\Throwable $th) {
                    return response()->json(["error" => $th->errorInfo], 500);
                }
                return response()->json(["data" => ["user" => "VISITOR", "previousTap" => null, "status" => $tap->status]]);
            }

            return response()->json(["data" => $request->all('key')]);
        } elseif ($request->key === "noid") {

            return response()->json(["data" => $request->all('key')]);
        } else {

            return response()->json(["data" => ['result' => "no id"]]);
        }
    }


    public function syncVisitor(Request $request)
    {

        //\\ 
        // Vistor\\
        //\\
        //  \\

        date_default_timezone_set('Africa/kigali');

        if( !is_array($request->all()) ){
            return response()->json(["result"=> "error", "message" =>"bad format"]);
        }
        
        // if ($request->key === "visitor") {

            $currentTime = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
            $affectedRows = 0;
            $existingRecords = [];

     

            for ($i = 0; $i < count($request->all()); $i++) {

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

                    try {

                        $visitor->save();
                        $tap->user_id = $visitor->id;
                        $tap->ID_Card = $visitor->ID_Card;
                        $tap->tapped_at = $request[$i]['tappedAt'];
                        $tap->card_type = "VISTOR";
                        $tap->status = "ENTERING";

                        if ($tap->save()) {
                            $affectedRows++;
                        }
                    } catch (\Throwable $th) {
                        return response()->json(["error" => $th->errorInfo], 500);
                    }

                } else {

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
                            if ($tap->save()) {
                                $affectedRows++;
                            }
                        } catch (\Throwable $th) {
                            return response()->json(["error" => $th->errorInfo], 500);
                        }

                        // return response()->json(["data" => ["user" => "VISITOR", "status" => "Updated"]]);
                    }
                }

                // return response()->json(["data" => $request->all('key')]);

            }

            return response()->json(["result"=> "ok", "affected" => $affectedRows, "repeated" => $existingRecords]);
        // }
        
        
        // else {

        //     return response()->json(['result' => "no id"]);
        // }
    }

    public function syncEmployee(Request $request)
    {


        //\\ 
        // Vistor\\
        //\\
        //  \\
        // if ($request->key === "visitor") {

            if( !is_array($request->all()) ){
                return response()->json(["result"=> "error", "message" =>"bad format"]);
            }
            

            $currentTime = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
            $affectedRows = 0;
            $existingRecords = [];

            // return response()->json($request->all());

            for ($i = 0; $i < count($request->all()); $i++) {

                $tap_date = $request[$i]['tappedAt'];

                $tap = new CardTap();
                $employee = new Employee();

                $employee_staff = Employee::where(['ID_Card' => $request[$i]['idnumber']])->first();

                // if (!in_array($request->reason, ["OWNS", "LOST", "UNDER"])) {
                //     return response()->json(["data" => $request->all(), "status" => "error", "message" => "Reason Error"], 201);
                // }


                if (!$employee_staff) {

                    $employee->names = $request[$i]['fullname'];
                    // $employee->gender = $request[$i]['gender'];
                    $employee->phone = $request[$i]['phonenumber'];
                    $employee->phone = $request[$i]['category'];
                    $employee->ID_Card = $request[$i]['idnumber'];
                    $employee->department = $request[$i]['department'];
                    $employee->category = $request[$i]['category'];
                    // $employee->reason = "OWNS";
                    $employee->status = "IN";
                    $employee->dateJoined = $tap_date;
                    $employee->latestTap = $tap_date;


                    try {

                        $employee->save();
                        $tap->user_id = $employee->id;
                        $tap->ID_Card = $employee->ID_Card;
                        $tap->tapped_at = $request[$i]['tappedAt'];
                        $tap->card_type = "STAFF";
                        $tap->status = "ENTERING";

                        if ($tap->save()) {
                            $affectedRows++;
                        }
                    } catch (\Throwable $th) {
                        return response()->json(["error" => $th->errorInfo], 500);
                    }

                    // return response()->json(["data" => ["user" => "VISITOR", "previousTap" => null, "status" => "ENTERING"]], 200);
                } else {

                    $existing_record = Employee::where(['ID_Card' => $request[$i]['idnumber']])->first();

                    if ($employee_staff->latestTap == $request[$i]['tappedAt']) {

                        // return response()->json(["data" => "skipped"]);

                        $affectedRows++;
                        array_push($existingRecords, $existing_record);

                        continue;
                    } else {

                        $tap->user_id = $employee_staff['id'];
                        $tap->ID_Card = $employee_staff['ID_Card'];
                        $tap->tapped_at = $request[$i]['tappedAt'];
                        $tap->card_type = "STAFF";
                        $tap->status =  $employee_staff['status'] == "IN" ? "EXITING" : "ENTERING";
                        Vistor::where('ID_Card', $employee_staff['ID_Card'])->update(['status' => $employee_staff['status'] == "IN" ? "OUT" : "IN"]);
                        Vistor::where('ID_Card', $employee_staff['ID_Card'])->update(['latestTap' => $tap_date]);

                        try {
                            if ($tap->save()) {
                                $affectedRows++;
                            }
                        } catch (\Throwable $th) {
                            return response()->json(["error" => $th->errorInfo], 500);
                        }

                        // return response()->json(["data" => ["user" => "VISITOR", "status" => "Updated"]]);
                    }
                }

                // return response()->json(["data" => $request->all('key')]);

            }

            return response()->json(["result"=> "ok", "affected" => $affectedRows, "repeated" => $existingRecords]);
        // }
        
        
        // else {

        //     return response()->json(['result' => "no id"]);
        // }
   
   
    }










    public function allTaps()
    {
        return response()->json(["data" => CardTap::all()]);
    }

    public function allEmployees()
    {
        return response()->json(["data" => Employee::all()]);
    }

    public function allVisitors()
    {
        return response()->json(["data" => Vistor::all()]);
    }
}
