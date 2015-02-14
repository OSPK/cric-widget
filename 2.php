<?php 
$server = $_SERVER['HTTP_HOST'];

$url = "http://". $server . "/data/live.json";
$json = file_get_contents($url);
$obj = json_decode($json);


if ($obj->query->count>0) {
	$scores = $obj->query->results->Scorecard;
}

?>
<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!--meta http-equiv="refresh" content="10; url=http://<?php echo $server . '/2.php'; ?>" -->
		<!--CSS -->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400' rel='stylesheet' type='text/css'>
		<link href="assets/style.css" rel="stylesheet">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body <?php if ($obj->query->count==1) {echo "onload='parent.document.title=document.title'";} ?>>
		<div class="widheader"><strong>Live Score - Daily Pakistan Cricket</strong></div>
		<section class="widget">
			<?php 
				if (is_array($scores)) {
					include_once "doublecontent.php";
				}
				else {
					include_once "widcontent.php";
				}
			?>

		</section>
		<div class="ad">
			Advertise here
		</div>

		<!-- jQuery -->
		<script src="//code.jquery.com/jquery.js"></script>

		<?php if (is_array($scores)) { ?>
			<script type="text/javascript" language="javascript">
				function loadNowPlaying(){
				  $("section.widget").load("doublecontent.php");
				}
				setInterval(function(){loadNowPlaying()}, 10000);
			</script>
		<?php } ?>
		<?php if (!is_array($scores)) { ?>
			<script type="text/javascript" language="javascript">
				function loadNowPlaying(){
				  $("section.widget").load("widcontent.php");
				}
				setInterval(function(){loadNowPlaying()}, 10000);
			</script>
		<?php } ?>
		<?php if ($obj->query->count==1) { ?>
			<script>
				document.title = "<?php if (isset($pagetitle)) {echo $pagetitle;}?>";
			</script>
		<?php } ;?>

		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-59742796-1', 'auto');
		  ga('send', 'pageview');

		</script>
	</body>
</html>