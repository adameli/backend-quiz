<?php
ini_set("display_errors", 1);
require_once "functions.php";

$requestMethod = $_SERVER["REQUEST_METHOD"];

// Get the post request and put the objekt in $data
$data = json_decode(file_get_contents("php://input"), true);

$filename = "users.json";
$users = json_decode(file_get_contents($filename), true);

if($requestMethod == "POST"){
    $contentType = $_SERVER["CONTENT_TYPE"];
    checkContentType($contentType);

    if(!isset( $data["username"],  $data["password"],  $data["points"])){
        $message = ["points" => "Bad Request, You are missing one or more key in your request "];
        sendJson($message, 400);
    }
    $username = $data["username"];
    $password = $data["password"];
    $newPoint = $data["points"];

    foreach($users as $index => $user){
        // Here we find the wright user that is logged in, to incres it's points
        if($user["username"] == $username && $user["password"] == $password){
            $users[$index]["points"] = $users[$index]["points"] + $newPoint;
            $resource = ["points" => $user["points"] + $newPoint];
            $json = json_encode($users, JSON_PRETTY_PRINT);
            file_put_contents($filename, $json);
            sendJson($resource, 200);
        }
    }
}

// Highscore
// Here we sort the $users array by the users points from highest to lowest.
usort($users, function ($a, $b) {
    return $b["points"] - $a["points"];
});

// We take a pice from $users with the splice function leaving us with an array with the first five user.
// We then loop throuh the first five and create a new array with the essential information.
$firstFiveOfUsers = array_slice($users, 0, 5);
$topFive = [];
foreach($firstFiveOfUsers as $user) {
    $username = $user["username"];
    $points = $user["points"];
    $resource = ["username" => $username, "points" => $points];
    $topFive[] = $resource;
}

sendJson($topFive, 200);


?>