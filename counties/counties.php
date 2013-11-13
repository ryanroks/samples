<?php

/*
	Brutce force style of solving this.
*/

set_time_limit(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

class mapping {

	public 
		$current_lowest_miles, 
		$output_text, $count = 0;

	public function get_distance($coords1, $coords2) {
		
		if(!$coords2)
			return;
		
		$tmp = explode("	", $coords1);
		$lat1 = trim($tmp[0]);
		$lon1 = trim($tmp[1]);
		
		$tmp = explode("	", $coords2);
		$lat2 = trim($tmp[0]);
		$lon2 = trim($tmp[1]);
		
		/*
			Converted circle function
			to PHP.
		*/
		
		$tmp = acos(
		  cos(
		   deg2rad ($lat1)
		   )
		  * cos(
		   deg2rad ($lat2)
		   )
		  * cos(
		   (deg2rad ($lon1) - deg2rad ($lon2))
		   )
		  + sin(
		   deg2rad ($lat1)
		   )
		  * sin(
		   deg2rad ($lat2)
		   )
		  );
		  
		return number_format((rad2deg($tmp) * 69.09), 4);
		
		}

		
	/*
		Permutates the array, then calculates
		the distance in order of coordinates
	*/
	
	public function startPermutations($items, $perms = array()) {
		if (empty($items)) {
		  $this->calculatePath($perms);
		}
		else {

			for ($i = count($items) - 1; $i >= 0; --$i) {
					
				$newitems = $items;
				list($foo) = array_splice($newitems, $i, 1);
				$newperms = $perms;
				array_unshift($newperms, $foo);
				$this->startPermutations($newitems, $newperms);	

					
				}
					
			}
		
		}



	/*
		Gets distance of coordinates in order.
		If its the shortest, it puts it in the
		public variable.
	*/
	public function calculatePath($data) {

		$i = 0;
		while($i < count($data)) {
		
			if(!$data[$i + 1]) 
				break;
		
			$distance = $this->get_distance($data[$i], $data[$i + 1]);;
		
			$tmp .= "Distance From <b>".$data[$i]."</b> to <b>".$data[$i + 1]."</b> : $distance miles<br>";
			$lowest_miles += $distance;

			$i++;
			
			}	
			
		if($lowest_miles < $this->current_lowest_miles || empty($this->current_lowest_miles)) {
			$this->current_lowest_miles = $lowest_miles;
			$this->output_text = $tmp;
			}

		}
		
	}
	
$time_start = microtime(true);	
	
$map = new mapping();
 
 
/*
	Populate $data with coordinates
*/
 
$i = 0;
$fp = fopen("counties.txt", "r");
while($buf = fgets($fp)) {

	$data[$i] = $buf;
	$i++;
	
	if($i == $_GET['i']) break;
	/*
		If you uncomment the line above,
		and run counties.php?i=8 or so it will work.
		Anything above and it is too much
		for the PHP to handle.
	*/
	
	}

	
$map->startPermutations($data, array());
	
print $map->output_text . "<br>".$map->current_lowest_miles." Miles In Total";

echo "<br><br>This executed in ".number_format((microtime(true) - $time_start) / 60, 2)." minutes";

?>