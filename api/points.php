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
// else {
//     $message = ["message" => "You are missing a key/keys in your request! Check API doc for more info"];
//     sendJson($message, 400);
// }
// Higscore
usort($users, function ($a, $b) {
    return $b["points"] - $a["points"];
});

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