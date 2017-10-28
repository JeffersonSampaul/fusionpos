<?php
class LoginController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function welcomeForm(){
		if(Session::get("user")){
			return Redirect::to("/home");
		}else{
			return View::make('welcome');
		}
	}
	public function validatePhone()
	{
		//return View::make('hello');
		$rules=array(
			"phone"=>"required|numeric"
		);
		$validation=Validator::make(Input::all(),$rules);
		if($validation->fails()){
			return Redirect::to("/")
				->withErrors($validation)
				->withInput(Input::all());		
		}
		$client=Clients::where("r_mobile",Input::get("phone"))
				->where("hide",0)
				->select("id")
				->get();
		if(isset($client[0])){
			$cids=array();
			foreach($client as $cid)
			$cids[]=$cid->id;			
			Session::put("cid",$cids);			
			return Redirect::to("/login");		
		}else{
			return Redirect::to("/")
				->withErrors(array("phone"=>"Phone number not registered."))
				->withInput(Input::all());		
		}
	}
	public function loginForm(){
		if($cids=Session::get("cid")){			
			$domains=Domain::where("client_id",$cids[0]);
			for($i=1;$i<count($cids);$i++){
			$domains->orWhere("client_id",$cids[$i]);			
			}
			$domains->select("url");
			$domains=$domains->get();			
			$domain=array();
			foreach($domains as $d)
			$domain[$d->url]=$d->url;
			return View::make("login")->with("data",array("domains"=>$domain));
		}else{
			return Redirect::to("/")
				->withErrors(array("phone"=>"Session timeout."));
		}
	}
	public function loginDo(){
		$rules=array(
			"username"=>"required|string",
			"password"=>"required|string",
			"domain"=>"required|string"
		);
		$validater=Validator::make(Input::all(),$rules);
		if($validater->fails()){		
		 return Redirect::to("/login")
				->withErrors($validater)
				->withInput(Input::all());	
		 exit();
		}else{
			$login=new Login();
			$login=$login->connect(Input::get('domain'));
			if($login){				
			if($user=$login->where("username",Input::get('username'))
						  ->where("password",Input::get('password'))
						  ->first())
				{
					Session::put("user",$user);	
					Session::put("host",Input::get('domain'));	
					return Redirect::to("/home");
				}else{
				return Redirect::to("/login")
				->withErrors(array("username"=>"Invalid username or password."))
				->withInput(Input::all());	
				exit();
				}			
			}
			else{
				return Redirect::to("/login")
				->withErrors(array("username"=>"Please contact support domain not installed properly"))
				->withInput(Input::all());	
			exit();
			}			
		}		
	}
}
?>