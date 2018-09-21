<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Broadcast;
use App\Member;
use Session;

class ResponseController extends Controller
{
    //
    public function checktoken($token){
    $status = Broadcast::where('token', '=', $token)->first();
    //check is token is correct
    if(count($status) == 1){
        // echo $token;
        // $token->session()->put('token',$token);
        Session::put('token', $token);
        return view('pages.response')->with('token',$status);
        //check status
        // if({{$stat->status}}=='pending'){
        //     //accept new responce
        // }else{
        //     // responce is already recorded
        // }
    }else{
        //invalid token
       // echo "Invalid Token";
       return view('pages.response');   
    }
    
    }


    public function checktokenqresponse($token, $qresponse){
        $status = Broadcast::where('token', '=', $token)->first();
        //check is token is correct
        // return $status->status;
        if(count($status) == 1){
            // return $status->token;
             // $token->session()->put('token',$token);
            // Session::put('token', $token);
            // return view('pages.response')->with('token',$status);
            //Record Quick response
            try{
                //Find the user object from model if it exists
                $response= Broadcast::where('token', $token)->firstOrFail();
            // Check if status is pending
            if (($status->status)=="pending"){
                // validate quick response
                if ($qresponse=="delete")
                $response->message = "Delete";
                elseif ($qresponse=="ok")
                $response->message = "Updated";
                else
                return "Oops, that's an invalid quick resonse";
            }else
                return redirect("/response/$token");      
               
                //$request contain your post data sent from your edit from
                //$user is an object which contains the column names of your table
        
                //Set user object attributes
               
                $response->status = "ok";
                $response->updated_at = now();
    
                // Save/update user. 
                // This will will update your the row in ur db.
                $response->save();
                
                return redirect("/response/$token");  
                //return view('myform.index')->with('user', $user);
            }
            catch(ModelNotFoundException $err){
                //Show error page
                echo "Database error";
            }
            return redirect("/response/$token");
        }else{
            //invalid token
           // echo "Invalid Token";
           return view('pages.response');   
        }}


    public function showresponse($b_id){
      // $broadcast_subject = Broadcast::where('b_id', $b_id)->distinct()->get();  
      $broadcast_subject = Broadcast::select('*')
            ->join('members', 'broadcasts.email_to', '=', 'members.email')
            ->where('broadcasts.b_id','=', $b_id)
            ->select('members.name','members.gender','broadcasts.email_to','broadcasts.message','broadcasts.status', 'broadcasts.updated_at')
            ->get(); 
      //return $broadcast_subject;
       if(count($broadcast_subject) > 0){
            //send to result page
            Session::put('token', $b_id);
            return view('pages.showresponse')->with('broadcast_subject',$broadcast_subject);
            }else{
          //send to 404
          return view('inc.404');
        }    
    }

    public function invalid(){       
         // return view('pages.response');
         return view('inc.404');
     }

    public function submitresponse(Request $request){
        $token  = Session::get('token', $request);
        $submitresponse = $request->input('responsetext');
        try{
            //Find the user object from model if it exists
            // $response= Broadcast::findOrFail($token);
            $response= Broadcast::where('token', $token)->firstOrFail();
    
            //$request contain your post data sent from your edit from
            //$user is an object which contains the column names of your table
    
            //Set user object attributes
            $response->message = $submitresponse;
            $response->status = "ok";
            $response->updated_at = now();

            // Save/update user. 
            // This will will update your the row in ur db.
            $response->save();
            return redirect("/response/$token");  
            //return view('myform.index')->with('user', $user);
        }
        catch(ModelNotFoundException $err){
            //Show error page
            echo "Database error";
        }
        return redirect("/response/$token");
     }
}