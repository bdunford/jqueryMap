<?php

class Location {
   public $id;
   public $address;
}



$id = $_GET['id'];
$lat = $_GET['lat'];
$lng = $_GET['lng'];

$username = "root";
$password = "root";
$con_string = "mysql:host=localhost;dbname=test";

$con = new PDO($con_string,$username, $password);

$response;

if (!empty($id)) {
    $params = array(':id' => $id, ':lat' => $lat, ':lng' => $lng);
    $exe = $con->prepare("UPDATE stores SET Latitude = :lat, Longitude = :lng WHERE id = :id"); 
    $response = $exe->execute($params);
    
} else {
    $response = array();
    $query = "SELECT id, CONCAT(Address_1,' ', City, ', ', State,' ', postal_code) as address FROM stores where Latitude = '' LIMIT 10";
    $results = $con->query($query);
    $results->setFetchMode(PDO::FETCH_CLASS, 'Location');
    
    while ($loc = $results->fetch()) {
        $response[] = $loc;
    }
}
    header('Content-type: application/json');
    exit(json_encode($response));

?>
