<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="hu">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>Olympos</title>

	<!-- Latest compiled and minified CSS -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Indie+Flower" rel="stylesheet">



	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<!-- Optional theme

	<link rel="stylesheet" href="css/bootstrap-theme.min.css">

h

	<!-- Latest compiled and minified JavaScript -->
	<script src="js/bootstrap.min.js"></script>
	<script src="js/site.js"></script>
	<link rel="stylesheet" type="text/css" href="css/site.css"/>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="css/freelancer.min.css"/>

	<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
<div class="body">
	<nav class="navbar navbar-default">
		<div class="container-fluid navMyWidth">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<div class="navbar-header">
				<a class="navbar-brand" href="?nav=home">Olympos</a>
			</div>
			<div class="navbar-right navbar-text cursor" data-toggle="dropdown" data-target="<?php echo (isset($_SESSION["User"])?".user-dropdown":".login-dropdown")?>">
				<?php
				echo $user;
				?>
			</div>

			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li><a href="#">Item 1</a></li>
					<li><a href="#">Item 2</a></li>
					<li><a href="#">Item 3</a></li>
				</ul>
			</div>

			<?php
			if(is_array($userDropbox)){
			?><ul class="nav navbar-nav navbar-user navbar-right">
				<li class="dropdown user-dropdown">
					<ul class="dropdown-menu">
						<?php
						foreach ($userDropbox as $key => $item) {
							echo '<li><a href='.$item['href'].'><i class="fa"></i> '.$item['title'].'</a></li>';
						}
						?>
						<li class="divider"></li>
						<li><a href="?nav=logout"><i class="fa fa-power-off"></i> Log Out</a></li>
					</ul>
				</li><?php
				}else {
					include $userDropbox;
				}

				?>
		</div>

	</nav>
	<div class="inBody">
		<?php
		include $inBody;
		?>
	</div>
	<nav class="navbar navbar-fixed-bottom" id="footer">
		<small>
			<div class="container">
				<div class="text-right"><a href="#">Olymposról</a></div>
			</div>
		</small>

	</nav>
</div>
</body>
</html>
<?php
function sessionRemove(){
	unset($_SESSION["regName"]);
	unset($_SESSION["regEmail"]);
	unset($_SESSION["regTel"]);
}
?>