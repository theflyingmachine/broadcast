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


    public function dataapi(Request $request){
        if($request->session()->get('login')){
        $allmembers = Member::all();
        $count=1;
        $result = '{"data":[';
            foreach ($allmembers as $members){
            if ($count>1)
            $result .= ',';
            $result .= '["'.$members->id. '","'.$members->name.'","'.$members->gender.'","'.$members->mobile.'","'.$members->email.'"]';
            $count+=1;
            }
            $result .= ']}';
            
        return $result;
        
        }else
        return redirect('login');  
    }




    public function broadcaststaging(Request $request){
        if($request->session()->get('login')){
        $request->broadcastTemplate->store('broadcastTemplate');
        $ids = $request->input('id');
        //get has file name
        $hashFilename = $request->broadcastTemplate->hashName();
        $openFilename = "app\broadcastTemplate\\";
        $openFilename .= $hashFilename;
        //read file from disk
        $templateContent  = File::get(storage_path($openFilename));
        


        // $users="";
        // foreach ($ids as $id){
        //     $users[] = Member::select('*')
        //     ->where('members.id','=', $id)
        //     ->select('members.id','members.name')
        //     ->get();
        // }
        $users = Member::whereIn('id', $ids)->get();
        
        // $users = json_encode($users);
        // return view('pages.broadcastlaunchpad',compact('$users'));;

        // DO all the personalzation
        foreach ($users as $user){
        $personalizedTemplate = $templateContent;
        $token = $this->generateRandomString();
        //name
        $personalizedTemplate = str_replace("Birthday_boygirl",$user->name, $personalizedTemplate);
        //email
        $personalizedTemplate = str_replace("Birthday_boygirl",$user->email, $personalizedTemplate);
        //mobile
        $personalizedTemplate = str_replace("Birthday_boygirl",$user->mobile, $personalizedTemplate);
        //token
        $personalizedTemplate = str_replace("Birthday_boygirl",$token, $personalizedTemplate);
        $user['token'] =  $token;
        $user['template'] = $personalizedTemplate;

        //generate view for html
        $personalizedTemplate = str_replace("&","&amp;", $personalizedTemplate);
        $personalizedTemplate = str_replace("<","&lt;", $personalizedTemplate);
        $personalizedTemplate = str_replace(">","&gt;", $personalizedTemplate);
        $user['viewtemplate'] = $personalizedTemplate;
        }
        
        
        return view('pages.broadcastlaunchpad')->with('allbroadcasts',$users);;
         }else
        return redirect('login'); 
    }



    public function login(Request $request){
        $name = $request->input('p');
        if ($name=="apple"){
        $request->session()->put('login',true);
        // session::put('login', true);
        return redirect('index');
        }else
        return view('pages.login');
    }

    public function logout(Request $request){
        // session_start();
        // $_SESSION['login']=false;
       // $request->session()->flush('login');
        $request->session()->flush();
        return redirect('/login');
        // return redirect()->route('login');
        // return view('pages.login');
    }

   // Funcutions which will be used by this script
   public function generateRandomString($length = 32) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
	}
	
 


}