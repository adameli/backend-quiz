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