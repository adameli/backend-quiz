<?php

require_once "functions.php";

// Get the post request and put the objekt in $data
$data = json_decode(file_get_contents("php://input"), true);
$username = $data["username"];
$password = $data["password"];
$newPoint = $data["points"];

$filename = "users.json";
$users = json_decode(file_get_contents($filename), true);

foreach($users as $index => $user){
    if($user["username"] == $username && $user["password"] == $password){
        // $user["points"] = $user["points"] + $newPoint;
        $users[$index]["points"] = $users[$index]["points"] + $newPoint;
        // $users[] = $user["points"];
        $resource = ["points" => $user["points"] + $newPoint];
        $json = json_encode($users, JSON_PRETTY_PRINT);
        file_put_contents($filename, $json);
        sendJson($resource, 200);
    }
}

?>