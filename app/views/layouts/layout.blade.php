<!DOCTYPE html>
<html lang="en" class="no-js">
    <head>
        <meta charset="utf-8"/>
        <title>@yield('title')</title>
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
        <link rel="shortcut icon" href="favicon.ico"/>
		<style>
		.loading-logo{
		background: #fff;
		width: 100px;
		margin: 0 auto;
		border-radius: 5px;
		padding: 10px;
		color: #0c0b0b;
		z-index:1000;
		}
		.loading-info{
			color:#000;
		}
		.preloader{position:fixed;height:100vh;width:100%;left:0;text-align:center;background:rgba(0,0,0,0.2);z-index:9999;top:0;padding-top:35vh;}
		</style>
    </head>
    <body>
	<div class="preloader">        
		<div class="col-xs-12 col-sm-12 col-lg-12 col-md-12">
			<div class="text-center loading-logo">				
				<div class="page-loading">
					<img src="/public/img/loading.gif" style="width:100%"/>
				</div>
				<span class="loading-info">Loading</span>
			</div><!-- /card-container -->
		</div>
    </div>
        <!--========== HEADER ==========-->
        <header class="header navbar-fixed-top">
            <!-- Navbar -->
            <nav class="navbar" role="navigation">
                <div class="container">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="menu-container">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".nav-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="toggle-icon"></span>
                        </button>

                        <!-- Logo -->
						<a href="/home">
						<div class="new-notification">
						<i class="fa fa-bell"></i>
						<span class="new-count">2</span>
						</div>
						</a>
						
<audio controls="none" preload  loop id="myaudio" >
	<!--<source src="/public/sound/bell.mp3" type="audio/mpeg" />-->
    <source src="/public/sound/beep.wav" type="audio/wav" />
    <p class="error-message">Try another browser...</p>
</audio>
                        <div class="logo">
                            <a class="logo-wrap" href="/">
                                {{ HTML::image("/public/img/logo.png","Fustion Pos",array("class"=>"logo-img logo-img-main"))}}                                								
                            </a>
                        </div>
						<div class="page-title">@yield('page-title')</div>
                        <!-- End Logo -->
                    </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse nav-collapse">
                        <div class="menu-container">
						  @if($data['logo'])
						   <img class="logo_image" src="{{$data['logo']}}"/>
						  @endif
						   <div class="close_block"><label class="site_status" style="position: absolute;padding: 10px 12px;color:gray;font-weight:normal;font-weight:bold;">@if($data['open']) {{"OPEN"}} @else {{"CLOSE"}} @endif</label> 
						   <label><input type="checkbox" @if($data['open']) {{"checked"}} @endif  class="ios-switch open-close green" /><div><div></div></div></label>
                           </div>
						   <ul class="navbar-nav navbar-nav-right">                                
								<li class="nav-item"><i class='fa fa-file-text-o'></i> {{ HTML::link("/home","My Orders",array("class"=>"nav-item-child nav-item-hover")) }}</li>
								<li class="nav-item"><i class='fa fa-user'></i>  {{ HTML::link("/profile","Profile",array("class"=>"nav-item-child nav-item-hover")) }}</li>							                                 
								<!--<li class="nav-item">{{ HTML::link("/menu","Menu",array("class"=>"nav-item-child nav-item-hover")) }}</li>-->
                                <li class="nav-item"><i class='fa fa-sign-out'></i>  {{ HTML::link("/logout","Logout",array("class"=>"nav-item-child nav-item-hover")) }}</li>                               
                            </ul>
                        </div>
                    </div>
                    <!-- End Navbar Collapse -->
                </div>
            </nav>
            <!-- Navbar -->
        </header>
        <!--========== END HEADER ==========-->
        <!--========== PAGE LAYOUT ==========-->
        <!-- Service -->
		<div class="content"  data-auto-height="true">   
		@yield('content')    
		</div>
        <!--========== FOOTER ==========
         <footer class="footer">         
            <div class="content container">
                <div class="row">
                    <div class="col-xs-12 text-right">
                        <p class="margin-b-0">Powered by: <a class="color-base fweight-700" href="http://fusionpos.co.uk">Fusion pos</a></p>
                    </div>
                </div>
            
            </div>
 
        </footer>
        <!--========== END FOOTER ==========-->

        <!-- Back To Top
        <a href="javascript:void(0);" class="js-back-to-top back-to-top">Top</a>

        <!-- JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
        <!-- CORE PLUGINS -->
		{{ HTML::script("public/js/jquery.min.js") }}      
		{{ HTML::script("public/js/jquery-migrate.min.js") }}  
		{{ HTML::script("public/js/bootstrap.min.js") }}
		{{ HTML::script("public/js/audio.min.js") }}
		<script>
		var maudio;
		var notify=false;
		var changed=false;
		var firstclick=true;
		var htmlold="";
		$(document).ready(function(){
			 maudio = document.getElementById('myaudio');
			setnotification();	
			setInterval(setnotification,3000);
			$("input.open-close").click(function(){
				$(".preloader").show();		
				var sts=$("input.open-close").prop("checked");				
				$.ajax({
				url:"{{ URL::action('OrderController@updateOpen') }}",
				method:"post",
				data:"status="+sts,
				success:function(html){	
				if(sts){
					$(".site_status").html("OPEN");
				}else{
					$(".site_status").html("CLOSE");
				}
				$(".preloader").fadeOut();		
				},
				error:function(e){
					$(".preloader").fadeOut();
					//alert(JSON.stringify(e));
				}
				});
			});
		});
		function setnotification(){
		$.ajax({
		url:"{{ URL::action('OrderController@newNotify') }}",
		method:"post",
		success:function(html){	
		  if(isNaN(html)){
			  window.location.reload();
			  return;
		  }
		 if(html!="0"){
		 $(".new-count").html(html);	 
		 $(".new-notification").show();		 
		  notify=true;			  
		 playsound();
		 }
		 else{
		 $(".new-notification").hide();
		 notify=false;
		 maudio.pause();		 
		 }
		 if(html!=htmlold){
			 htmlold=html;
			 changed=true;
		 }		
		},
		error:function(e){
		//	alert(JSON.stringify(e));
		}
		});
		}
  function playsound(){
	  while(changed){
	 maudio.play();
	 maudio.pause();	 
	 if(changed)	 
     if(notify){			
	    maudio.play();	 
	 }else{
		 maudio.pause();		 
	 }
	 changed=false;
	 }
  }
  $(document).ready(function(){
  $(document).click(function(event){
	if(event.hasOwnProperty('originalEvent'))
    if($(event.target).parents("nav").html())
	return true;
     playsound();
	var clickover = $(event.target);
	if(event.hasOwnProperty('originalEvent')){
	var _opened = $(".navbar-collapse").hasClass("in");
	if (_opened === true && !clickover.hasClass("navbar-toggle")) {
		$("button.navbar-toggle").click();
	}	
	}
   });
   });
	</script>
		@yield('scripts')
		<script>
		$(window).load(function(){
			$(".preloader").fadeOut();
		});
		</script>
    </body>
    <!-- END BODY -->
</html>