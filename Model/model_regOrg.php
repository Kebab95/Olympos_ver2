<?php
include "../includeClasses.php";
$DBTasks = new DBTasks();
session_start();
if($_POST){
	$orgVar = $_POST;

	if($DBTasks->checkEmail($orgVar["orgEmail"])){

		?>
		<div class="alert alert-warning text-center">
			<strong>Figyelem!</strong> Létező email cím
		</div>
		<?php
		$_SESSION = $orgVar;
		include '../View/Organization/view_createOrg.php';
	}
	else {
		$asd =$DBTasks->insertOrganization($orgVar['orgUserID'],
									$orgVar['orgName'],
									$orgVar['orgType'],
									$orgVar['orgShortName'],
									$orgVar['orgEmail'],
									$orgVar['orgTel'],
									$orgVar['orgFax'],
									$orgVar['orgRegNum'],
									$orgVar['orgTaxNum'],
									$orgVar['orgPCode'],
									$orgVar['orgPTown'],
									$orgVar['orgPStreet'],
									$orgVar['orgWebsite'],
									$orgVar['orgTitle']);
		if($asd){
			echo "<script>
	            setTimeout(function () {
	                window.location.href = \"?nav=home\"; //will redirect to your blog page (an ex: blog.html)
	            }, 2000);
	        </script>";
			?>
			<div class="alert alert-success text-center">
				<strong>Sikeres!</strong> Sikeres regisztráció
			</div>
			<?php
		}
		else {
			?>
			<div class="alert alert-danger text-center">
				<strong>Hiba!</strong> Regisztrálás nem sikerült
			</div>
			<?php
			$_SESSION = $orgVar;
			include '../View/Organization/view_createOrg.php';
		}
	}

}
