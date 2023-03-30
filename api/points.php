<?php

require_once "functions.php";

// Get the post request and put the objekt in $data
$data = json_decode(file_get_contents("php://input"), true);

$filename = "users.json";
$users = json_decode(file_get_contents($filename), true);

if(isset( $data["username"],  $data["password"],  $data["points"])){
    $username = $data["username"];
    $password = $data["password"];
    $newPoint = $data["points"];

    foreach($users as $index => $user){
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

// We take a pice from $users with the splice function leaving us with an array woth the first five user.
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