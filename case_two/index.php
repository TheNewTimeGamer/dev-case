<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/main.css" type="text/css">
    <link rel="stylesheet" href="case_two.css" type="text/css">
    <title>Dev-case</title>
</head>
<body>
    <nav>
        <a href="/"><div>Home</div></a>
        <a href="/case_one"><div>Case one</div></a>
        <a href="/case_two"><div class="selected">Case two</div></a>
    </nav>

    <?php
        include('api.php');
        if(!isset($_SESSION['api'])){
            $_SESSION['api'] = new Reqres();
            var_dump($_SESSION['api']->getLastResult());
        }
        $token = $_SESSION['api']->getToken();

        if(isset($_POST['submit'])){
            if($_POST['submit'] == 'register'){
                $_SESSION['api']->registerUser($_POST['email'], $_POST['password']);
            }elseif($_POST['submit'] == 'login'){
                $_SESSION['api']->loginUser($_POST['email'], $_POST['password']);
            }elseif($_POST['submit'] == 'logout'){
                $_SESSION['api']->logoutUser();
            }
        }
        echo 'Token: ' . $_SESSION['api']->getToken();
        $page = 1;
        // Developer note: This api end-point doesn't require an authenication token. But for the sake of the dev-case this if-statement serves to simulate such a scenario.
        if($_SESSION['api']->getToken()){
            echo '<div id="resources">';
            do {
                $resources = $_SESSION['api']->getResources($page);
                if(!$resources){
                    echo 'Something went wrong trying to fetch the resources.';
                    break;
                }
                if(isset($resources)){
                    foreach($resources->data as $resource){
                        echo '<br>' . $resource->name . ' = ' . $resource->color;
                    }
                }
            }while($resources->total_pages > $page++);
            echo '</div>';
            echo '<form id="logout" action="" method="POST"><input type="submit" name="submit" value="logout"></form>';
        }else{
            echo    '<form id="login" action="" method="POST">
                    <input type="text" name="email" placeholder="Email">
                    <input type="password" name="password" placeholder="Password">
                    <input type="submit" name="submit" value="register">
                    </form>';            
        }
    ?>
</body>
</html>