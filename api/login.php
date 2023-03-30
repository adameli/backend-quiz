<?php
ini_set("display_errors", 1);
require_once "functions.php";

// $requestMethod = $_SERVER["REQUEST_METHOD"];
// if($requestMethod != "POST"){
//     $message = ["message" => "This Request Method $requestMethod is not allowd"];
//     sendJson($message, 400);
// }


$filename = "users.json";
$data = json_decode(file_get_contents("php://input"), true);
$username = $data["username"];
$password = $data["password"];

// We use method empty() to controll if the values that we receive from the request are empty. 
// empty() = returns true if varible does not exist or has a value that is empty or equal to zero
if(empty($username) or empty($password)){
    $message = ["message" => "Bad Request (empty values)"];
    sendJson($message, 400);
}



$users = json_decode(file_get_contents($filename), true);
foreach($users as $user){
    if($user["username"] == $username && $user["password"] == $password){
        sendJson($user, 200);
    }
}

$message = ["message" => "Not Found"];
sendJson($message, 404);

?>