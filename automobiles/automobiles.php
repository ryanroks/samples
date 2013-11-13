<?php

/*
	Automotive Factory
	
	Creates new instances of a car with 
	options you set.
*/

error_reporting(E_ERROR | E_WARNING | E_PARSE);

class createCar {

	protected 
		$max_speed, 
		$car_model, 
		$functions,
		$optionFunctions,
		$transmission_type,
		$opts;

	public function __construct($car_model, $transmission_type, $extra_options="") {
	
		$this->car_model = $car_model;
		$this->transmission_type = $transmission_type;
		
		$this->functions = 
			array(
				'find_me' => 'gps',
				'listen_to_music' => 'radio',
				'open_roof' => 'sunroof'
				);
		$this->optionFunctions = new extras();		
				
		$this->opts = $extra_options;
		
		switch($this->car_model) {
			
			case "SUV":
			
				$this->max_speed = 100;
				break;
				
			case "Sports Car":
				
				$this->max_speed = 150;
				break;
				
			case "Mini-van":
				
				$this->max_speed = 80;
				break;
				
			default:
			
				return "You selected an incorrent car";
				break;
				
			
				}
		
		}
 
	public function __call($name, $arguments) {
	
		/*
			Calls function from extras if 
			the proper options are set to TRUE
		*/
	
		if (
			array_key_exists($name, $this->functions) 
			&& $this->opts[$this->functions[$name]] == TRUE
			) {
			return $this->optionFunctions->{$name}();
			}
			
		}
	
	private function outputData($output) {
	
		$text = $output;
		if($this->opts['heated_seats'] == TRUE)
			$text .= "...mmm toasty!...";
		$text .= "<br />";
		
		print $text;
	
		}
	
	public function start() {
	
		/*
			Starts up the car
		*/
				
		$this->outputData("Starting car, ".$this->car_model." with ".$this->transmission_type." transmission.");
		
		if($this->opts) {
			foreach($this->opts as $key => $value) {
			
				$this->outputData("Add on feature: " . $key);
			
				}
			}
	
		}
		
	public function drive() {
	
		print("...vroom, vroom...reaching max speed of " . $this->max_speed . "<br />");
	
		}
		
	public function off() {
	
		print("Stopped!<br />");
	
		}

	}
	
class extras {

	public function find_me() {
	
		print("The GPS is on! Tell me where to go!<br />");
		
		}
 
	public function listen_to_music() {
 
		print("Lets listen to the radio!<br />");
 
		}
		
	public function open_roof() {
	
		print("Look the moon roof is open!<br />");
	
		}
 
	}

/*
	Begin creating cars
*/

/* Blank car, no extras */
$cars[1] = new createCar("SUV", "Automatic");
$cars[1]->start();	
$cars[1]->drive();
$cars[1]->off();

print "<br />";

/* Sports car, "fully loaded" */
$cars[2] = new createCar("Sports Car", "Manual",
	array(
		"heated_seats" => TRUE,
		"sunroof" => TRUE,	
		"radio" => TRUE,
		"gps" => TRUE
		)
	);
$cars[2]->start();	
$cars[2]->drive();
$cars[2]->find_me();
$cars[2]->listen_to_music();
$cars[2]->open_roof();
$cars[2]->off();

print "<br />";

/* Mini van, with heated seats */
$cars[3] = new createCar("Mini-van", "Automatic",
	array(
		"heated_seats" => TRUE
		)
	);
$cars[3]->start();	
$cars[3]->drive();
$cars[3]->off();

print "<br />";

/* SUV car, with everything except heated seats */
$cars[4] = new createCar("SUV", "Automatic",
	array(
		"sunroof" => TRUE,	
		"radio" => TRUE,
		"gps" => TRUE
		)
	);
$cars[4]->start();	
$cars[4]->drive();
$cars[4]->find_me();
$cars[4]->listen_to_music();
$cars[4]->open_roof();
$cars[4]->off();

print "<br />";

/* Mini van, with only a radio */
$cars[5] = new createCar("Mini-van", "Automatic",
	array(
		"radio" => TRUE,
		)
	);
$cars[5]->start();	
$cars[5]->drive();
$cars[4]->listen_to_music();
$cars[5]->off();

?>