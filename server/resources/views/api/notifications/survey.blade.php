<style>
.btn span.glyphicon {
	opacity: 0;
}
.btn.active span.glyphicon {
	opacity: 1;
}
</style>
<?php
use App\Actions\Api\SurveyAction;

if(isset($notification)) {
	$id = $notification->id;
	$mode = $notification->type_check;
}

//Get List Options
$surveyAction = new SurveyAction();
$listOption = $surveyAction->getOptions($id);
?>
<div style="background-color: CDCCCC; padding-top: 20px; padding-bottom: 20px; margin-top: 30px;">
<table>
	<tr>
		<td align="center" valign="top">
			<div class="btn-group" data-toggle="buttons">
				<label class="btn btn-default" style="margin: 5px">
					<input type="checkbox" autocomplete="off">
					<span class="glyphicon glyphicon-ok"></span>
				</label>
			</div>
		</td>
		<td align="left">
			<p style="font-size: 14px" align="left"><b>Theo thống kê, Liverpool dưới thời</b></p>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<hr/>
		</td>
	</tr>
	
	<tr>
		<td align="center" valign="top">
			<div class="btn-group" data-toggle="buttons">
				<label class="btn btn-default" style="margin: 5px">
					<input type="checkbox" autocomplete="off">
					<span class="glyphicon glyphicon-ok"></span>
				</label>
			</div>
		</td>
		<td align="left">
			<p style="font-size: 14px" align="left"><b>Theo thống kê, Liverpool dưới thời Juergen Klopp ấn tượng nhất: nhiều bàn thắng nhất (101 bàn), tạo nhiều cơ hội nhất (664 lần), tắc bóng tốt nhất  (811 lần).</b></p>
		</td>
		<td>
	</tr>
</table>
</div>

<script src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<link href="{{ URL::asset('resources/bootstrap/css/bootstrap.css') }}" rel="stylesheet">