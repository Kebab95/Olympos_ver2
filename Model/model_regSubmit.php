<?php
include "../includeClasses.php";
$DBTasks = new DBTasks();
if( $_POST ){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phno = $_POST['tel'];
    $pass = $_POST['pass'];
    //($_SESSION['DBTasks']->regUser($name,$email,$phno,$pass)

//echo $_SESSION["DBTasks"]->returnInsertQuery(DBData::getEmailDataTable(),"asd","default,'".$email."'", "returning ".DBData::$emailDataID);
if($DBTasks->checkEmail($email)){

    ?>
    <div class="alert alert-warning text-center">
        <strong>Figyelem!</strong> Létező email cím
    </div>
    <?php
    $_SESSION["regName"] = $name;
    $_SESSION["regEmail"] = $email;
    $_SESSION["regTel"] = $phno;
    include '../View/view_reg.php';
}
else{
    if($DBTasks->regUser($name,"1",$email,$phno,$pass)){
        echo "<script>
            setTimeout(function () {
                window.location.href = \"?nav=home\"; //will redirect to your blog page (an ex: blog.html)
            }, 2000);
        </script>";
        ?>
        <div class="alert alert-success text-center">
            <strong>Sikeres!</strong> Sikeres regisztráció
        </div>
        <div class="alert alert-info text-center">
            <strong>Figyelem!</strong> Regisztráció megerősítő email cím elküldve a megadott email-címre
        </div>
        <?php
    }
    else {
        ?>
        <div class="alert alert-danger text-center">
            <strong>Hiba!</strong> Nem sikerült a regisztráció
        </div>
        <?php
    }
}

 }