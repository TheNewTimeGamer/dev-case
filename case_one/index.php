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
    <div id="notation">
        <h3>This output is just meant to be a demo of <a href="https://github.com/TheNewTimeGamer/dev-case/blob/master/case_one/car.php">car.php</a>'s functionality.</h3>
        <h4>This isn't meant to look nice, but to demonstrate that the code works.</h4>
        <h4><a href="/case_two">Case Two</a> has actual styling.</h4>
    </div>
    <?php
        include('car.php');
        // Developer note: The following code is ugly but pragmatic, it demonstrates the functionality within 'car.php' which is the actual subject of the assignment.
        // Case Two has actual styling :)
        // https://en.wikipedia.org/wiki/Rimac_Nevera
        // Top speed and acceleration of the car converted to m/s.
        $carProperties = new CarProperties('Rimac Nevera', 'Rimac C_Two', 'Purple', 114.4, 14.1812, 'Electric', 'AWD');
        $car = new Car($carProperties);
        echo "Created new car: ";
        echo "<br>";
        echo $carProperties;
        echo "<br>";
        echo "<br>";
        echo "Accelerating to 80km/h (22m/s) over 500m. Using an acceleration of 1.45 m/s² over 15.2 seconds.";
        echo "<br>";
        echo "Acceleration of the car is limited to achieve parameters. This simulates the driver not pressing down the gas pedal fully.";
        echo "<br>";
        var_dump($car->accelerate(15.2, 1.45));
        echo "<br>";
        echo "<br>";
        echo "Car angle: " . $car->getAngle();
        echo "<br>";
        echo "Turning left 90 degrees.";
        echo "<br>";
        echo "Car angle: " . $car->turn(-90);
        echo "<br>";
        echo "<br>";
        echo "Stopping car:";
        echo "<br>";
        $distanceTillStop = $car->getDistanceTillStop(0.5, 0.7, 0);
        $timeTillStop = $car->getTimeTillStop($distanceTillStop);
        var_dump($car->brake($timeTillStop+1));
    ?>
</body>
</html>