<?php 
use App\Notification
?>
<style>
p, h4{
	text-align: justify;
	font-family: arial;
}
</style>
<div>
	<table style="width: 100%;">
		<tr>
			<td valign="top">
				<h4 style="margin:0 0 5 0; text-align: left; margin-bottom: 13px">{{ mb_strtoupper($notification->title, 'UTF-8') }}</h4>
				<h5 style="margin:0 0 0 0; text-align: left; font-family: Helvetica">{{ $notification->created_at->format('d/m/Y - H:i') }}</h5>
				<h5 style="margin:0 0 5 0; pading: 0 0 0 0; text-align: left; font-family: Helvetica">Mã TBVNL837343</h5>
				<div style="margin-bottom: 10">
				</div>
			</td>
			<td width="12%" valign="top" align="right">
				<img src="{{ URL::asset('images/notification-icon.png') }}"  style="width:100%; height:auto;">
				
			</td>
		</tr>
	</table>
	
	<h4 style="margin:15 0 5 0">{{ $notification->subTitle }}</h4>
	
	<p><?php echo $notification->content ?></p>
</div>