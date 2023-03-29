<?php

require_once "functions.php";

// With scandir we create an array whit the files in images (the dogs)
// But beacuse scandir creates tow files that are '.' and '..' we remove them whit array_diff
// Array_diff compares array against one or more other arrays and returns the values in array that are not present in any of the other arrays. 
$images = scandir("../images", SCANDIR_SORT_DESCENDING);
$removeFiles = ['.','..'];
$files = array_diff($images, $removeFiles);

// We shuffle the $files array so the first four dogs is not in alphabetical order, this makes it so the dogs are somwhat random
shuffle($files);
$dogsArray = array_slice($files, 0, 4);

// Then we select a random dog from $dogsArray that will become the correct dog in the quiz
$randomNumber =  rand($min = 0, $max = count($dogsArray) - 1);
$correctDog = $dogsArray[$randomNumber];

// echo "<p>the showsen dog is $correctDog</p>";

// We go trough every dog in $dogsArray and get the true or false value by the checkCorrectDog function
// Then we change the dogs file name to a more cleaner string without the "_" and ".jpg"
// We create objekts that we will store in the $alternatives array
$alternativs = [];
foreach($dogsArray as $dog){
    $correct = checkCorrectDog($correctDog, $dog);
    // echo "<p>$dog is $correct</p>";
    $trimmed = str_replace(".jpg", "", $dog);
    $newtrimmed = str_replace("_", " ", $trimmed);
    // echo $newtrimmed;
    $objekt = ["correct" => $correct, "name" => $newtrimmed];
    $alternativs[] = $objekt;
}

// echo "<pre>";
// var_dump($alternativs);
// echo "</pre>";

// This is the data we will send back to as a response to the webb
$responseObjekt = [
    "image" => "images/$correctDog",
    "alternatives" => $alternativs,
];

sendJson($responseObjekt, 200);

// echo "<pre>";
// var_dump($responseObjekt);
// echo "</pre>";

// echo "<pre>";
// var_dump($files);
// echo "</pre>";

?>