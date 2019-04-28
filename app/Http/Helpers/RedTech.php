<?php

/************************************************************/
/* WEWORK - PHP CODING CHALLENGE.... BY CHARLES				*/
/************************************************************/

namespace App\Http\Helpers;

class RedTech {	
	private $natonfile = 'countries.json';
	private $locfile = 'locations.json';
	private $assets = 'assets';
	private $countryData;
	private $locationData;
	private $locationFloors;
	public $error;
	
	
	
	
	//-- instantiate
	function __construct () {		
		$this->countryData = null;		
		$this->locationData = null;
		$this->locationFloors = [];
		$this->error = null;
	}
	
	
	/*
	 * get countries
     */
	private function get_countries () {
		
		//-- payload
		if (!$this->countryData) {
			$this->countryData = json_decode(file_get_contents($this->assets . '/' . $this->natonfile), true);
		}
	}
	
	
	/*
	 * get locations
     */
	private function get_locations () {
		
		//-- payload
		if (!$this->locationData) {
			$this->locationData = json_decode(file_get_contents($this->assets . '/' . $this->locfile), true);
		}	
	}
	
	
	/*
	 * get a location's key
     * @param int $locationid
     * @return int|null of location's key
     */
	private function get_location_key ($locationid) {
		
		//-- loop through locations
		foreach ($this->locationData AS $key => $location) {
			if ($location['id'] == $locationid) {
				return $key;
			}
		}
		
		return null;
	}
	
	
	/*
	 * get floors in a location
     * @param int $locationid
     * @param string|id $key
     */
	private function get_floors ($locationid, $key = 'id') {
		
		//-- reset
		$this->locationFloors = [];
		
		//-- loop through locations
		foreach ($this->locationData AS $location) {
			if ($location['id'] == $locationid) {
				if (is_array($location['floor'])) {	
					foreach ($location['floor'] AS $floor) {
						$this->locationFloors[ $floor[$key] ] = $floor;
					}
				}
			}
		}	
	}
	
	
	/*
	 * get a floor's key
     * @param int $floorid
     * @param string $key
     *
     * @return int $key
     */
	private function get_floor_key ($floorid, $key) {
		
		//-- loop through floors
		foreach ($this->locationData[$key]['floor'] AS $key => $floor) {
			if ($floor['id'] == $floorid) {
				return $key;
			}
		}
	}
	
	
	/*
	 * Validate that the country exists 
     * @param string|null $code
     *
     * @return boolean
     */
	private function country_exists ($code = null) {
		
		//-- check if country code provided
		if ($code) {
		
			//-- get countries payload
			$this->get_countries();
			
			//-- loop through countries
			foreach ($this->countryData AS $country) {
				if (strtolower($country['code']) == strtolower($code)) {
					return true;
				}
			}
		}
		
		//-- error message
		$this->error = "Country does not exist";
		
		//-- bool
		return false;
	}
	
	
	/*
	 * Validate that the Location exists
     * @param int|null $locationid
     *
     * @return boolean
     */
	private function location_exists ($locationid = null) {
		
		//-- check if locationid provided
		if (intval($locationid)) {
		
			//-- get locations payload
			$this->get_locations();
			
			//-- loop through locations
			foreach ($this->locationData AS $location) { 
				if ($location['id'] == $locationid) {
					return true;
				}
			}
			
			//-- error message
			$this->error = "Location id ({$locationid}) does not exist";
		
		} else {
			
			//-- error message
			$this->error = "Location id is required";
		}
				
		
		//-- bool
		return false;
	}
	
	
	/*
	 * Validate that the Floor id exists
     * @param int|null $locationid
     * @param int|null $floorid
     *
     * @return boolean
     */
	private function floor_id_exists ($locationid = null, $floorid = null) {
		if (intval($floorid)) {
			
			//-- get locations payload
			$this->get_locations();
			
			//-- get floors for given location
			$this->get_floors($locationid);
			
					
			//-- check key
			if (isset($this->locationFloors[$floorid])) {
				return true;			
			}
			
			//-- error message
			$this->error = "Floor id ({$floorid}) does not exist";
		} else {
			
			//-- error message
			$this->error = "Floor id is required";
		}
			
		//-- bool
		return false;
	}
	
	
	/*
	 * Validate that the Floor number is not repeated
     * @param int|null $locationid
     * @param int|null $number
     *
     * @return boolean
     */
	private function floor_number_exists ($locationid = null, $number = null) {
		
		//-- get locations payload
		$this->get_locations();
		
		//-- get floors for given location
		$this->get_floors($locationid, 'number');
		
				
		//-- check key
		if (isset($this->locationFloors[$number])) {
			
			//-- error message
			$this->error = "Floor number ({$number}) already exist";
			
			return true;			
		}		
			
		//-- bool
		return false;
	}
	
	
	/*
	 * validate location (post) data
     * @param array $data
     * @param arrayl $fields
     *
     * @return boolean
     */
	private function validate_form_data ($data, $fields) {
		foreach ($fields AS $type => $field) {
			if (empty(trim($data[$field]))) {
				$this->error = "{$field} is required";				
				return false;
			} else if ($type === 'intv' && !intval($data[$field])) {
				$this->error = "{$field} must be an integer value";				
				return false;
			}
		}
		
		//-- valid
		return true;
	}
	
	
	/*
	 * sort array by id
     * @param array $arr
     *
     * @return array
     */
	private function sort_data ($arr) {
		usort($arr, function ($a, $b) {
			return strcmp($a['id'], $b['id']);
		});
		
		//-- response
		return $arr;
	}
	
	
	/*
	 * save location
     */
	private function save_location () {
		//file_put_contents($this->assets . '/' . $this->locfile, json_encode($this->locationData));
		file_put_contents($this->assets . '/' . $this->locfile, json_encode(array_values($this->locationData)));
	}
	
	
	/*
	 * create location
     * @param array|null $options
     *
     * @return bool (false) if error
     */
	public function create_location ($options = null) {
		$options = $options ?? $_POST;
		
		//-- check if country exists
		if (!$this->country_exists($options['country'])) {
			return false;
		}
		
		//-- validate post data
		if (!$this->validate_form_data($options, ['name', 'address'])) {
			return false;
		}
		
		
		//-- get locations payload
		$this->get_locations();
		
		//-- add new Location
		$this->locationData[] = [
			//'id' => trim($options['name']),	//-- BETTER: RDB auto-increment value
			'id' => max(array_column($this->locationData, 'id')) + 1, //-- FOR NOW: add 1 to highest locationid
			'name' => trim($options['name']),
			'address' => trim($options['address']),
			'opening_date' => date('Y-m-d'),
			'country' => $options['country'],
			'floor' => []
		];
		
		//-- save locations
		$this->save_location();
	}
	
	
	/*
	 * edit location
     * @param array|null $options
     *
     * @return bool (false) if error
     */
	public function edit_location ($options = null) {
		$options = $options ?? $_POST;
		
		//-- check if location exists
		if (!$this->location_exists($options['locationid'])) {
			return false;
		}
		
		//-- validate post data
		if (!$this->validate_form_data($options, ['name', 'address', 'country'])) {
			return false;
		}
		
		//-- get array key for given location
		$key = $this->get_location_key($options['locationid']);
		
		//-- update location
		$this->locationData[$key]['name'] = trim($options['name']);
		$this->locationData[$key]['address'] = trim($options['address']);
		$this->locationData[$key]['country'] = trim($options['country']);
		
		
		//-- save locations
		$this->save_location();
	}
	
	
	/*
	 * delete location
     * @param int|null $locationid
     */
	public function delete_location ($locationid = null) {
		
		//-- validate that location exists
		if (!$this->location_exists($locationid)) {
			return false;
		}
		
		//-- get array key for given location
		$key = $this->get_location_key($locationid);
		
		//-- delete
		unset($this->locationData[$key]);
		
		//-- save locations
		$this->save_location();
	}
	
	
	/*
	 * create floor
     * @param array|null $options
     *
     * @return bool (false) if error
     */
	public function create_floor ($options = null) {
		$options = $options ?? $_POST;
		
		//-- check if location exists
		if (!$this->location_exists($options['locationid'])) {
			return false;
		}
		
		//-- get floors
		$this->get_floors($options['locationid']);
		
		//-- validate post data
		if (!$this->validate_form_data($options, ['description', 'intv'=>'number', 'intv'=>'desks'])) {
			return false;
		}
		
		//-- validate that the Floor number is not repeated
		if ($this->floor_number_exists($options['locationid'], $options['number'])) {
			return false;
		}
		
		
		//-- get array key for given location
		$key = $this->get_location_key($options['locationid']);
		
		//-- floor id
		$floorid = empty($this->locationFloors) ? 1 : max(array_column($this->locationFloors, 'id')) + 1;
		
		//-- add floor data
		$this->locationData[$key]['floor'][] = [
			'id' => $floorid,
			'number' => intval($options['number']),
			'description' => trim($options['description']),
			'desks' => intval($options['desks']),
		];
		
		//-- save locations
		$this->save_location();
	}
	
	
	/*
	 * edit floor
     * @param array|null $options
     *
     * @return bool (false) if error
     */
	public function edit_floor ($options = null) {
		$options = $options ?? $_POST;
		
		//-- check if location exists
		if (!$this->location_exists($options['locationid'])) {
			return false;
		}
		
		//-- check if floor exists
		if (!$this->floor_id_exists($options['locationid'], $options['floorid'])) {
			return false;
		}
		
		//-- validate post data
		if (!$this->validate_form_data($options, ['description', 'int'=>'number', 'int'=>'desks'])) {
			return false;
		}
		
		//-- check if new floor number provided
		if ($this->locationFloors[$options['floorid']]['number'] != $options['number']) {
			
			//-- validate that the Floor number is not repeated
			if ($this->floor_number_exists($options['locationid'], $options['number'])) {
				return false;
			}
		}
		
		//-- get array key for given location
		$key = $this->get_location_key($options['locationid']);
		
		//-- get array key for given floorid
		$floorKey = $this->get_floor_key($options['floorid'], $key);
		
		//-- update floor data
		$this->locationData[$key]['floor'][$floorKey]['number'] = intval($options['number']);
		$this->locationData[$key]['floor'][$floorKey]['description'] = trim($options['description']);
		$this->locationData[$key]['floor'][$floorKey]['desks'] = intval($options['desks']);
		
		//-- save locations
		$this->save_location();
	}
	
	
	/*
	 * create floor
     * @param int|null $locationid
     * @param int|null $floorid
     *
     * @return bool (false) if error
     */
	public function delete_floor ($locationid = null, $floorid = null) {
		
		//-- check if location exists
		if (!$this->location_exists($locationid)) {
			return false;
		}
		
		//-- check if floor id exists
		if (!$this->floor_id_exists($locationid, $floorid)) {
			return false;
		}
		
		//-- get array key for given location
		$key = $this->get_location_key($locationid);
		
		//-- get array key for given floorid
		$floorKey = $this->get_floor_key($floorid, $key);
		
		//-- delete floor from location
		unset($this->locationData[$key]['floor'][$floorKey]);
		
		//-- save locations
		$this->save_location();
	}
	
	
	/*
	 * List Locations by Country (paginated)
     * @param string|null $code (country code)
     * @param int|0 $start
     * @param int|25 $max
     *
     * @return bool (false) if error
     */
	public function locations_by_country ($code = null, $start = 0, $max = 25) {
		
		//-- ensure country exists
		if (!$this->country_exists($code)) {
			return false;
		}
		
		//-- get locations payload
		$this->get_locations();
		
		//-- container: locationid => data
		$data = [];
		
		//-- loop through locations
		foreach ($this->locationData AS $location) {
			if (strtolower($location['country']) == strtolower($code)) {
				$data[$location['id']] = $location['name'];
			}
		}
		
		//-- extract locations based on start and max value
		$result = array_slice($data, $start, $max, true);
		
		//-- send back results
		return $result;
	}
	
	
	/*
	 * How many Locations are in a given country?
     * @param string|null $code (country code)
     *
     * @return bool (false) if error
     * @return intval of locations
     */
	public function locations_in_country ($code = null) {
		
		//-- ensure country exists
		if (!$this->country_exists($code)) {
			return false;
		}
		
		//-- number of locations
		$total = 0;
		
		//-- get locations payload
		$this->get_locations();
		
		//-- loop through locations
		foreach ($this->locationData AS $location) {
			if ($location['country'] == $code) {
				$total += 1;
			}
		}
		
		//-- response
		return $total;
	}
	
	
	/*
	 * List of floors in a Location
     * @param int|null $locationid
     *
     * @return bool (false) if error
     * @return array of floors
     */
	 public function floors_by_location ($locationid = null) {
		
		//-- ensure location exists
		if (!$this->location_exists($locationid)) {
			return false;
		}
		
		//-- get locations payload
		$this->get_locations();
		
		//-- floors by location
		$this->get_floors($locationid);
		
		//-- response
		return $this->locationFloors;
	 }
	
	
	/*
	 * How many Floors are in a given Location?
     * @param int|null $locationid
     *
     * @return bool (false) if error
     */
	public function floors_in_location ($locationid = null) {
		
		//-- ensure location exists
		if (!$this->location_exists($locationid)) {
			return false;
		}
		
		//-- get locations payload
		$this->get_locations();
		
		//-- loop through locations
		foreach ($this->locationData AS $location) {
			if ($location['id'] == $locationid) {
				return count($location['floor']);
			}
		}
		
		//-- response
		return 0;
	}
	
	
	/*
	 * How many Desks are in a given Location?
     * @param int|null $locationid
     *
     * @return bool (false) if error
     * @return int value of floot count
     */
	public function desks_in_location ($locationid = null) {
		
		//-- ensure location exists
		if (!$this->location_exists($locationid)) {
			return false;
		}
		
		//-- number of desks
		$total = 0;
		
		//-- get locations payload
		$this->get_locations();
		
		//-- loop through locations
		foreach ($this->locationData AS $location) {
			if ($location['id'] == $locationid) {
				foreach ($location['floor'] AS $floor) {
					$total += intval($floor['desks']);
				}
			}
		}
		
		//-- response
		return $total;
	}
	
	
	/*
	 * First location that opened in a given Country
     * @param string|null $code (country code)
     *
     * @return bool (false) if error
     * @return array of locations
     */
	public function first_location_in_country ($code = null) {
		
		//-- ensure country exists
		if (!$this->country_exists($code)) {
			return false;
		}
		
		//-- get locations payload
		$this->get_locations();
		
		//-- container: data => data
		$data = [];
		
		//-- loop through locations
		foreach ($this->locationData AS $location) {
			if (strtolower($location['country']) == strtolower($code)) {
				$data[ $location['opening_date'] ] = $location;
			}
		}
		
		//-- sort locations by date... ascending
		ksort($data);
		
		//-- return first location data
		return reset($data);
	}
	
	
	/*
	 * Which locations are opening next month?
     * @return array of locations
     */
	public function locations_opening_next_month () {
		
		//-- get locations payload
		$this->get_locations();
		
		//-- container: data => data
		$data = [];
		
		
		
		//-- current date... next month timestamp
		$next = date('Y-m', strtotime('+1 month'));
		
		//-- loop through locations
		foreach ($this->locationData AS $location) {
			
			//-- opening date... convert to array
			$opening = explode("-", $location['opening_date']);
			
			//-- opening date... next month
			$opening = "{$opening[0]}-{$opening[1]}";
			
			//-- compare timestamps... current vs opening			
			if ($next == $opening) {
				$data[] = $location;
			}
		}
		
		//-- return array of locations
		return $data;
	}
	
	
	/*
	 * helpers: get all countries
     * @return array of countries
     */
	public function countries () {
		$data = [];
		$this->get_countries();
		
		foreach ($this->countryData AS $info) {
			$data[$info['code']] = $info['name'];
		}
		
		return $data;
	}
	
	
	/*
	 * helpers: get location details
     * @return array of details
     */
	public function location_details ($locationid = null) {
		if ($this->location_exists($locationid)) {
			$key = $this->get_location_key($locationid);
			return $this->locationData[$key];
		} else {
			return false;
		}
	}
	
	
	/*
	 * helpers: list floors
     * @return array
     */
	public function floors_list ($locationid = null) {
        $data = false;

		if ($this->location_exists($locationid)) {
            $this->get_floors($locationid);
			foreach ($this->locationFloors AS $id => $info) {
                $data[$id] = $info['description'];
            }
		}
        
        return $data;
	}
	
	
	/*
	 * helpers: floor details
     * @return array
     */
	public function floor_details ($locationid = null, $floorid = null) {
        $data = false;
		
		
		if ($this->location_exists($locationid) && $this->floor_id_exists($locationid, $floorid)) {
			$key = $this->get_location_key($locationid);
			$floorKey = $this->get_floor_key($floorid, $key);
			$data = $this->locationData[$key]['floor'][$floorKey];
		}
        
        return $data;
	}
}

?>