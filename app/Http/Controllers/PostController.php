<?php

namespace App\Http\Controllers;
use Response;
use Illuminate\Http\Request;
use App\Post;
use App\UserLog;
use App\User;
use App\General;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        echo "sojib";
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

       /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

       public function logOut(Request $request){

        $data = $request->input();
    $resData = ApiOAuth::check();

        $validator = Validator::make($request->all(), [
            'oauth_token' => 'required',
        ]);


        if ($validator->fails())
        {
            $error =  $validator->errors()->all();
            $this->arr['status'] = 0;
            $this->arr['message'] = $error;
            return Response::json($this->arr);
        } else {
            $isUserLogEx = UserLog::where('oauth_token', $data['oauth_token'])->where('is_loggedin',1)->first();
            if(count($isUserLogEx)>0){
                //UserLog::where('oauth_token', $data['oauth_token'])->update(['is_loggedin' => 0]);
                UserLog::where('oauth_token', $data['oauth_token'])->delete();
                $this->arr['status'] = 1;
                $this->arr['message'] = "you are sucessfully logout!";
                return Response::json($this->arr);
            } else {
                $this->arr['status'] = 0;
                $this->arr['message'] = 'token not found try again!';
                return Response::json($this->arr);
            }


        }
    }
      public function getPost()
    {
        //
       // echo "sojib";

        $post = Post::all();

//  dd($post);
// exit();
        foreach ($post as $item){
            $listCircular[]=[
              
                'title' =>$item->title,
                'details' =>$item->details,
            ];
        }

 

          if(count($listCircular)>0){
            $arr['status'] = 1;
            $arr["message"] = "Circular found!";
            $arr["circular"] = $listCircular;
       
            return Response::json($arr);
        } else {
            $arr['status'] = 0;
            $arr["message"] = "Circular not found!";
            return Response::json($arr);
        }
    }
        /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function Login(Request $request){

        $input = $request->all();
// dd($input);
// exit();

        $validator = Validator::make($request->all(), [
            'email' => 'required|email', 'password' => 'required'
        ]);

          if ($validator->fails())
        {
            $error =  $validator->errors()->all();
            $this->arr['status'] = 0;
            $this->arr['message'] = $error;
            return Response::json($this->arr);
        } 
        else
        {

        // $user = new User();
        // $user->email = $input['email'];
        // $user->password = Hash::make($input['password']);

         $user = User::where('email',$input['email'])->get();

                     if($user->count()>0){
                   
                       // echo $user[0]->password;
                       // echo $user;

  if (Hash::check($input['password'], $user[0]->password)) {
                    $isExists = UserLog::where("user_id", $user[0]->id)->where("is_loggedin", 1)->get();
        

                    if($isExists->count()>0){
                    
                        $this->arr["status"] = 1;
                        $this->arr["message"] = "You are already logged in.";
                        $this->arr["data"] = $user;
                        return Response::json($this->arr);
                    } else {
                        // Generate oAuth Token
                        $oauth_token = $user[0]->id . time() . $_SERVER["REMOTE_ADDR"];
                        $oauth_token = base64_encode(md5($oauth_token));

                        // Add Token
                        $userLog = new UserLog();
                        $userLog->oauth_token = $oauth_token;
                        $userLog->user_id = $user[0]->id;
                        $userLog->login_date = date("Y-m-d H:i:s");
                        $userLog->is_loggedin = 1;

                        if ($userLog->save()) {
                            $this->arr["status"] = 1;
                            $this->arr["message"] = "login success.";
                            $this->arr["oauth_token"] = $oauth_token;
                            $this->arr["data"] = $user;
                            return Response::json($this->arr);
                        } else {
                            $this->arr["status"] = 1;
                            $this->arr["message"] = "Something went wrong. Please try again !";
                            return Response::json($this->arr);
                        }
                    }
                }
   }
   else
   {
     $this->arr['status'] = 0;
                $this->arr["message"] = "user not found!!";
                return Response::json($this->arr);
   }

   }


   }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        //

    }

 /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function register(Request $request){

        $input = $request->all();
// echo "string";
// dd($input );
// exit();
        $user = new User();
        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->password = Hash::make($input['password']);

         $isExist = User::where('email',$input['email'])->get();

                     if(count($isExist)<=0){
   $saved = $user->save();
       if($saved){
           $oauth_token = 'fhgfhgf';
           $oauth_token = base64_encode(md5($oauth_token));


           $userLog = new UserLog();
           $userLog->oauth_token = $oauth_token;
           $userLog->user_id = 1;
           $userLog->login_date = date("Y-m-d H:i:s");
           $userLog->is_loggedin = 1;

           if ($userLog->save()) {
               $this->arr["status"] = 1;
               $this->arr["message"] = "login success.";
               $this->arr["oauth_token"] = $oauth_token;
               $this->arr["data"] = $saved;
               return Response::json($this->arr);
           }

       }else {
           $this->arr["status"] = 1;
           $this->arr["message"] = "Something went wrong. Please try again !";
           return Response::json($this->arr);
       }
   }
   else
   {
     $this->arr['status'] = 0;
                $this->arr["message"] = "Email  Already Registered!";
                return Response::json($this->arr);
   }
   }
      
      //  $saved = $user->save();
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
    
            $post = new Post();
         
            $post->title = $data['title'];
            $post->details = $data['details'];
          
            $saved = $post->save();
            if($saved){
                $this->arr['status'] = 1;
                $this->arr["message"] = "Post created!";
                return Response::json($this->arr);
            } else {
                $this->arr['status'] = 0;
                $this->arr["message"] = "something went wrong!";
                return Response::json($this->arr);
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
