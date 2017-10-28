@extends('layouts.layout')
@section('title', 'My Orders')
@section('page-title', 'My Orders')
@section('content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="http://jquery-ui.googlecode.com/svn/tags/latest/ui/jquery.effects.core.js"></script>
<script src="http://jquery-ui.googlecode.com/svn/tags/latest/ui/jquery.effects.slide.js"></script>
<div class="orders-nav row">
<div class="col-sm-4 col-md-4  col-xs-4 active" data='new'>New</div>
<div  class="col-sm-4 col-md-4  col-xs-4" data='current'>Today</div>
<div  class="col-sm-4 col-md-4 col-xs-4" data='all'>Show All</div>
</div>
 <div class="orders-list"></div>
 <div class="receipt"></div>
 <div class="map-block"></div>
  <div id="confirmwindow" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <span style="color:#000;line-height:3em;">Are you sure you want to Reject this Order?</span>
		<div style="text-align:center;">
		<span class="btn btn-success approve-btn">YES</span>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<span class="btn btn-danger cancel-btn">NO</span>
		</div>
      </div>
    </div>
  </div>
</div>
<div id="cookingwindow" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <span style="color:#000;line-height:3em;">When Will The Order Be Ready?</span>
		<div class="row">
		<div style="text-align:center;position: relative;max-width: 243px;margin:0 auto;">
		<div class="cooktime-btn" data='10'>10mins</div>
		<div class="cooktime-btn" data='20'>20mins</div>
		<div class="cooktime-btn" data='30'>30mins</div>
		<div class="cooktime-btn" data='40'>40mins</div>
		<div class="cooktime-btn" data='50'>50mins</div>
		<div class="cooktime-btn" data='60'>60mins</div>
		<div class="cooktime-btn" data='70'>70mins</div>
		<div class="cooktime-btn" data='80'>80mins</div>
		<div class="cooktime-btn" data='90'>90mins</div>	
		</div>
		</div>
      </div>
    </div>
  </div>
</div>
 <div id="confirmwindow1" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <span style="color:#000;line-height:3em;">Are you sure you want to Hide This Order?</span>
		<div style="text-align:center;">
		<span class="btn btn-success approve-btn1">YES</span>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<span class="btn btn-danger cancel-btn1">NO</span>
		</div>
      </div>
    </div>
  </div>
</div>
@stop
@section('scripts')
<script>
var confirmob;
var readytime;
var first=true;
$(document).ready(function(){
	$(".loading-info").html("Fetching");
	$(".preloader").show();
	loadneworders();	
	setInterval(loadneworders,3000);
	$("body").on('click','.btn-print',function(){
		window.location="/print/"+$(this).attr("data");
	});
	$("body").on('click','.order-hide',function(){
	   $("#confirmwindow1").modal("show");
	   confirmob=this;
		//hideorder(this);
	});
	$("body").on('click','.orders-nav div',function(){
		$(".orders-nav div").removeClass('active');
		$(this).addClass('active');
		if($(this).attr("data")=="new"){
			$(".order").css("display","none");
			$(".order.new-order").css("display","table");
		}else{
			if($(this).attr("data")=="current"){
			$(".order").css("display","none");
			$(".order.current-order").css("display","table");
			}else{
				if($(this).attr("data")=="all"){
				$(".order").css("display","table");
			}
			}
		}
	});
	$("body").on('click','.receiptnav .right-button .fa-map-marker',function(){	
		$(".preloader").show();
		$(".map-block").html("<iframe src='"+$(this).parent('a').attr("href")+"'></iframe>");
		$(".map-block").show();
		return false;
	});
	$("body").on('click','.cancel-btn',function(){
		$("#confirmwindow").modal("hide");
		confirmob=null;
	});
	$("body").on('click','.cancel-btn1',function(){
		$("#confirmwindow1").modal("hide");
		confirmob=null;
	});
	$("body").on('click','.close-btn',function(){
		$(".receipt").hide(0);		
	});
	$("body").on('click','.approve-btn',function(){
		$("#confirmwindow").modal("hide");
		$(".preloader").show();
		rejectorder(confirmob);
		confirmob=null;
	});
	$("body").on('click','.approve-btn1',function(){
		$("#confirmwindow1").modal("hide");
		$(".preloader").show();
		hideorder(confirmob);
		confirmob=null;
	});
	$("body").on('click','.cooktime-btn',function(){
		$("#cookingwindow").modal("hide");
		readytime=$(this).attr("data");
		$("preloader").show();
		acceptorder(confirmob);		
		confirmob=null;
	});
	$("body").on('click','.receipt .btn-accept',function(){  
		//acceptorder(this);
		$("#cookingwindow").modal("show");
		confirmob=this;
	});
	$("body").on('click','.receipt .btn-reject',function(){  
		$("#confirmwindow").modal("show");
		confirmob=this;
	});
$("body").on('click','.order .order-info,.order .second',function(){  
	$(".preloader").show();
    loadreceipt($(this).parents(".order"));
});
});
function loadneworders(){	
	$.ajax({
		url:"{{ URL::action('OrderController@newOrders') }}",
		method:"post",
		success:function(html){	
			if(html.indexOf('<head>')!=-1){
				window.location.reload();
				return;
			}
			var nono=[];
			$(html).each(function(){
				if($(this).attr("data")){
				nono.push($(this).attr("data"));	
				if(!$(".order[data="+$(this).attr("data")+"]").html()){
					$(".orders-list").prepend("<div class='"+$(this).attr("class")+"' data='"+$(this).attr("data")+"'>"+$(this).html()+"</div>");
				}else{
					$(".order[data="+$(this).attr("data")+"]").find(".tat-time").html($(this).find(".tat-time").html());
				}
				}
			});
			$(".order").each(function(){
				if(nono.indexOf($(this).attr("data"))==-1)
					$(this).remove();
			});	
			$(".orders-nav .active").click();
			$(".preloader").fadeOut();
		},
		error:function(e){
			$(".preloader").fadeOut();
			//alert(JSON.stringify(e));
		}
	});
}
function loadreceipt(ob){
	var id=$(ob).attr("data");
	$.ajax({
		url:"{{ URL::action('OrderController@loadReceipt') }}",
		data:"id="+id,
		method:"post",
		success:function(html){							
			$(".receipt").html(html);    
			$(".receipt").show();
			$(".preloader").fadeOut();
			
		},
		error:function(e){	
			$(".preloader").fadeOut();
		}
	});
}
function acceptorder(ob){
	var id=$(ob).attr("data");	
	$.ajax({
		url:"{{ URL::action('OrderController@acceptOrder') }}",
		data:"id="+id+"&time="+readytime,
		method:"post",
		success:function(html){				
			$(".order[data="+$(ob).attr("data")+"]").remove();
			loadneworders();
			$(".orders-nav .active").click();
			$(".receipt").hide();
			$(".preloader").fadeOut();
		},
		error:function(e){
			$(".preloader").fadeOut();
			alert(JSON.stringify(e));
		}
	});
}
function rejectorder(ob){
	var id=$(ob).attr("data");
	$.ajax({
		url:"{{ URL::action('OrderController@rejectOrder') }}",
		data:"id="+id,
		method:"post",
		success:function(html){				    
			$(".order[data="+$(ob).attr("data")+"]").remove();
			loadneworders();
			$(".orders-nav .active").click();
			$(".receipt").hide();
			$(".preloader").fadeOut();
		},
		error:function(e){
			$(".preloader").fadeOut();
			alert(JSON.stringify(e));
		}
	});
}
function hideorder(ob){
	var id=$(ob).parents(".order").attr("data");
	$.ajax({
		url:"{{ URL::action('OrderController@hideOrder') }}",
		data:"id="+id,
		method:"post",
		success:function(html){				
			$(ob).parents(".order").remove();
			$(".preloader").fadeOut();
		},
		error:function(e){
			$(".preloader").fadeOut();
			alert(JSON.stringify(e));
			
		}
	});
}
function iframeResponse(message) {
    if(message=="Close"){
		$(".map-block").hide();
	}
}
</script>
@stop