<?php

namespace App\Http\Controllers;

use App\Models\user;
use App\Http\Requests\UserpostRequest;
use Illuminate\Http\Request;
use lluminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Mail\welcomeEmail;

use Illuminate\Support\Facades\Mail;
use Hash;

class BlogController extends Controller
{ 
  //this function iS used for opening the Home screen of application
    public function home(Request $request)
    {
    $users=DB::table('posts')->where('posttype','=','post')->get();
      return view('Home',['users' => $users]);
    }
   //-------------------------------------------
   //this function is used for opening the login view by get request
    public function loginGet()
    {
      return view('Login');
    }
    //--------------------------------------------
    //this function is used for opening the Registration view by get request
    public function registrationGet()
    {
      return view('Registration');
    }
    //--------------------------------------------
    //this function is used for opening the Addpost view by get request
    public function addPostGet()
    {
      return view('Addpost');
    }
    //--------------------------------------------
    //this function is used for opening the Dashboard view by get request
    public function dashboard()        
    {
      if(session()->has('loginId'))
      {
          $data=user::where('id','=',session()->get('loginId'))->first();
      }
      $users=DB::table('posts')->where('posttype','=','post')->get();
      return view('Dashboard',['users' => $users,'data'=>$data]);
     }
     //--------------------------------------------
    //this function is used for logout  the current login user by get request
      public function logout()
     {
         if(session()->has('loginId'))
        {
          session()->pull('loginId');
          return redirect('login');
        }
    } 
    //--------------------------------------------
    //this function is used after the loginform filled  for opening the Dashboard view by post request
    public function loginPost(Request $request)
    {
        $this->validate($request,[ 
             'email'=>'required',
             'password'=>'required',
        ]);
        $myusers=user::where('email','=',$request->email)->first();
        if($myusers)
        {
             if(Hash::check($request->password,$myusers->password))
              {
                $request->session()->put('loginId',$myusers->id);
                 return redirect('dashboard');
              }
              else{
               return back()->with('fail','the password is wrong');;
              }
        }
        else
        {
            return back()->with('fail','this email is not registered');
        }
    }
    //--------------------------------------------
    //this function is used after the Registrationform filled  for opening the Dashboard view by post request

    public function registrationPost(Request $request)
     {
         $this->validate($request,[
        'name'=>'required|min:5|max:20|string',
         'email'=>'bail|required|email|unique:users,email',
         'password'=>'required|min:5|max:12',
        ]);

         DB::table('users')->insert([
        'name'=>$request->name,
        'email' =>$request->email ,
        'password'=> Hash::make($request->password),
        'created_at'=>now(),
        'updated_at'=>now(),
        ]);

       $myusers=DB::table('users')->where('email','=',$request->email)->first();
       $request->session()->put('loginId',$myusers->id);
       return redirect('dashboard');
    }
   //--------------------------------------------
    //this function is used after the Addpostform filled  for doing a new post by post request
    public function addpost(Request $request)
    {
         $validator =Validator::make($request->all(),[
           'description'=>'required|min:5|max:500',
            'tittle'=>'required|min:5|max:50',
            'file'=>'required|mimes:jpeg,bmp,png,mp4,mp3,gif',
            'coursetype'=>'required|in:dance,singing,publicSpeaking',
            'postingtype'=>'required|in:draft|post',
         ]);
         $file = $request->file;
        $filename = time().'.'.$file->getClientOriginalExtension();
        $request->file->move('assets',$filename);
      
        DB::table('posts')->insert([
            'tittle'=>$request->tittle,
            'description' =>$request->description ,
            'file' => $filename,
            'coursetype' =>$request->coursetype,
            'posttype'=>$request->postingtype,
             'user_id'=> $request->session()->get('loginId'),
             'created_at'=>now(),
             'updated_at'=>now(),
         ]);
    return redirect('dashboard');  
    }
   //--------------------------------------------
    //this function is used for email
    public function email(Request $request)
    {
        $emailData=[
            'subject'=>'Welcome to my blog site',
            'body'=>'you can here upload and see others posts',
        ];
        $to = [
          [
              'email' => 'muskangirdhar345@gmail.com', 
              'name' => 'Muskan',
          ]
      ];
        Mail::to($to)->send(new welcomeEmail($emailData));
    }
  //--------------------------------------------
    //this function is used for getting the specific user uploded posts
    public function userDataGet(Request $request)
    {
      $myid=session()->get('loginId');
      $users=DB::table('posts')->where('posttype','=','post')->where('user_id','=',$myid)->orderBy('updated_at','DESC')->get();
      return view('userdata',['users' => $users]);
  
    }
     //--------------------------------------------
    //this function is used for getting the all post when user is not login

