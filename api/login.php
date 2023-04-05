<?php
ini_set("display_errors", 1);
require_once "functions.php";

// Controlls so that we only allow the content-type: application/json
$contentType = $_SERVER["CONTENT_TYPE"];
checkContentType($contentType);

// Controlls so that we only allow the request-method: "POST"
$requestMethod = $_SERVER["REQUEST_METHOD"];
checkRequestMethod($requestMethod, "POST");

$filename = "users.json";
// Get the post request and put the objekt in $data
$data = json_decode(file_get_contents("php://input"), true);
$username = $data["username"];
$password = $data["password"];

// We use method empty() to controll if the values that we receive from the request are empty. 
// empty() = returns true if varible does not exist or has a value that is empty or equal to zero
if(empty($username) or empty($password)){
    $message = ["message" => "Bad Request (empty values)"];
    sendJson($message, 400);
}


// We controll the username and password we got from the post request, if their is a registerd user in the json file. 
// If "true" we send back the user that cheks out.
$users = json_decode(file_get_contents($filename), true);
foreach($users as $user){
    if($user["username"] == $username && $user["password"] == $password){
        sendJson($user, 200);
    }
}

$message = ["message" => "Not Found"];
sendJson($message, 404);
?>