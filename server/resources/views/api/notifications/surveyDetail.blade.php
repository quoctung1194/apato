<?php 
use App\Notification
?>
<style>
div, p {
	text-align: justify;
}
</style>
<html>
	<body>
		<div>
			<?php echo $notification->content ?>
		</div>
	</body>
</html>
<script>
	window.location.hash = 1;
	var calculator = document.createElement("div");
	calculator.id = "height-calculator";
	while (document.body.firstChild) {
		calculator.appendChild(document.body.firstChild);
	}
	document.body.appendChild(calculator);
	document.title = calculator.scrollHeight;
</script>

<style>
body, html, #height-calculator {
	margin: 0;
	padding: 0;
}
#height-calculator {
	position: absolute;
	top: 0;
	left: 0;
	right: 0;
}
</style>