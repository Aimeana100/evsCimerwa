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
                $employee->gender = $request->gender;
                $employee->phone = $request->phonenumber;
                $employee->ID_Card = $request->idnumber;
                $employee->company = $request->residance;
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


        //     \\ 
        // Vistor \\

        if ($request->key === "visitor") {

            $visitor_staff = Vistor::where(['ID_Card' => $request->idnumber])->get();
            

            // if (!in_array($request->reason, ["OWNS", "LOST", "UNDER"])) {
            //     return response()->json(["data" => $request->all(), "status" => "error", "message" => "Reason Error"], 201);
            // }

            if (count($visitor_staff) < 1) {

                $visitor->names = $request->fullname;
                $visitor->gender = $request->gender;
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
                Vistor::where('ID_Card', $visitor_staff[0]['ID_Card'])->update(['latestTap' => $currentTime ]);

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
