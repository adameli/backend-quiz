<?php
ini_set("display_errors", 1);

$data = json_decode(file_get_contents("php://input"), true);
$username = $data["username"];
$password = $data["password"];

header("Content-type: application/json");
$json = json_encode(["message" => "we have your $username and $password"]);
echo $json;
exit();
?>