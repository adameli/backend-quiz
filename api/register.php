<?php
ini_set("display_errors", 1);
require_once "functions.php";

// Controlls so that we only allow the content-type: application/json
$contentType = $_SERVER["CONTENT_TYPE"];
checkContentType($contentType);

$filename = "users.json";

// Get the post request and put the objekt in $data
$data = json_decode(file_get_contents("php://input"), true);
$username = $data["username"];
$password = $data["password"];

// If the password have less then 4 characters you can't register (for safty features of course)
if(strlen($password) < 4){
    $message = ["message" => "Password must consist of 4 or more characters"];
    sendJson($message, 400);
}

// Creates new user with the input values
$newuser = [
    "username" => $username,
    "password" => $password,
    "points" => 0,
];

// Controlls if the file "users.json" exists, if false we put the newuser in a json file and send the newuser back to the webb
if(!file_exists($filename)){
    $json = json_encode([$newuser], JSON_PRETTY_PRINT);
    file_put_contents($filename, $json);
    sendJson($newuser, 201);
}else {
    $users = json_decode(file_get_contents($filename), true);
}

// Controlls if there is already a user with the same username as the requested newuser
// This will stop users from creating acounts with an already existing username
foreach($users as $user){
    if($user["username"] == $username){
        $message = ["message" => "Conflict (the username is already taken)"];
        sendJson($message, 409);
    }
}

// If all goes well and the controlls are checked we put the new users in our file and send back the newusers values
$users[] = $newuser;
$jsonUsers = json_encode($users, JSON_PRETTY_PRINT);
file_put_contents($filename, $jsonUsers);
sendJson($newuser, 201);
?>