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
     * @param string $name Name/Identification of the car.
     * @param string $model Model of the car.
     * @param mixed $color Color of the car.
     * @param double $maxSpeed Maximum speed of the car in m/s.
     * @param double $acceleration Acceleration of the car in m/s².
     * @param string $powerplant Powerplant of the car (Diesel, Gasoline, Electric, Hydrogen).
     * @param string $drive Drive of the car. (FWD, RWD, AWD)
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

    public function __toString() {
        return $this->name . ' ' . $this->model . ' ' . $this->color . ' ' . $this->maxSpeed . ' ' . $this->acceleration . ' ' . $this->powerplant . ' ' . $this->drive;
    }

}

// This class is used to represent a car.
class Car {

    public $properties;

    private $currentSpeed = 0;
    private $angle = 0;

    public function __construct($properties) {
        $this->properties = $properties;
    }
    
    /**
     * @param double The angle in degrees to turn (Clockwise orientation).
     * @return double new angle of the car.
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
     * @return double The angle/direction of the car in degrees.
     */
    public function getAngle() {
        return $this->angle;
    }

    /**
     * @param double $time for how long the car needs to accelerate in seconds.
     * @param double $acceleration Acceleration override in m/s². (Use to limit acceleration).
     * @return array An array containing the new speed of the car and the distance traveled.
     */
    public function accelerate($time, $acceleration=null) {
        if(!$acceleration) {
            $acceleration = $this->properties->acceleration;
        }
        $timeTillTopSpeed = ($this->properties->maxSpeed - $this->currentSpeed) / $acceleration;  // Get time till max speed is achieved.
        $deltaTime = 0;
        if($time > $timeTillTopSpeed) {
            $deltaTime = $time-$timeTillTopSpeed;                                                 // Calculate the remaining time the accelerator is held down.
            $time = $timeTillTopSpeed;
        }
        $this->currentSpeed = $this->currentSpeed + $acceleration * $time;                        // Calculate the new speed.
        $distance = ($this->currentSpeed * $time) + 0.5*($acceleration * ($time * $time));        // Calculate distance traveled while accelerating.
        $distance = $distance + ($deltaTime * $this->properties->maxSpeed);                       // Add remaining distance traveled while at max speed.
        return array("speed"=>$this->currentSpeed, "distance"=>$distance);
    }

    /**
     * @param double $reactionTime Driver's reaction time in seconds.
     * @param double $frictionCoefficient Friction coefficient of the road (0.7 = dry, 0.5 = wet, 0.3 = very wet or ice).
     * @param double $slope The incline of the road in degrees. Positive is uphill, negative is downhill.
     * @return double The distance in meters till the car comes to a full stop.
     */
    public function getDistanceTillStop($reactionTime=1, $frictionCoefficient=0.7, $slope=0) {
        return  (0.278 * $reactionTime * $this->currentSpeed)                                       
                + ($this->currentSpeed*$this->currentSpeed) 
                / (254 * ($frictionCoefficient + $slope));                            
    }

    /**
     * @param double $distance Distance in meters at which the car is estimated to come to a full stop at the current speed. (near estimate).
     * @return double The time in seconds it takes the car to come to a full stop.
     */
    public function getTimeTillStop($distanceTillStop) {
        return $distanceTillStop / $this->currentSpeed;
    }

    /**
     * @param double $time for how long the car needs to decelerate in seconds.
     * @param double $reactionTime time in seconds before the driver hits the brake.
     * @param double $frictionCoefficient how much traction the road has (0.7 is dry, 0.3/0.5 is wet).
     * @param double $slope the incline of the road (Positive incline is up hill).
     * @return array An array containing the new speed of the car and the distance traveled.
     */
    public function brake($time, $reactionTime=1, $frictionCoefficient=0.7, $slope=0) { 
        $distanceTillStop = $this->getDistanceTillStop($reactionTime, $frictionCoefficient, $slope);
        $timeTillStop = $this->getTimeTillStop($distanceTillStop);    
        $delta = $timeTillStop - $time;         
        if($delta < 0) {
            $delta = 0;
        }                           
        $this->currentSpeed = $delta * $this->currentSpeed;                                                      // Calculate new speed (near estimate).
        $distance = ($time / $timeTillStop) * $distanceTillStop;                                                 // Calculate distance traveled while decelerating (near estimate)
        return array("speed"=>$this->currentSpeed, "distance"=>$distance);
    }

    public function __toString() {
        return $this->currentSpeed . ' ' . $this->angle;
    }

}