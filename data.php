<?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Content-type: application/json");

$host="localhost";
$username="root";
$password="123xyz";
$database="lab";

$con=mysql_connect($host,$username,$password) or die(mysql_error());
mysql_select_db($database,$con) or die(mysql_error());

$arr=array();
$result=mysql_query("SELECT * FROM people WHERE name LIKE '%".mysql_real_escape_string($_GET['chars'])."%' ORDER BY name LIMIT 0, 10",$con) or die(mysql_error());
if(mysql_num_rows($result)>0){
    while($data=mysql_fetch_row($result)){
        // Store data in array
        $arr[]=array("id" => $data[0], "data" => $data[1], "thumbnail" => 'thumbnails/'.$data[3], "description" => $data[2]);
    }
}

mysql_close($con);

// Encode it with JSON format
echo json_encode($arr);
