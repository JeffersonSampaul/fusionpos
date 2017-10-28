@foreach($orders as $order)
<div class="order @if($order->status==2) {{'rejected-order'}} @endif @if($order->status==0) {{'new-order'}} @else {{'current-order'}}@endif" data="{{ $order->id }}">
<div class="order-info">
@if($order->status==0)
		<div class="order-type">{{"N"}}</div>
		@endif
@if($order->otype==0)
	<i class="fa fa-car"></i>
@else
	<i class="fa fa-shopping-bag"></i>
@endif
</div>
@if($order->status==1 ||$order->status==2)
		<a class="order-hide" href="#"><i class="fa fa-window-close light-gray"></i></a>
@endif	
<div class="second">	
		<div class="customer-name"><i class="fa fa-user gray"></i> {{ $order->id }} {{ $order->customer->fname }} {{ $order->customer->lname }}</div>				
		@if($order->otype==0)
		<div class="address"><i class="fa fa-map-marker gray"></i> {{ $order->customer->dno }} {{ $order->customer->add1 }} {{ $order->customer->add2 }} {{ $order->customer->postcode }}</div>
		@endif		
		<div class="phone"><i class="fa fa-phone red"></i> <a href="#">{{ $order->customer->phone }}</a></div>
		<div class="amount">&pound;{{ $order->total }}</div>
		<div class="time"><i class="fa fa-exclamation warning"></i>@if($order->status==0) {{"Pending "}} @elseif($order->status==1) {{"Accepted "}} @elseif($order->status==2){{"Rejected "}} @elseif($order->status==3){{"Completed "}} @endif {{" - Order  ".$order->sno." "}} {{ Carbon\Carbon::createFromTimestamp($order->datetime)->format('d/m/Y h:i A')}}</div>	
	</div>
	</div>
	@endforeach