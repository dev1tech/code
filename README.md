# code
-- php code challenge --

$class = new Location();

-- create location\
$response = $class->create_location(['name'=>'charles', 'address'=>'bay area', 'country'=>'US']);

-- edit location\
$class->edit_location(['locationid'=>11, 'name'=>'charles A', 'address'=>'bay area', 'country'=>'US']);

-- delete location\
$response = $class->delete_location(13);

-- create floor\
$response = $class->create_floor(['locationid'=>4, 'number'=>3, 'desks'=>44, 'description'=>'Floor 3']);

-- edit floor\
$response = $class->edit_floor(['locationid'=>1, 'floorid'=>12, 'number'=>2, 'desks'=>54, 'description'=>'Floor 2 edited...']);

-- delete floor\
$response = $class->delete_floor(4, 3);

-- location details\
$response = $class->location_details(43);

-- List Locations by Country (paginated);\
$response = $class->locations_by_country('SS', 0, 5);

-- How many Locations are in a given country\
$response = $class->locations_in_country('SS');

-- How many Floors are in a given Location\
$response = $class->floors_in_location(1);

-- List of floors in a Location\
$response = $class->floor_details(43, 431);

-- How many Desks are in a given Location\
$response = $class->desks_in_location(1);

-- First location that opened in a given Country\
$response = $class->first_location_in_country('NR');

-- Which locations are opening next month\
$response = $class->locations_opening_next_month();

-- error message\
$error = $class->error;
