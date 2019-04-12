<?php

require "libs/rb.php";

	session_start();

	if (!isset($_SESSION['access_token'])) {
		header('Location: login.php');
		exit();
	}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Log In</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
</head>
<body>

<div class="container" style="margin-top: 100px">
    <div class="row justify-content-center">
        <div class="col-md-6 col-md-offset-3" align="center">
<?php
require_once"db.php";
$social = R::dispense('facebook');
if (R::count('facebook',"id_fb=?",array($_SESSION['userData']['id']))>0){
echo'<br><br><div id="elem" style="color: green;" >Authorization was successful!</div><br><br>';
}
else{
$social->first_name=$_SESSION['userData']['first_name'];
$social->last_name=$_SESSION['userData']['last_name'];
$social->id_fb=$_SESSION['userData']['id'];
$social->picture=$_SESSION['userData']['picture']['url'];
R::store($social);
echo'<br><br><div id="elem" style="color: green;" >You are successfully registered!</div><br><br>';
}
?>

            <img src="<?php echo $_SESSION['userData']['picture']['url'] ?>"><br><br>

        </div>

        <div class="col-md-9">
            <table class="table table-hover table-bordered">

                <tbody>

                <tr>
                    <td>First Name</td>
                    <td name="login"><?php echo $_SESSION['userData']['first_name'] ?></td>
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td name="last_name"><?php echo $_SESSION['userData']['last_name'] ?></td>
                </tr>
                <tr>
                    <td>City</td>
                    <td name="city"><?php echo $_SESSION['userData']['location']['name']?></td>
                </tr>

                </tbody>
            </table>

        </div>
    </div>
</div>

</body>
</html>