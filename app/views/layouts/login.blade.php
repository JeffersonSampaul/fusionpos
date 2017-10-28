<!DOCTYPE html>
<html lang="en" class="no-js">
    <head>
        <meta charset="utf-8"/>
        <title>@yield('title')</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
        <meta content="" name="description"/>
        <meta content="" name="author"/>
        <link href="https://fonts.googleapis.com/css?family=Hind:300,400,500,600,700" rel="stylesheet" type="text/css">
		{{ HTML::style("public/css/simple-line-icons.min.css") }}
		{{ HTML::style("public/css/bootstrap.min.css") }}
		{{ HTML::style("public/css/animate.css") }}
		{{ HTML::style("public/css/swiper.css") }}
		{{ HTML::style("public/css/layout.min.css") }}        
		{{ HTML::style("public/css/style.css") }}
		{{ HTML::style("https://files.takeawayepos.com/fonts/fontawesome/font-awesome1748.css?ver=5.0.5") }} 
        <link rel="shortcut icon" href="favicon.ico"/>
		<style>
		.preloader{position:fixed;height:100vh;width:100%;left:0;text-align:center;background:url('/public/img/bg.jpeg');z-index:9999;top:0;pointer-events:none;padding-top:20vh;}
		.preloader .fot-copy{
			bottom:0;
			position:fixed;
			width:100%;
		}
		.text-center {
			text-align: center;
		}
		.preloader .fot-copy p {
		font-size: 15px;
		color: #37ab52;
		margin-bottom: 0 !important;
		padding-bottom: 10px !important;
		}
		.preloader .fot-copy p a {
		font-size: 15px;
		color: #37ab52;
		margin-bottom: 0 !important;
		padding-bottom: 10px !important;
		}
		</style>
    </head>
    <body>
        <div class="preloader">        
		<div class="col-xs-12 col-sm-12 col-lg-12 col-md-12">
			<div class="text-center loading-logo">
				<img id="profile-img" class="profile-img-card" src="/public/img/fusion-logo.png" /> <br />
				<div class="page-loading">
					<img src="/public/img/pageloader_2.gif" />
				</div>
			</div><!-- /card-container -->
		</div>
		<div class="col-md-12 text-center fot-copy">
				<p>&copy; 2017 | Powered by  <a href="http://fusionpos.co.uk/" target="_black">Fusion POS </a></p>
			</div>
    </div>
        <!--========== HEADER ==========-->
        <header class="header">
            <!-- Navbar -->
            <nav class="navbar" role="navigation">
                <div class="container">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="menu-container">
                        <!-- Logo -->
						<div class="row">						
						<div class="col-md-6 page-title">
						<div class="top-button">@yield('top-button')</div>
						Login
						</div>
						<div class="col-md-6">
                        <div class="logo">						
                            <a class="logo-wrap" href="/">
								{{ HTML::image("/public/img/logo.png","Fustion Pos",array("class"=>"logo-img logo-img-main"))}}                                
								{{ HTML::image("/public/img/logo.png","Fustion Pos",array("class"=>"logo-img logo-img-active"))}}
                            </a>
                        </div>
						</div>
						</div>
                        <!-- End Logo -->
                    </div>

                    <!-- End Navbar Collapse -->
                </div>
            </nav>
            <!-- Navbar -->
        </header>
        <!--========== END HEADER ==========-->
        <!--========== PAGE LAYOUT ==========-->
        <!-- Service -->
		@yield('content')        

        <!-- JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
        <!-- CORE PLUGINS -->
		{{ HTML::script("public/js/jquery.min.js") }}      
		{{ HTML::script("public/js/jquery-migrate.min.js") }}  
		{{ HTML::script("public/js/bootstrap.min.js") }}  	
		<script>
		$(window).load(function(){
			$(".preloader").fadeOut();
		});
		</script>
    </body>
    <!-- END BODY -->
</html>