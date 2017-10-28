<!DOCTYPE html>
<html lang="en" class="no-js">
    <head>
        <meta charset="utf-8"/>
        <title>Edit Profile</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
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
			background-image: url("/public/img/bg.jpeg");
		}
		.form-control[readonly]{
		background:#a7a7a9;
	color:#000;	
		}
		.form-control[readonly]:focus{
		background:#a7a7a9;
	color:#000;	
		}
		.form-control{
	background:#a7a7a9;
	color:#fff;
}
.form-control:focus{
	background:#a7a7a9;
	color:#fff;
}

*:-webkit-input-placeholder { /* WebKit, Blink, Edge */
    color:    #fff !important;
	opacity:  1;
}
*:-moz-placeholder { /* Mozilla Firefox 4 to 18 */
   color:    #fff !important;;
   opacity:  1;
}
*:-ms-input-placeholder { /* Internet Explorer 10-11 */
   color:    #fff !important;
   opacity:  1;
}
*::-ms-input-placeholder { /* Internet Explorer 10-11 */
   color:    #fff !important;
   opacity:  1;
}
*::-webkit-input-placeholder { /* WebKit, Blink, Edge */
    color:    #fff !important;
	opacity:  1;
}
*::-moz-placeholder { /* Mozilla Firefox 19+ */
   color:    #fff !important;;
   opacity:  1;
}
.error{
	color:red;
}
@media screen and (max-width: 991px){
	.header{
		border-bottom: 0px solid #63b846;
		padding-bottom: 0px;
	}
	.page-title{
		border-bottom: 1px solid #63b846;	
		font-size:30px;
	}
	.container {
		width:100%;
		background: url("/public/img/bg.jpeg");
		background-position: 0px;
	}
}
.btn-bottom-fixed{
	position: fixed;
	bottom: 0;
	left: 0;
	right: 0;
	border-radius: 0px;
}
.top-button{
	position: absolute;
}
.top-button a{
	color: #667280;
}
.receiptnav{
margin:0px;	
}
		</style>
    </head>
    <body>
	<div class="receiptnav">
	<div class="top-button"><a class="close-btn" href="/home"><i class="fa fa-angle-left "></i></a>
	</div>
	Edit Profile	
	</div>
 <div  data-auto-height="true">            
                <div class="row row-space-1 margin-b-2">
                    <div class="Login-form">
					{{ Form::open(array('url'=>'profile',"class"=>"form-signin")) }}
					<div class="form-group">
					<p class="error">{{ $errors->first('username')}}</p>
                    {{ Form::text('username',$data->username, array('placeholder' => 'Username','readonly' => 'readonly','class'=>'form-control ')) }}	
					</div>
					<div class="form-group">
					<p class="error">{{ $errors->first('password')}}</p>
                    {{ Form::password('password', array('placeholder' => 'Enter password','class'=>'form-control ')) }}	
					</div>
					<div class="form-group">
					<p class="error">{{ $errors->first('repassword')}}</p>
                    {{ Form::password('repassword', array('placeholder' => 'Enter confirm password','class'=>'form-control ')) }}	
					</div>
					<div class="form-group">
					{{ Form::submit('Update',array("class"=>"btn btn-success btn-block btn-bottom-fixed")) }}	
					</div>
					{{ Form::close() }}
                    </div>                    
                </div>
                <!--// end row -->
        </div> 
</body>
</html>