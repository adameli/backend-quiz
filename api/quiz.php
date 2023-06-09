<?php
ini_set("display_errors", 1);
require_once "functions.php";

// Controlls so that we only allow the request-method: "GET"
$requestMethod = $_SERVER["REQUEST_METHOD"];
checkRequestMethod($requestMethod, "GET");

// if the file/folder with the images have been removed or somehow are gone we will let the user know of it 
if(!file_exists("../images")){
    $message = ["message" => "We are having problems by providing images at the moment! Pls try agin later"];
    sendJson($message, 404);
} 

// With scandir we create an array with the files in images (the dogs)
// But beacuse scandir creates two files that are '.' and '..' we remove them with array_diff
// Array_diff compares array against one or more other arrays and returns the values in array that are not present in any of the other arrays. 
$images = scandir("../images", SCANDIR_SORT_DESCENDING);
$removeFiles = ['.','..'];
// We use the array_diff to remove the files "." & ".."
$files = array_diff($images, $removeFiles);

// We shuffle the $files array so the first four dogs is not in alphabetical order, this makes it so the dogs are somewhat random
shuffle($files);
$dogsArray = array_slice($files, 0, 4);

// Then we select a random dog from $dogsArray that will become the correct dog in the quiz
$randomNumber =  rand($min = 0, $max = count($dogsArray) - 1);
$correctDog = $dogsArray[$randomNumber];

// We go trough every dog in $dogsArray and get the true or false value by the checkCorrectDog function
// Then we change the dogs file name to a more cleaner string without the "_" and ".jpg"
// We create objekts that we will store in the $alternatives array
$alternativs = [];
foreach($dogsArray as $dog){
    $correct = checkCorrectDog($correctDog, $dog);
    $firsttrim = str_replace(".jpg", "", $dog);
    $secondtrim = str_replace("_", " ", $firsttrim);
    $objekt = ["correct" => $correct, "name" => $secondtrim];
    $alternativs[] = $objekt;
}

// This is the data we will send back to as a response to the webb
$responseObjekt = [
    "image" => "images/$correctDog",
    "alternatives" => $alternativs,
];

sendJson($responseObjekt, 200);
?>