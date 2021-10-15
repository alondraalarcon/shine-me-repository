<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Currentadd;

class CarwashProviderController extends Controller
{
    public function getCarwasher()
    {
        return response()->json([
            'carwashprovider' => User::all()->where('id','2')->first(),
        ], 200); 
    }

    public function updateCarwasherInfo(Request $request, $id)
    {
        $checkingemail = User::where('email','=',$req->email)->where('id','!=',$id)->first();
        $checkingphone = User::where('email','=',$req->phone)->where('id','!=',$id)->first();
    
        if($request->email == $checkingemail){
            return response()->json([
                'messages'  => 'Email must be unique.',
            ], 200);
        }elseif($request->email == $checkingemail){
            return response()->json([
                'messages'  => 'Phone number must be unique.',
            ], 200);
        }
        else
        {
            $user = User::find($id);
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->phone = $request->input('phone');
            $user->save();
     
            return response()->json([
                'error' => false,
                'user'  => $user,
            ], 200);
        }
    }

    // CLICKING ON ONLINE RIDER
    public function onchangeStatRider(Request $req)
    {
    
        if($req->addresstype == 2){
            if($req->switchvalue == 'true'){

                if($req->addresstype == "" || $req->region = "" || $req->province = "" || $req->municipal = "" || $req->brgy = "" || $req->street = ""){
                    return response()->json(['error' => 'true','message' => 'Please fill-up all the required fields!']); 
                }else{

                    $newcurrentadd = new Currentadd;

                    $newcurrentadd->user_id = auth()->user()->id;
                    $newcurrentadd->region = $req->current_region;
                    $newcurrentadd->province = $req->current_province;
                    $newcurrentadd->municipal = $req->current_municipal;
                    $newcurrentadd->brgy = $req->current_brgy;
                    $newcurrentadd->street = $req->current_street;
                    $newcurrentadd->active = '1';

                    $insert = $newcurrentadd->save();

                    if($insert){
                        $update = User::where('id', auth()->user()->id)
                                ->update(['active' => "1", 'addresstype' => "2"]);

                        return response()->json(['error' => 'false','message' => 'You are now online, Enjoy cleaning!']); 
                    }
                }
            }else{
                $update = User::where('id', auth()->user()->id)
                        ->update(['active' => "0", 'addresstype' => "0"]);

                Currentadd::where('user_id', auth()->user()->id)->delete();

                return response()->json(['error' => 'false','message' => 'You are now offline, See you tomorrow']); 
            }        
        }elseif($req->addresstype == 1){
            if($req->switchvalue == 'true'){
                $update = User::where('id', auth()->user()->id)
                        ->update(['active' => "1", 'addresstype' => "1"]);

                return response()->json(['error' => 'false','message' => 'You are now online, Enjoy cleaning!']); 
            }else{
                $update = User::where('id', auth()->user()->id)
                        ->update(['active' => "0", 'addresstype' => "0"]);
    
                return response()->json(['error' => 'false','message' => 'You are now offline, See you tomorrow']); 
            }
        }else{
            return response()->json(['error' => 'true' ,'message' => 'Please select address first.']); 
        }
        
    }
    // END SWITCHING ON ONLINE RIDER
}
