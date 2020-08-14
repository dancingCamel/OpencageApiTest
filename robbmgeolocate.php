<?php

	ini_set('display_errors', 'On');
	error_reporting(E_ALL);

	include('openCage/AbstractGeocoder.php');
    include('openCage/Geocoder.php');
  
    
    $apiKey = '5d3b9ac806534c019274987a54d31cfd';
    $geocoder = new \OpenCage\Geocoder\Geocoder($apiKey);

    $result = $geocoder->geocode($_REQUEST['q'],['language'=>$_REQUEST['lang']]);

    $searchResult = [];
	$searchResult['results'] = [];

    $temp = [];

    foreach ($result['results'] as $entry) {

        $temp['geometry']['lat'] = $entry['geometry']['lat'];
        $temp['geometry']['lng'] = $entry['geometry']['lng'];
        $temp['address'] = $entry['formatted'];
        $temp['countryCode'] = strtoupper($entry['components']['country_code']);
        $temp['timezone'] = $entry['annotations']['timezone']['name'];
        $temp['sunrise'] = date('r',$entry['annotations']['sun']['rise']['apparent']);
        $temp['sunset'] = date('r',$entry['annotations']['sun']['set']['apparent']);
        $temp['emergency'] = $entry['annotations']['what3words']['words'];

        array_push($searchResult['results'], $temp);

    }

    header('Content-Type: application/json; charset=UTF-8');
	
	echo json_encode($searchResult, JSON_UNESCAPED_UNICODE);
?>