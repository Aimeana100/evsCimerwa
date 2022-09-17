<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use Webpatser\Uuid\Uuid;
use App\Models\GateKeeper;
use Illuminate\Http\Request;
use App\Models\GateKeeperLog;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GateKeeperController extends Controller
{
    public function register(Request $request)
    {

        if ($request->isMethod('post')) {
            $email = $request->input('email');
            $password = $request->input('password');
    
            $gateNames = $request->input('GatekeeperNames');
            $gatePassword = $request->input('gatekeeperpassword');
            $gateUsername = $request->input('gatekeeperUsername');
    
            $credentials =  ['email' => $email, 'password' => $password];
    
            // Auth::attempt($credentials);
    
            if ( Auth::attempt($credentials))
                {
                    if(count(GateKeeper::where(['username' => $gateUsername ])->get()) == 0){
                        $gateKeeper = new GateKeeper();
                        $gateKeeper->names = $gateNames;
                        $gateKeeper->username = $gateUsername;
                        $gateKeeper->password = Hash::make($gatePassword);
                        $gateKeeper->session_status = true;
                        $gateKeeper->status = true;
        
                        try {
                            $gateKeeper->save();
                        } catch (\Throwable $th) {
                            return response()->json(["error" => $th->errorInfo], 500);
                        }
        
                        return response()->json(['result'=>"ok", 'user'=> $gateKeeper],200);
                    }
                    else{
                        return response()->json(['result'=>'incorrect', 'message'=>'The Security guard username already exist'], 200);
                    }
                    
                }
                else
                {
                    return response()->json(['result'=>'incorrect', 'message'=>'You need to be a trusted user to register a device user'], 200);
                }
        }
        else
        {
            return response()->json(["result"=> "incorrect", "message"=>"Bad method call" ],200);
        }
    }

    public function login(Request $request)
    {
        date_default_timezone_set('Africa/kigali');

        $user = GateKeeper::where(['username'=> $request->gateUsername])->first();
        if($user){
            if(Hash::check($request->gatePassword,$user['password'])){

                $gateKeeperLogs = new GateKeeperLog();

                $gateKeeperLogs->session = (string) Uuid::generate();
                $gateKeeperLogs->logDate = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
                $gateKeeperLogs->gate_keeper_id = $user->id;
                $gateKeeperLogs->loginDevice = "123";
                $gateKeeperLogs->save();

                
                return response()->json(['result'=>'ok', 'message'=> "success"],200);
            }
            else
            {
                return response()->json(['result'=>'incorrect', 'message'=> "password doesnt matsh"],200);
            }
        }
        return response()->json(['result'=>'incorrect', 'message'=> 'User does not exist'], 200);
    }

    public function all(){
        $allGateKeeper = GateKeeper::all();
        return response()->json(['data' => $allGateKeeper]);
    }
}
