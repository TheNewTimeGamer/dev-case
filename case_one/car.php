<?php

// This class contains properties for a car.
class CarProperties {

    public $name;
    public $model;
    public $color;
    public $maxSpeed;
    public $acceleration;

    public $powerplant;
    public $drive;

    /**
     * @param $name Name/Identification of the car.
     * @param $model Model of the car.
     * @param $color Color of the car.
     * @param $maxSpeed Maximum speed of the car in m/s.
     * @param $acceleration Acceleration of the car in m/s².
     * @param $powerplant Powerplant of the car (Diesel, Gasoline, Electric, Hydrogen).
     * @param $drive Drive of the car. (FWD, RWD, AWD)
     */    
    public function __construct($name, $model, $color, $maxSpeed, $acceleration, $powerplant, $drive) {
        $this->name = $name;
        $this->model = $model;
        $this->color = $color;
        $this->maxSpeed = $maxSpeed;
        $this->acceleration = $acceleration;
        $this->powerplant = $powerplant;
        $this->drive = $drive;
    }

}

// This class is used to represent a car.
class Car {

    public $properties;

    private $currentSpeed;
    private $angle;

    public function __construct($carProperties) {
        $this->properties = $properties;
    }
    
    /**
     * @param $degrees The angle in degrees to turn (Clockwise orientation).
     * @return The new angle of the car.
     */
    public function turn($degrees) {
        $this->angle = $this->angle + $degrees;
        if($this->angle > 360) {
            $this->angle = $this->angle - 360;
        }elseif($this->angle < 0) {
            $this->angle = $this->angle + 360;
        }
        return $this->angle;
    }

    /**
     * @param $time for how long the car needs to accelerate in seconds.
     * @return An array containing the new speed of the car and the distance traveled.
     */
    public function accelerate($time) {
        $timeTillTopSpeed = ($this->properties->maxSpeed - $this->currentSpeed) / $this->properties->acceleration;  // Get time till max speed is achieved.
        $deltaTime = 0;
        if($time > $timeTillTopSpeed) {
            $deltaTime = $time-$timeTillTopSpeed;                                                                   // Calculate the remaining time the accelerator is held down.
            $time = $timeTillTopSpeed;
        }
        $this->currentSpeed = $this->currentSpeed + $this->properties->acceleration * $time;                        // Calculate the new speed.
        $distance = ($this->currentSpeed * $time) + 0.5*($this->properties->acceleration * ($time * $time));        // Calculate distance traveled while accelerating.
        $distance = $distance + ($deltaTime * $this->properties->maxSpeed);                                         // Add remaining distance traveled while at max speed.
        return array("speed"=>$this->currentSpeed, "distance"=>$distance);
    }

    /**
     * @param $time for how long the car needs to decelerate in seconds.
     * @param $reactionTime time in seconds before the driver hits the brake.
     * @param $frictionCoefficient how much traction the road has (0.7 is dry, 0.3/0.5 is wet).
     * @param $slope the incline of the road (Positive incline is up hill).
     * @return An array containing the new speed of the car and the distance traveled.
     */
    public function brake($time, $reactionTime=1, $frictionCoefficient=0.7, $slope=0) {
        $distanceTillStop = (0.278 * $reactionTime * $this->currentSpeed)                                       // Calculate distance travelled while braking.
                            + ($this->currentSpeed*$this->currentSpeed) 
                            / (254 * ($frictionCoefficient + $slope));

        $timeTillStop = $distanceTillStop / $this->currentSpeed;                                                // Calculate time till stop.
        $this->currentSpeed = ($time / $timeTillStop) * $this->currentSpeed;                                    // Calculate new speed (near estimate).
        $distance = ($time / $timeTillStop) * $distanceTillStop;                                                // Calculate distance traveled while decelerating (near estimate)
        return array("speed"=>$this->currentSpeed, "distance"=>$distance);
    }

}