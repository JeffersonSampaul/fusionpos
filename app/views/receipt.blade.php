	<div class="receiptnav">
	<div class="top-button"><a class="close-btn"><i class="fa fa-angle-left "></i></a>
	</div>
	Order {{$order->id}}
	@if($order->otype==0)
	<div class="right-button"><a href="/map/{{$order->id}}"><i class="fa fa-map-marker "></i></a>
	</div>
	@endif
	</div>
	<div class="customer-det">
	<div class="tbl-row">
	<div class="icons green">
	<i class="fa fa-calendar"></i> 
	</div>
	<div class="info">
	{{ Carbon\Carbon::createFromTimestamp($order->datetime)->format('d/m/Y h:i A')}}
	</div>
	</div>
	<div class="tbl-row">
	<div class="icons blue">
	<i class="fa fa-user"></i> 
	</div>
	<div class="info">
	{{ $order->customer->fname." ".$order->customer->lname }}
	</div>
	</div>
	<div class="tbl-row">
	<div class="icons red">
	<i class="fa fa-phone"></i>  
	</div>
	<div class="info">
		{{ $order->customer->phone }}
	</div>
	</div>
	@if($order->otype==0)
	<div class="tbl-row ">
	<div class="icons blue">
	<i class="fa fa-map-marker"></i>  
	</div>
	<div class="info">
	{{ $order->customer->dno }} {{ $order->customer->add1 }} {{ $order->customer->add2 }} <span style=" text-transform: uppercase;color:#000;"> {{ $order->customer->postcode }} </span>
	</div>
	</div>
	@endif
	</div>
	@if($order->status!=0)
		<div class="row actions bill-action-block">
			
			@if($order->otype==0&&(strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'android')!==false || strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'mac')!==false ))
			<div class="col-md-6 col-xs-6">
			<span data="{{$order->id}}" class="btn btn-primary btn-print btn-block">Print Receipt</span>
			</div>
			<div class="col-md-6 col-xs-6">
			<a href='@if(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]),"android")!==false) {{"http://maps.google.com?daddr="}} @else {{"http://maps.apple.com/?dirflg=d&t=h&daddr="}} @endif {{ $order->customer->dno }} {{ $order->customer->add1 }} {{ $order->customer->add2 }} {{ $order->customer->postcode }}'><span class="btn btn-block btn-danger btn-map">Get Direction</span></a>
			</div>
			@else
			<div class="col-md-12 col-xs-12">
			<span  data="{{$order->id}}"  class="btn btn-primary btn-print btn-block">Print Receipt</span>
			</div>	
			@endif
		</div>
		@endif
		<h3>Order Details</h3>
	@foreach($order->items as $item)
	<div class="item">
			<div class="price">&pound; {{$item->total}}</div>
			<div class="item-name">{{$item->qty}} {{$item->item_name}}</div>
			@foreach($item->addons as $addon)
			<div class="price">&pound; {{$addon->total}}</div>
			<div class="addon-name">+{{$addon->addon_name}}</div>
			@endforeach
	</div>	
	@endforeach		
		<div class="subtotal">
			<div class="price">&pound; {{$order->sub_total}}</div>
			<div class="desc">Sub Total</div>			
		</div>
		@if($order->damount>0)
		<div class="subtotal">
			<div class="price">&pound; {{number_format($order->damount,2)}}</div>
			<div class="desc">{{$order->coupon_desc}}</div>			
		</div>
		@endif
		@if($order->con>0)
		<div class="subtotal">
			<div class="price">&pound; {{number_format($order->con,2)}}</div>
			<div class="desc">{{$order->condesc}}</div>			
		</div>
		@endif
		@if($order->delivery_charge>0)
		<div class="subtotal">
			<div class="price">&pound; {{$order->delivery_charge}}</div>
			<div class="desc">Delivery charge</div>			
		</div>
		@endif
		@if($order->ptype==1)
		<div class="paid"><img src='/public/img/paid.png'/></div>
		@endif
		<div class="total">
			<div class="price">&pound;  {{$order->total}}</div>
			<div class="desc">Total</div>			
		</div>
		@if($order->inst)
		<div class="total">			
			<div>Note:{{urldecode($order->inst)}}</div>			
		</div>
		@endif
		@if($order->status==0)
		<div class="actions fixed row">	
			<div class="col-md-6 col-xs-6">
			<span data="{{$order->id}}" class="btn btn-danger btn-block btn-reject"><i class="fa fa-window-close"></i> REJECT</span>
			</div>
			<div class="col-md-6 col-xs-6">
			<span data="{{$order->id}}" class="btn btn-success btn-block btn-accept"><i class="fa fa-check-square"></i> ACCEPT</span>
			</div>
		</div>
		@endif