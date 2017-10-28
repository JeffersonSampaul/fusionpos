<?php
class orderController extends BaseController {
	public function showOrders(){
		$data=array();
		$data['open']=$this->gettakeawaystatus();
		$data['logo']=$this->logopath();
		return View::make("home")->with("data",$data);
	}
	public function currentOrders(){
		return View::make("orders");
	}
	public function newOrders(){
		if($host=Session::get("host")){				
			$db=new Host($host);			
			$query=$db->table("tbl_order")
					->where("online","!=","1")					
					->where("hide","0");
			$orders=$query->get();
			$cooking=$db->table("tbl_collection_time")->first();
			foreach($orders as $index=>$order){
				$orders[$index]->tat=$cooking->collection_time;
				if($orders[$index]->otype==0)
				$orders[$index]->tat=$cooking->delivery_time;
				$orders[$index]->customer=$db->table("tbl_order_user")
					->where("oid",$order->id)->first();
			}				
			return View::make("order-list")->with("orders",$orders);									
		}else{
			echo"<script>window.location='/logout';</script>";
		}
	}
	public function listDomain($phone){		
		$rules=array(
			"phone"=>"required|numeric"
		);
		$validation=Validator::make(array("phone"=>$phone),$rules);
		if($validation->fails()){			
			echo json_encode(array("error"=>$validation->errors()));
			die;
		}
		$client=Clients::where("r_mobile",$phone)
				->where("hide",0)
				->select("id")
				->get();				
		if(isset($client[0])){
			$cids=array();
			foreach($client as $cid)
			$cids[]=$cid->id;
			$domains=Domain::where("client_id",$cids[0]);
			for($i=1;$i<count($cids);$i++){
			$domains->orWhere("client_id",$cids[$i]);			
			}
			$domains->select("url");
			$domains=$domains->get();
			$domain=array();
			foreach($domains as $d)
			$domain[]=$d->url;
			echo json_encode($domain);
			exit();
		}
		echo json_encode(array());
		exit();
	}
	public function newNotify(){		
		if(isset($_GET['domain'])){
			$db=new Host($_GET['domain']);				
			$query=$db->table("tbl_order")
					->where("online","!=","1")
					->where("status","0")
					->where("hide","0");
			$orders=$query->get();				
			return count($orders);	
		}
		if($host=Session::get("host")){				
			$db=new Host($host);			
			$query=$db->table("tbl_order")
					->where("online","!=","1")
					->where("status","0")
					->where("hide","0");
			$orders=$query->get();				
			return count($orders);									
		}else{
			echo"<script>window.location='/logout';</script>";
		}
	}
	public function loadReceipt(){
		if($host=Session::get("host")){				
			$db=new Host($host);			
			$query=$db->table("tbl_order")
					->where("id",Input::get("id"));
			$order=$query->first();			
				$order->customer=$db->table("tbl_order_user")
					->where("oid",$order->id)->first();
				$order->items=$db->table("tbl_order_items")
					->where("order_id",$order->id)->get();	
				foreach($order->items as $key=>$item)
				$order->items[$key]->addons=$db->table("tbl_order_addon")
					->where("order_item_id",$item->id)->get();					
			return View::make("receipt")->with("order",$order);									
		}else{
			echo"<script>window.location='/logout';</script>";
		}
	}
	public function printOrder($id){
		if($host=Session::get("host")){				
			$db=new Host($host);			
			$query=$db->table("tbl_order")
					->where("id",$id);
			$order=$query->first();			
				$order->customer=$db->table("tbl_order_user")
					->where("oid",$order->id)->first();
				$order->items=$db->table("tbl_order_items")
					->where("order_id",$order->id)->get();	
				foreach($order->items as $key=>$item)
				$order->items[$key]->addons=$db->table("tbl_order_addon")
					->where("order_item_id",$item->id)->get();					
			return View::make("print")->with("order",$order);									
		}else{
			echo"<script>window.location='/logout';</script>";
		}
	}
	public function showMap($id){
		if($host=Session::get("host")){				
			$db=new Host($host);			
			$query=$db->table("tbl_order")
					->where("id",$id);
			$order=$query->first();	
				$order->biller=$db->table("tbl_contact")->first();
				$order->customer=$db->table("tbl_order_user")
									->where("oid",$order->id)->first();
			return View::make("map")->with("order",$order);									
		}else{
			echo"<script>window.location='/logout';</script>";
		}
	}
	public function showProfile(){
			return View::make("profile")->with("data",Session::get("user"));									
	}
	public function saveProfile()
	{
		$rules=array(			
			"password"=>"required|string",
			"repassword"=>"required|same:password"
		);
		$validater=Validator::make(Input::all(),$rules);
		if($validater->fails()){		
		 return Redirect::to("/profile")
				->withErrors($validater);
		 exit();
		}else{
			if($host=Session::get("host")){				
			$db=new Host($host);
			$user=Session::get("user");		
			$db->table("tbl_login")
					->where("id",$user->id)
					->update(["password"=>Input::get("password")]);	
			return Redirect::to("/logout");	
			}
			else{
			return Redirect::to("/login");				
			}			
		}
	}
	public function rejectOrder(){
		if($host=Session::get("host")){				
			$db=new Host($host);			
			$db->table("tbl_order")
					->where("id",Input::get("id"))
					->update(["status"=>"2"]);	
			$order=$db->table("tbl_order")
					->where("id",Input::get("id"))->first();
				$order->customer=$db->table("tbl_order_user")
					->where("oid",$order->id)->first();		
			$this->rejectemail($order);
						
		}
	}
	private function rejectemail($val){		
		$host=Session::get("host");
		$headers = "From: info@$host\r\n";
		$headers .= "Reply-To:  info@$host\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=UTF-8\r\n"; 
		$logo=$this->logopath();
		$client=$this->clientdetails();
		$header=$headers;
			$imgurl="http://files.takeawayepos.com/img/";
			$msg="<div style='background:#f6f4f4;padding: 15px;'><style>
			.feedback{
				width:40%;
				float:left;
				padding:5px;
			}
			.feedbacklist{
				padding:0px 20px;
			}	
			.active{
				color:rgb(255, 210, 3);
			}
			</style>";
			$msg.="<div style='max-width:500px;background:#fff;margin:0 auto;padding: 10px 40px;'><h3 style='text-align:center;text-decoration:underline;'>Sorry your order has been Rejected</h3>";
			$msg.="<p style='text-align:center'><img style='max-width:100%' src='".$logo."'/></p>";
		$msg.="<p>Dear Customer,</p>
		<p>Thank you for ordering online with ".$host.". We have received your order, but unfortunately your order has been rejected.</p><p> If your order is paid order, we will refund your order in 3-5 business working days. </p><p>If there's anything else you want to check, just give ".$client->name." a quick call on ".$client->phone.". 
		</p>";
		$ono=$val->id;

			$msg.="<p>Your Order Number: ".$ono."</p>";
		$msg.="<p>Sorry for the inconvenience caused.</p>";
		$msg.="</div></div>";
		mail($val->customer->email,"Sorry your order has been Rejected",$msg,$header);
	}
	public function updateOpen(){
		if($host=Session::get("host")){
			$time=0;
			$info="";
			if(Input::get('status')=="false"){
			$time=strtotime("+1 months");
			$info="Currently Closed!";	
			}			
			$db=new Host($host);				
			$db->table("tbl_open_close")					
					->update(["opentime"=>$time,"info"=>$info]);				
		}
	}
	protected function gettakeawaystatus(){
		if($host=Session::get("host")){
		$db=new Host($host);
		$data=$db->table("tbl_open_close")->first();		
		if(time()<$data->opentime)
			return false;
		else
			return true;
		}
		return false;
		
	}
	protected function logopath(){
		if($host=Session::get("host")){
		$db=new Host($host);
		$data=$db->table("tbl_contact")->select("image")->first();		
		if($data->image)
			return "https://files.takeawayepos.com/img/".$data->image;
		else
			return false;
		}
		return false;
		
	}
	protected function clientdetails(){
		if($host=Session::get("host")){
		$db=new Host($host);
		return $db->table("tbl_contact")->first();	
		}
		return false;
	}
	public function acceptOrder(){
		if($host=Session::get("host")){				
			$db=new Host($host);
			$cooking=$db->table("tbl_collection_time")->first();
			$order=$db->table("tbl_order")
					->where("id",Input::get("id"))
					->first();
		    $time=$cooking->collection_time;
			if($order->otype==0)
				$time=$cooking->delivery_time;
			$db->table("tbl_order")
					->where("id",Input::get("id"))
					->update(["status"=>"1","late"=>(Input::get("time")-$time)]);									
		}
	}
	public function hideOrder(){
		if($host=Session::get("host")){				
			$db=new Host($host);			
			$db->table("tbl_order")
					->where("id",Input::get("id"))
					->update(["status"=>"3","hide"=>"1"]);									
		}
	}	
	public function loadcurrentOrders(){
		if($host=Session::get("host")){				
			$db=new Host($host);			
			$query=$db->table("tbl_order")
					->where("online","!=","1")
					->where("status","!=","0")
					->where("hide","0");
			$orders=$query->get();
			$cooking=$db->table("tbl_collection_time")->first();
			foreach($orders as $index=>$order){
				$orders[$index]->tat=$cooking->collection_time;
				if($orders[$index]->otype==0)
				$orders[$index]->tat=$cooking->delivery_time;
				$orders[$index]->customer=$db->table("tbl_order_user")
					->where("oid",$order->id)->first();
			}				
			return View::make("order-list")->with("orders",$orders);									
		}else{
			echo"<script>window.location='/logout';</script>";
		}
	}
	
}
?>