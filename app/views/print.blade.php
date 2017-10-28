<!DOCTYPE html>
<html lang="en" class="no-js">
    <head>
        <meta charset="utf-8"/>
        <title>Order No {{$order->id}}</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
        <meta content="" name="description"/>
        <meta content="" name="author"/>
        <link href="http://fonts.googleapis.com/css?family=Hind:300,400,500,600,700" rel="stylesheet" type="text/css">
		{{ HTML::style("public/css/simple-line-icons.min.css") }}
		{{ HTML::style("public/css/bootstrap.min.css") }}
		{{ HTML::style("public/css/animate.css") }}
		{{ HTML::style("public/css/swiper.css") }}
		{{ HTML::style("public/css/layout.min.css") }}        
		{{ HTML::style("public/css/layout.css") }} 
		{{ HTML::style("https://files.takeawayepos.com/fonts/fontawesome/font-awesome1748.css?ver=5.0.5") }} 
		<style>
		.receipt{
			display:block;
			background:#fff;
			border-bottom:1px solid #000;
			padding-bottom:12px;
			position:relative;
			padding-top:0px;
		}
		.order .order-type{
			font-size:18px;
			font-weight:bold;
			float:right;
			width:22px;
			position:relative;
			margin: -6px 3px;
			padding: 2px 5px;
		}
		body{
			padding:0px;
			padding-bottom:20px;
			background:#fff;
		}
		.content{
			padding:0px;
		}
		.order{
			max-width:250px;	
			display:block;
			margin:0 auto;
		}
		.noPrint {
			width:100%;			
			position:fixed;
			bottom:0;
			z-index:10000;
		}
		.noPrint .btn{
			padding:20px;
			border-radius:0px;
			width:100%;
			
		}
		@media print {
		.noPrint {
		display:none;
		}
		}
		</style>
    </head>
    <body>
        <!-- Service -->
		<div class="content"  data-auto-height="true">   
		<div class="noPrint">
		<span style="float:right" class="btn btn-success" onclick="window.location='/home';">Back</span>
		</div>
		<div class="order @if($order->status==2) {{'rejected-order'}} @endif" data="{{ $order->id }}">
		<div style="text-align:center;font-weight:bold;">{{ $order->id }}</div>
		<div class="order-type">@if($order->otype==0) {{"D"}} @else {{"C"}} @endif </div>
		<div class="customer-name"> {{ $order->customer->fname }} {{ $order->customer->lname }}</div>				
		@if($order->otype==0)
		<div class="address">{{ $order->customer->dno }} {{ $order->customer->add1 }} {{ $order->customer->add2 }}</div>	
		<div class="postcode">{{ $order->customer->postcode }}</div>
		@endif
		<div class="phone">{{ $order->customer->phone }}</div>
		<div class="receipt">
	@foreach($order->items as $item)
	<div class="item">
			<div class="price">&pound; {{$item->total}}</div>
			<div class="item-name">{{$item->item_name}} {{$item->qty}}</div>
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
			<div class="price">&pound; {{$order->damount}}</div>
			<div class="desc">{{$order->coupon_desc}}</div>			
		</div>
		@endif
		@if($order->con>0)
		<div class="subtotal">
			<div class="price">&pound; {{$order->con}}</div>
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
		</div>
		<p style="text-align:right;color:#000;font-size:12px;">{{ Carbon\Carbon::createFromTimestamp($order->datetime)->format('d/m/Y h:i A')}}</p>
		</div>
		</div>

        <!-- CORE PLUGINS -->
		{{ HTML::script("public/js/jquery.min.js") }}      
		{{ HTML::script("public/js/jquery-migrate.min.js") }}  
		{{ HTML::script("public/js/bootstrap.min.js") }}
		{{ HTML::script("public/js/audio.min.js") }}
		<script>
		window.print();
		</script>		
    </body>
    <!-- END BODY -->
</html>