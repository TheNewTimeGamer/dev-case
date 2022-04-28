<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css" type="text/css">
    <link rel="stylesheet" href="css/landing.css" type="text/css">
    <title>Tasklist</title>
</head>
<body>
    Case Two
    <form action="" method="POST">
        <input type="text" name="email" placeholder="Email">
        <input type="password" name="password" placeholder="Password">
        <input type="submit" name="submit" value="register">
    </form>

    <?php
        include('api.php');
        if(!isset($_SESSION['api'])){
            $_SESSION['api'] = new Reqres();
        }
        if(isset($_POST['submit'])){
            if($_POST['submit'] == 'register'){
                echo 'r';
                $_SESSION['api']->registerUser($_POST['email'], $_POST['password']);
            }elseif($_POST['submit' == 'login']){
                $_SESSION['api']->loginUser($_POST['email'], $_POST['password']);
            }
        }
        echo 'Token: ' . $_SESSION['api']->getToken();
    ?>
</body>
</html>