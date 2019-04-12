<?php
require_once "config.php";

if (isset($_SESSION['access_token'])) { #isset � ����������, ���� �� ����������� ���������� access_token ���������, �������� �� NULL
    header('Location: index.php');
    exit(); # ���������� ���������� �������� �������
}

$redirectURL = "https://authorization.cf/fb-callback.php";#url ���� ������� ����� �����
$permissions = ['email'];
$loginURL = $helper->getLoginUrl($redirectURL, $permissions);#�������� ��������� ��� ���������� �����������, ��������� ��������� ���������� ��� ���������� �� ��������
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
            <img src="images/logo.png"><br><br>
            <?PHP
            require_once"db.php";
            $data=$_POST;
            if(isset($data['to_register'])) {
                # ����� ������������
                if (trim($data['login']) == '') {

                    $errors[] = 'input login!';
                }
                if (trim($data['password']) == '') {

                    $errors[] = 'input password!';
                }


                if (R::count('users',"login=?", array($data['login']))>0 ){

                    $errors[] = 'User with this login already exists!';
                }


                if(empty($errors))
                {
                    $user=R::dispense('users');
                    $user -> login=$data['login'];
                    $user->password= password_hash($data['password'], PASSWORD_DEFAULT);
                    $id = R::store($user);
                    echo'<div style="color: green;" >You are successfully registered!</div>';

                }
                else{

                    echo'<div style="color: red;" >'.array_shift($errors).'</div>';
                }

            }
            ?>

            <form method="POST" action="/register.php">
                <input type= "text" name="login" placeholder="login" class="form-control" value="<?php echo @$data['login'];?>"><br>
                <input name="password" type="password" placeholder="Password" class="form-control"><br>
                    <button type="submit"  name="to_register" class="btn btn-primary">To Register</button>
                <input type="button" onclick="window.location = '<?php echo $loginURL ?>';" value="To Register With Facebook" class="btn btn-primary">


                </form>
            </form>


        </div>
    </div>
</div>

</body>
</html>