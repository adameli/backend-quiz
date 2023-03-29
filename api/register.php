<?php
ini_set("display_errors", 1);
require_once "functions.php";
//* http code 201, save user in a json file, return a objekt with username & password & points.
$filename = "users.json";
$data = json_decode(file_get_contents("php://input"), true);
$username = $data["username"];
$password = $data["password"];

$newuser = [
    "username" => $username,
    "password" => $password,
    "points" => 0,
];

if(!file_exists($filename)){
    $testUser = ["username" => "test", "password" => "test"];
    $json = json_encode($testUser, JSON_PRETTY_PRINT);
    file_put_contents($filename, $json);
}

$users = json_decode(file_get_contents($filename), true);
foreach($users as $user){
    if($user["username"] == $username){
        $message = ["message" => "Conflict (the username is already taken)"];
        sendJson($message, 409);
    }
}

json_encode($newuser, JSON_PRETTY_PRINT);
file_put_contents($filename, $newuser);
sendJson($newuser, 201);
?>