<?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Content-type: application/json");

$host="localhost";
$username="root";
$password="";
$database="test";

$db = new PDO("mysql:host=$host;dbname=$database" , $username , $password);

$arr = array();

$where = array();
$where[':name'] = '%' . $_GET['chars'] . '%';

$profession = "";
if (isset($_GET['profession'])) {
    $profession = " AND description = :description ";
    $where[':description'] = $_GET['profession'];
}

$sql = "SELECT * FROM people WHERE name LIKE :name " . $profession . " ORDER BY name LIMIT 0, 10";

$query = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
$query->execute($where);

$result = $query->fetchAll();
if ($query->rowCount() > 0) {
    foreach ($result as $data) {
        // Store data in array 
        // You can add any additional fields to be used by the autosuggest callback function 
        $arr[]=array(
            "id" => $data['id'],
            "data" => $data['name'],
            "thumbnail" => 'thumbnails/'.$data['photo'],
            "description" => $data['description'],
            // Additional fields (if any)...
        );
    }
}

// Close connection.
$db = null;

// Encode it with JSON format
echo json_encode($arr);
