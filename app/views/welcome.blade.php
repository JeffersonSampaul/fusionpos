@extends('layouts.login')
@section('title', 'Login')
@section('content')
 <div  data-auto-height="true">            
                <div class="row row-space-1 margin-b-2">
                    <div class="Login-form">
					{{ Form::open(array('url'=>'/',"class"=>"form-signin")) }}
					<div class="form-group">
					<p class="error">{{ $errors->first('phone')}}</p>
                    {{ Form::text('phone', Input::old('phone'), array('id'=>'phone','placeholder' => 'Phone number','pattern' => '[0-9]{11,12}','maxlength' => '12','class'=>'form-control ')) }}	
					</div>
					<div class="form-group">
					{{ Form::submit('Next',array("class"=>"btn btn-lg btn-success btn-block btn-bottom-fixed")) }}	
					</div>
					{{ Form::close() }}
                    </div>                    
                </div>
                <!--// end row -->
        </div> 
@stop
