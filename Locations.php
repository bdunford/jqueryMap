<?php

class Location {
   public $id;
   public $name;
   public $address;
   public $city;
   public $state;
   public $zip; 
   public $phone; 
   public $lat;
   public $lng;
}




$nelat = $_GET['nelat'];
$nelng = $_GET['nelng'];
$swlat = $_GET['swlat'];
$swlng = $_GET['swlng'];


$username = "root";
$password = "root";
$con_string = "mysql:host=localhost;dbname=test";

$con = new PDO($con_string,$username, $password);

$response = array();


    $params = array(':nelat' => $nelat, ':swlat' => $swlat, ':nelng' => $nelng, ':swlng' => $swlng);
    $results = $con->prepare("SELECT id
                                    ,Contact_name as name
                                    ,Address_1 as address
                                    ,City as city 
                                    ,State as state
                                    ,Postal_Code as zip
                                    ,Phone_Number as phone
                                    ,Latitude as lat
                                    ,Longitude as lng
                              FROM stores 
                             WHERE Latitude  < :nelat
                               AND Latitude  > :swlat 
                               AND Longitude < :nelng
                               AND Longitude > :swlng"); 
    $results->execute($params);
    $results->setFetchMode(PDO::FETCH_CLASS, 'Location');
    

    while ($loc = $results->fetch()) {
        $response[] = $loc;
    }

    header('Content-type: application/json');
    exit(json_encode($response));

?>
