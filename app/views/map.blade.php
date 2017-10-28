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
		body,.content{
			padding:0px;
		}
		.order{
			position:absolute;
			background:rgba(0,0,0,0.7);
			width:100%;
			color:#fff;
			margin:0px;
		}
		#map_canvas{
			@if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'android')!==false || strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'mac')!==false )
			height: calc(100vh - 120px)!important;
			height: -moz-calc(100vh - 120px)!important;
			height: -webkit-calc(100vh - 120px)!important;
			height: -o-calc(100vh - 120px)!important;			
			margin-top:60px;	
			margin-bottom:60px;
			@else
		    height: calc(100vh - 60px)!important;
			height: -moz-calc(100vh - 60px)!important;
			height: -webkit-calc(100vh - 60px)!important;
			height: -o-calc(100vh - 60px)!important;			
			margin-top:60px;	
			@endif
		}
		.receiptnav{
			z-index:10;
			margin:0px;
			font-size:18px;
		}
		.bill-action-block{
			margin:0px;
		}
		.btn-map{
			font-size:18px;
		}
		</style>
    </head>
    <body>
        <!-- Service -->
		<div class="content"  data-auto-height="true" style="height:100%">   
		<div class="receiptnav">
	<div class="top-button"><a class="close-btn" href="/home" onclick="window.top.iframeResponse('Close'); return false;"><i class="fa fa-angle-left "></i></a>
	</div>
	Location	
	</div>
	</div>
		<div id="directions" style="display:none;"></div>		
		<div id="map_canvas" style="width: 100%; height: 100%;float:left;"></div> 
		@if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'android')!==false || strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'mac')!==false )
		<div class="row actions bill-action-block">
			<div class="col-md-12 col-xs-12">
			<a onclick="window.parent.location='@if(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]),"android")!==false){{"https://maps.google.com?daddr="}}@else{{"https://maps.apple.com/?dirflg=d&t=h&daddr="}}@endif{{ $order->customer->dno }} {{ $order->customer->add1 }} {{ $order->customer->add2 }} {{ $order->customer->postcode }}'"><span class="btn btn-block btn-danger btn-map">Get Direction</span></a>
			</div>
		</div>	
		@endif
		 <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDxwNKwnRfvvx3qijuy7hIv3A97s59jPs0&callback=initMap">
    </script>

		</div>

        <!-- CORE PLUGINS -->
		{{ HTML::script("public/js/jquery.min.js") }}      
		{{ HTML::script("public/js/jquery-migrate.min.js") }}  
		{{ HTML::script("public/js/bootstrap.min.js") }}	
		<script>
		var directionsDisplay;
		var directionsService = new google.maps.DirectionsService();
		var map;
		function initialize() {			
		  directionsDisplay = new google.maps.DirectionsRenderer();
		  var mapOptions = {
			zoom: 15,
			center: new google.maps.LatLng(41.850033, -87.6500523),
			scaleControl: true,
			scaleControlOptions: {position: google.maps.ControlPosition.BOTTOM_LEFT}
			
		  };  
		  map = new google.maps.Map(document.getElementById('map_canvas'),
			  mapOptions);
		  directionsDisplay.setMap(map);
		  directionsDisplay.setPanel(document.getElementById('directions'));		  
		  calcRoute();		  
		}

		function calcRoute() {
		  var start = "{{ $order->biller->name.', '.$order->biller->address1.', '. $order->biller->address2.', '. $order->biller->city.', '. $order->biller->pincode.' '  }}";
		  var end = "{{ $order->customer->dno.', '.$order->customer->add1.', '. $order->customer->add2.', '. $order->customer->postcode  }}";  
		 var request = {
			origin: start,
			destination: end,	
			unitSystem: google.maps.UnitSystem.IMPERIAL,
			travelMode: google.maps.TravelMode.DRIVING,
		  };		  
		  try{
		  directionsService.route(request, function(response, status) {			  
			if (status == google.maps.DirectionsStatus.OK) {
			  directionsDisplay.setDirections(response);
			}				
		  });
		  }catch(e){			  
		  }
		  
		}
		google.maps.event.addDomListener(window, 'load', initialize);
		</script>   
    </body>
    <!-- END BODY -->
</html>