    public function all(Request $request)
    {
      $users=DB::table('posts')->where('posttype','=','post')->orderBy('updated_at','DESC')->get();
      return view('Home',['users' => $users]);
    }
    //--------------------------------------------
    //this function is used for getting the dance related post when user is not login
     public function dance(Request $request)
    { 
      $users=DB::table('posts')->where('posttype','=','post')->where('coursetype','=','dance')->orderBy('updated_at','DESC')->get();
      return view('Home',['users' => $users]);
    }
    //--------------------------------------------
    //this function is used for getting the singing related post when user is not login
    public function singing(Request $request)
    {  
      $users=DB::table('posts')->where('posttype','=','post')->where('coursetype','=','singing')->orderBy('updated_at','DESC')->get();
      return view('Home',['users' => $users]);
    }
    //--------------------------------------------
    //this function is used for getting the public Speaking related post when user is not login
    public function publicSpeaking(Request $request)
    {
      $users=DB::table('posts')->where('posttype','=','post')->where('coursetype','=','publicSpeaking')->orderBy('updated_at','DESC')->get();
      return view('Home',['users' => $users]);
    }
    //--------------------------------------------
    //this function is used for getting the ALL post after user is  login
    public function userAll(Request $request)
    {
      if(session()->has('loginId'))
       {
        $data=user::where('id','=',session()->get('loginId'))->first();
      }
      $users=DB::table('posts')->where('posttype','=','post')->orderBy('updated_at','DESC')->get();
      return view('Dashboard',['users' => $users,'data'=>$data]);
    }
    //--------------------------------------------
    //this function is used for getting the dance related post after user is  login
     public function userDance(Request $request)
    {
      if(session()->has('loginId'))
      {
          $data=user::where('id','=',session()->get('loginId'))->first();
      }
      $users=DB::table('posts')->where('posttype','=','post')->where('coursetype','=','dance')->orderBy('updated_at', 'ASC')->get();
      return view('Dashboard',['users' => $users,'data'=>$data]);
     }
     //--------------------------------------------
    //this function is used for getting the singing related  post after user is  login
    public function userSinging(Request $request)
    {
      if(session()->has('loginId'))
      {
          $data=user::where('id','=',session()->get('loginId'))->first();
      }
      $users=DB::table('posts')->where('posttype','=','post')->where('coursetype','=','singing')->orderBy('updated_at', 'DESC')->get();
      return view('Dashboard',['users' => $users,'data'=>$data]);
  
    }
    //--------------------------------------------
    //this function is used for getting the public speaking post after user is  login
    public function userPublicSpeaking(Request $request)
    {
      if(session()->has('loginId'))
      {
          $data=user::where('id','=',session()->get('loginId'))->first();
      }
      $users=DB::table('posts')->where('posttype','=','post')->where('coursetype','=','publicSpeaking')->orderBy('updated_at', 'DESC')->get();
      return view('Dashboard',['users' => $users,'data'=>$data]);
    }
    //--------------------------------------------
    //this function is used for getting the  posts of the logedin user
    public function yourPost(Request $request)
    {
      $myid=session()->get('loginId');
      $users=DB::table('posts')->where('posttype','=','post')->where('user_id','=',$myid)->orderBy('updated_at', 'DESC')->get();
      return view('Userdata',['users' => $users]);
    }
    //--------------------------------------------
    //this function is used for getting the draft of the logedin user
    public function yourDraft(Request $request)
    {
      $myid=session()->get('loginId');
      $users=DB::table('posts')->where('posttype','=','draft')->where('user_id','=',$myid)->orderBy('updated_at', 'DESC')->get();
      return view('Userdata',['users' => $users]);  
    }
}
