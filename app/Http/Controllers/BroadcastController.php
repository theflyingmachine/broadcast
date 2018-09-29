<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Broadcast;
use App\Member;
use File;
use Session;

class BroadcastController extends Controller
{

    public function broadcaststaging(Request $request){
        if($request->session()->get('login')){
        $request->broadcastTemplate->store('broadcastTemplate');
        $ids = $request->input('id');
        $title=$request->input('title');

        //vaildate if nay member is selected
        if((count($ids)) == 0){
        echo '<script type="text/javascript">alert("We cant broadcast to ghosts");</script>';
        // return (count($ids));
        return redirect('newbroadcast'); 
        }
        
        //get has file name
        $hashFilename = $request->broadcastTemplate->hashName();
        $openFilename = "app/broadcastTemplate/";
        $openFilename .= $hashFilename;
        //read file from disk
        $templateContent  = File::get(storage_path($openFilename));
        

        $users = Member::whereIn('id', $ids)->get();
        // DO all the personalzation
        foreach ($users as $user){
        $personalizedTemplate = $templateContent;
        $token = $this->generateRandomString();
        //name
        $personalizedTemplate = str_replace("myName",$user->name, $personalizedTemplate);
        //email
        $personalizedTemplate = str_replace("myEmail",$user->email, $personalizedTemplate);
        //mobile
        $personalizedTemplate = str_replace("myNumber",$user->mobile, $personalizedTemplate);
        //token
        $personalizedTemplate = str_replace("myToken",$token, $personalizedTemplate);
        $user['token'] =  $token;
        $user['template'] = $personalizedTemplate;
        $user['title'] = $title;
        $request->session()->push('broadcast',$user);
        }
        
        
        return view('pages.broadcastlaunchpad')->with('allbroadcasts',$users);
         }else
        return redirect('login'); 
    }


    public function broadcast(Request $request){
        if($request->session()->get('login')){
            $broadcastinit=false;

    
            $broadcastpermission = $request->input('broadcastpermission');
        if ($broadcastpermission=="525bc1c0751a58ea8d9ef774a9a59e91"){
            echo "Permission verified"; 
            $bdate = date('Y-m-d H:i:s');
            $broadcastinit=true;
        }
        $ids = $request->session()->get('broadcast');
        $request->session()->put('broadcast',false);
        ini_set('max_execution_time', 0); // to get unlimited php script execution time
        
            $request->session()->put('progress',0);
            $total = count($ids);
            $x = 0;
           
            for($i=$request->session()->get('progress');$i<$total;$i++)
            {
                $percent = intval($i/($total-$x) * 100)."%"; 
                $x = 1;  
                $request->session()->put('progress',$i);
                echo '<script>
                parent.document.getElementById("progressbar").innerHTML="<div style=\"width:'.$percent.';background:linear-gradient(to bottom, rgba(125,126,125,1) 0%,rgba(14,14,14,1) 100%); ;height:35px;\">&nbsp;</div>";
                parent.document.getElementById("information").innerHTML="<div style=\"text-align:center; font-weight:bold\">'.$percent.' is processed. '.($i+1).' of '.$total.' records. Broadcasting: '.$ids[$i]['name'].'</div>";</script>';
                $request->session()->put('progress',$i);
                
                
                sleep(1); // Here call your time taking function like sending bulk sms etc.
                $broadcast = new Broadcast;
                //Extract Variables
                $sub = $ids[$i]['title'];
                $msg = $ids[$i]['template'];
                $toemail = $ids[$i]['email'];
                $token = $ids[$i]['token'];
                
               
                if ($broadcastinit){
            //insert to database
                $broadcast->b_id = $bdate ." - ". $sub;
                $broadcast->token = $token;
                $broadcast->email_to = $toemail;
                $broadcast->status = "pending";
                $broadcast->save();

            //Shoot Email
		$headers = "From: Eric Abraham <cyberboy.inc@gmail.com>" . "\r\n" .
		'Reply-To: ericabraham.ea@gmail.com' . "\r\n" .
		'Content-type: text/html' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
       
		mail($toemail,$sub,$msg,$headers);
                }
                
                
                ob_flush(); 
                flush(); 
            }

            echo '<script>parent.document.getElementById("information").innerHTML="<div style=\"text-align:center; font-weight:bold\">Process completed</div>"</script>';

            $request->session()->put('progress',false);
                    
                    return "Done";    
                    // return view('pages.broadcastlaunchpad')->with('allbroadcasts',$users);
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
