@extends('layouts.login')
@section('title', 'Login')
@section('top-button')
<a href="/"><i class="fa fa-angle-left "></i></a>
@stop
@section('content')
 <div data-auto-height="true">            
                <div class="row row-space-1 margin-b-2">
                    <div class="Login-form">
					{{ Form::open(array('url'=>'login',"class"=>"form-signin")) }}
					<div class="form-group">
					<p class="error">{{ $errors->first('username')}}</p>
                    {{ Form::text('username',Input::old('username'), array('placeholder' => 'Username','class'=>'form-control ')) }}	
					</div>
					<div class="form-group">
					<p class="error">{{ $errors->first('password')}}</p>
                    {{ Form::password('password', array('placeholder' => 'Password','class'=>'form-control ')) }}	
					</div>
					<div class="form-group">
					<p class="error">{{ $errors->first('domain')}}</p>
                    {{ Form::select('domain', $data['domains'],null,array("class"=>"form-control")) }}	
					</div>
					<div class="form-group">
					{{ Form::submit('Login',array("class"=>"btn btn-lg btn-success btn-block btn-bottom-fixed")) }}	
					</div>
					{{ Form::close() }}
                    </div>                    
                </div>
                <!--// end row -->
        </div> 
@stop