<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="hu">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title><?php echo $siteTitle?></title>

	<!-- Latest compiled and minified CSS -->
	<!--<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>!-->
	<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>




	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.14.30/js/bootstrap-datetimepicker.min.js"></script>

	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Indie+Flower" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<!-- Optional theme

	<link rel="stylesheet" href="css/bootstrap-theme.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="js/bootstrap.min.js"></script>
	<script src="js/site.js"></script>


	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="css/bootstrap-datetimepicker.min.css"/>
	<link rel="stylesheet" type="text/css" href="css/superhero.css"/>
	<!--<link rel="stylesheet" type="text/css" href="css/freelancer.min.css"/>!-->
	<link rel="stylesheet" type="text/css" href="css/site.css"/>
	<link rel="stylesheet" type="text/css" href="css/style.css" />

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>

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
				<a class="navbar-brand" href="?nav=home"><?php echo $navBarTitle?></a>
			</div>
			<div class="navbar-right navbar-text cursor dropdown-toggle" data-toggle="dropdown" data-target="#navBar-dropdown" role="button" aria-haspopup="true" aria-expanded="false">
				<?php
				echo $userName;
				?>
				<span class="caret"></span>
			</div>

			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<?php
						foreach ($navBarItems as $item) {
							echo '<li><a href="'.$item["href"].'">'.$item["title"].'</a></li>';
						}
					?>
				</ul>
			</div>
			<div class="testDropD">
			<ul class="nav navbar-nav  navbar-right">
				<li class="dropdown" id="navBar-dropdown">

					<ul class="dropdown-menu">

						<?php
						if(is_array($userDropbox)) {
							foreach ($userDropbox as $key => $item) {
								if($item['title']=="Profil"){
									echo '<li><a onclick="showModalProfile('.UserTasks::getUser()->getId().','.UserTasks::getUser()->getId().')"><i class="fa"></i> '.$item['title'].'</a></li>';
								}
								else {
									echo '<li><a href='.$item['href'].'><i class="fa"></i> '.$item['title'].'</a></li>';
								}

							}
							?>
							<li class="divider"></li>
							<li><form action="" method="post"><input type="submit" name="logout" class="btn btn-danger center-block" value="<?php echo $userLogout["title"]?>"></form></li>
							<!--<li><a href="?nav=logout"><i class="fa fa-power-off"></i> Log Out</a></li>!--><?php
						}
						else {
							include $userDropbox;
						}
						?>
					</ul>

				</li>
			</ul>
			</div>
		</div>

	</nav>
	<div class="inBody">
		<?php
			include $inBody;
		?>
	</div>


</div>
<div id="ProfileModalHire"></div>

<div id="footer">
	<div class="container">
		<p class="text-muted credit"><a href="#"><?php echo $footerText?></a></p>
	</div>
</div>
</body>
</html>