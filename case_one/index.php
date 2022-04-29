<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/main.css" type="text/css">
    <link rel="stylesheet" href="case_one.css" type="text/css">
    <title>Dev-case</title>
</head>
<body>
    <nav>
        <a href="/"><div>Home</div></a>
        <a href="/case_one"><div class="selected">Case one</div></a>
        <a href="/case_two"><div>Case two</div></a>
    </nav>
    Case One
    <?php
        include('car.php');
    ?>
</body>
</html>