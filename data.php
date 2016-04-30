<?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Content-type: application/json");

$host="localhost";
$username="root";
$password="";
$database="test";

$con=mysqli_connect($host,$username,$password,$database);

$arr=array();

$profession = "";
if (isset($_GET['profession'])) {
    $profession = " AND description = '" . mysqli_real_escape_string($con, $_GET['profession']) . "' ";
}

$result=mysqli_query($con,"SELECT * FROM people WHERE name LIKE '%".mysqli_real_escape_string($con,$_GET['chars'])."%' " . $profession . " ORDER BY name LIMIT 0, 10");
if(mysqli_num_rows($result)>0){
    while($data=mysqli_fetch_row($result)){
        // Store data in array 
        // You can add any additional fields to be used by the autosuggest callback function 
        $arr[]=array(
            "id" => $data[0],
            "data" => $data[1],
            "thumbnail" => 'thumbnails/'.$data[3],
            "description" => $data[2],
            // Additional fields (if any)...
        );
    }
}

mysqli_close($con);

// Encode it with JSON format
echo json_encode($arr);
