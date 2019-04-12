<?php
	require_once "config.php";

	if (isset($_SESSION['access_token'])) { #isset — Определяет, была ли установлена переменная access_token значением, отличным от NULL
		header('Location: index.php');
		exit(); # прекращает выполнение текущего скрипта
	}

	$redirectURL = "https://authorization.cf/fb-callback.php";#url куда перейти после входа
	$permissions = ['email'];
	$loginURL = $helper->getLoginUrl($redirectURL, $permissions);#Вызываем помощника для выполнения авторизации, указываем требуемые разрешения для публикации на странице
?>
<!doctype html>
<html lang="ru">
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
				<img src="images/logo.png"><br><br>
                <?PHP
                require_once"db.php";
                $data=$_POST;
                if(isset($data['do_signup'])) {

                    if (trim($data['login']) == '') {

                        $errors[] = 'input login!';
                    }
                    if (trim($data['password']) == '') {

                        $errors[] = 'input password!';
                    }

                    $user=R::find('users',"login=?", array($data['login']));
                    if($user)
                    {
                        if(!password_verify($data['password'],$user->password)){

                        }
                            else{
                                $errors[]="Wrong password!";
                            }
                            }
                            else{
                                $errors[]="User with such login not found!";
                            }





                    if(empty($errors))
                {

                    echo'<div style="color: green;" >Authorization was successful!</div>';

                }
                else{

                   echo'<div style="color: red;" >'.array_shift($errors).'</div>';
                }
                
                }
                ?>

				<form method="POST" action="/login.php">
					<input type= "text" name="login" placeholder="login" class="form-control" value="<?php echo @$data['login'];?>"><br>
					<input name="password" type="password" placeholder="Password" class="form-control"><br>
                    <button type="submit"  name="do_signup" class="btn btn-primary">Log In</button>
					<input type="button" onclick="window.location = '<?php echo $loginURL ?>';" value="Log In With Facebook" class="btn btn-primary">

                </form>
                    <form method="POST" action="/register.php">

                    <p style="color: green;"><strong>OR</strong></p>
                        <button type="submit"  name="register" class="btn btn-primary">To Register</button>


                    </form>



			</div>
		</div>
	</div>

</body>
</html>