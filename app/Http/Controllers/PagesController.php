<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Broadcast;
use App\Member;
use File;

class PagesController extends Controller
{
    public function index(Request $request){
        if($request->session()->get('login')){
          // return Broadcast::all();
        //$allbroadcasts = Broadcast::all();
        $allbroadcasts = Broadcast::select('b_id')->distinct()->get();
        return view('pages.index')->with('allbroadcasts',$allbroadcasts);
    }else
        return redirect('/login');
    }


    public function about(Request $request){
        // $value= $request->session()->get('login');
        if($request->session()->get('login')){
        return view('pages.about');
          }else{
        return redirect('login');  
          }     
    }


    public function newbroadcast(Request $request){
        if($request->session()->get('login')){
        $allmembers = Member::all();
        return view('pages.newbroadcast')->with('allmembers',$allmembers);;
        }else
        return redirect('login');  
    }


    public function smsbroadcast(Request $request){
        if($request->session()->get('login')){
        $allmembers = Member::all();
        return view('pages.smsbroadcast')->with('allmembers',$allmembers);;
        }else
        return redirect('login');  
    }


    public function viewall(Request $request){
        
        if($request->session()->get('login')){
            $allmembers = Member::all();
            //return $allmembers;
            return view('pages.viewalltable')->with('allmembers',$allmembers);;
            }else
            return redirect('login');  
        }



        public function deletedataapi(Request $request, $token){
            if($request->session()->get('login')){
            
            Member::where('id', '=', $token)->delete();
            $request->session()->flash('message', ' User is deleted successfully.');

            $allmembers = Member::all();
            //return $allmembers;
            return view('pages.viewalltable')->with('allmembers',$allmembers);;
            }else
            return redirect('login');  
        }

        public function adddataapi(Request $request){
            if($request->session()->get('login')){
                $name = $request->input('name');
                $gender = $request->input('gender');
                $email = $request->input('email');
                $contact = $request->input('contact');

                $member = new Member;
                $member->name = $name;
                $member->gender = $gender;
                $member->email = $email;
                $member->mobile = $contact;
                $member->created_at = now();
                $member->updated_at = now();
                if ($member->save())
            $request->session()->flash('message', ' Member is Added successfully.');
                else
            $request->session()->flash('message', ' Member  failed to Add.');

            $allmembers = Member::all();
            //return $allmembers;
            return view('pages.viewalltable')->with('allmembers',$allmembers);;
            }else
            return redirect('login');  
        }

        
        public function updatedataapi(Request $request){
            if($request->session()->get('login')){
                $id = $request->input('id');
                $name = $request->input('name');
                $email = $request->input('email');
                $contact = $request->input('contact');

                $response= Member::where('id', $id)->firstOrFail();
            
                //Set user object attributes
                $response->name = $name;
                $response->email = $email;
                $response->mobile = $contact;
                $response->updated_at = now();

                // This will will update your the row in ur db.
               if($response->save())
               $request->session()->flash('message', ' User is data updated successfully.');
               else
               $request->session()->flash('message', ' User is data failed to update.');
               
                
            $allmembers = Member::all();
            //return $allmembers;
            return view('pages.viewalltable')->with('allmembers',$allmembers);;
            }else
            return redirect('login');  
        }


    public function login(Request $request){
        $mailcount = 1;
        if($request->session()->get('login'))
        return redirect('index');
        $name = $request->input('p');
        // if ($name=="apple"){
            if ($name == env("LOGIN_CRED", "abcxyz")){
                $request->session()->put('login',true);
               
                //    if ($passwd == "apple"){
                   // echo "<script>alert('Passwd OK')</script>";
                    
                    // $headers = "From: Broadcast <cyberboy.inc@gmail.com>" . "\r\n" .
                    // 'Content-type: text/html' . "\r\n" .
                    // 'X-Mailer: PHP/' . phpversion();
                    if(!($request->session()->get('loginalert'))){
                    $headers = "From: Broadcast <cyberboy.inc@gmail.com>" . "\r\n";
                    $ntxt = "Hello Eric,
                      
                          Login from ".$_SERVER['REMOTE_ADDR'].", is validated at " . date("h:i:sa");
                        // if ($mailcount == 1)
                        mail("ericabraham.ea@gmail.com","Login Alert",$ntxt,$headers);
                        $request->session()->put('loginalert',true);
                    }
        return redirect('index');
        }else
        return view('pages.login');
    }

    public function logout(Request $request){
        $request->session()->put('loginalert',false);
        $request->session()->flush();
        return redirect('/login');;
    }

}