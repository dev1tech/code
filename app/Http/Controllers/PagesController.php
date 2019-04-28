<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helpers\RedTech;

class PagesController extends Controller {

    //-- landing page
    public function index () {
        $data = [
            'title' => 'Welcome - A presentation by Charles A',
            'data' => ['us'=>'United States', 'ca'=>'Canada']
        ];

        return view('pages.index')->with($data);
    }


    //-- countries page
    public function countries ($code = null) {
        $params = [];

        //-- instantiate class
        $redTech = new RedTech();

        //-- error message, if any
        $params['message'] = $redTech->error ?? "Data not available for selected country";

        //-- locations by country (code)
        if ($code) {
            $params['title'] = "Select Location";
            $params['page'] = "locations";
            $params['data'] = $redTech->locations_by_country($code);
        } else {
            $params['title'] = "Select Country";
            $params['page'] = "countries";
            $params['data'] = $redTech->countries();
        }

        //-- view
        return view('pages.countries')->with($params);
    }


    //-- locations page
    public function locations ($locationid = null, $floors = null, $floorid = null) {
        $params = [
            'title' => 'Select Location',
            'locationid' => $locationid,
            'floors' => $floors,
            'floorid' => $floorid,
            //'data' => ['One', 'Two', 'Three']
        ];

        //-- data
        $params = $this->location_data($params);

        //-- view
        return view('pages.locations')->with($params);
    }


    //-- data
    private function location_data ($params) {
        //-- instantiate class
        $redTech = new RedTech();

        //-- logic
        if ($params['floorid']) {
            $params['title'] = "Floor Details";
            $params['info'] = $redTech->floor_details($params['locationid'], $params['floorid']);
        } else if ($params['floors']) {
            $params['title'] = "Select a Floor";
            $params['list'] = $redTech->floors_list($params['locationid']);
        } else if ($params['locationid']) {
            $params['title'] = "Location Details";
            $params['details'] = $redTech->location_details($params['locationid']);
        } else {
            $params['message'] = "--- Additional Information ---";
        }

        //-- error message, if any
        $params['message'] = $params['message'] ?? $redTech->error;

        return $params;
    }
}
