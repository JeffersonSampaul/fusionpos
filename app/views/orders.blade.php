@extends('layouts.layout')
@section('title', 'home')
@section('page-title', 'Current Orders')
@section('content')
 <div class="orders-list">	
 </div>
 <div id="confirmwindow" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <span style="color:#000;line-height:3em;">Are you sure you want to Hide This Order?</span>
		<div style="text-align:center;">
		<span class="btn btn-success approve-btn">YES</span>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<span class="btn btn-danger cancel-btn">NO</span>
		</div>
      </div>
    </div>
  </div>
</div>
<iframe class="hiddenframe"></iframe>
@stop
@section('scripts')
<script>
var confirmob;
$(document).ready(function(){ 
	loadorders();
	setInterval(loadorders,3000);
	$("body").on('click','.btn-print',function(){
		window.location="/print/"+$(this).parents(".order").attr("data");
	});
	$("body").on('click','.cancel-btn',function(){
		$("#confirmwindow").modal("hide");
		confirmob=null;
	});	
	$("body").on('click','.approve-btn',function(){
		$("#confirmwindow").modal("hide");
		hideorder(confirmob);
		confirmob=null;
	});
	$("body").on('click','.hide-order-btn',function(){
	   $("#confirmwindow").modal("show");
	   confirmob=this;
		//hideorder(this);
	});
$("body").on('click','.order .show-btn',function(){      
   if(!$(this).hasClass("hide-btn")){	   
	loadreceipt(this);
   }else{
   $(".receipt").hide();   	   
   $(".order").find(".show-btn").removeClass("hide-btn");
   $(".order").find(".show-btn").html("Show");  
   $(this).removeClass("hide-btn");
   }
});
});
function loadorders(){
	$.ajax({
		url:"{{ URL::action('OrderController@loadcurrentOrders') }}",
		method:"post",
		success:function(html){			
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
		},
		error:function(e){
			//alert(JSON.stringify(e));
		}
	});
}
function loadreceipt(ob){
	var id=$(ob).parents(".order").attr("data");
	$.ajax({
		url:"{{ URL::action('OrderController@loadReceipt') }}",
		data:"id="+id+"&printbtn=1",
		method:"post",
		success:function(html){				
			$(".receipt").hide();
			$(".order").find(".receipt").html(html);
			$(".order").find(".show-btn").removeClass("hide-btn");
			$(".order").find(".show-btn").html("Show");     
			$(ob).parents(".order").find(".receipt").show();
			$(ob).addClass("hide-btn");
			$(ob).html("Close");
		},
		error:function(e){
		//	alert(JSON.stringify(e));
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
		},
		error:function(e){
			alert(JSON.stringify(e));
		}
	});
}
</script>
@stop