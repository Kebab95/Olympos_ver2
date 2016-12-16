<?php
if(isset($_POST["logEmail"]) && isset($_POST["logPass"])){
    $email = $_POST["logEmail"];
    $pass = $_POST["logPass"];
}
else {
    $email ="";
    $pass="";
}
if($DBTasks->checkEmailPass($email,$pass)){
    $_SESSION["User"]=DBLoad::loadLoginUser($email,$pass);
    header_remove();
    header("Location: ?nav=home");
}
else {
        ?>
        <div class="alert alert-danger text-center">
            <strong>Hiba!</strong> Sikertelen belépés!<br/>
            <div class="help-block">Nem létező email cím vagy rossz jelszó</div>
        </div>
        <form method="post" action="?nav=login" class="navbar-form center-block">
            <div class="row regInputs center-block">
                <div class="col-md-4">
                    Email cím
                </div>
                <div class="col-md-8">
                    <input required type="email" name="logEmail" class="form-control" aria-describedby="basic-addon1">
                </div>
                <div class="col-md-4">
                    Jelszó
                </div>
                <div class="col-md-8">
                    <input required type="password" name="logPass" class="form-control" aria-describedby="basic-addon1">
                    <div class="help-block text-right"><a href="?nav=login&pass=help">Elfelejtette a jelszavát ?</a></div>
                </div>
                <div class="col-md-12">
                    <input type="submit" name="login" value="Bejelentkezés" class="btn btn-primary btn-block" aria-describedby="basic-addon1">
                </div>
                <div class="col-md-12 text-right">
                    Velünk vagy ? <a href="?nav=reg"><b>Csatlakozz!</b></a>
                </div>
            </div>
        </form><?php

}
?>

