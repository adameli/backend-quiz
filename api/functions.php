<?php
    function sendJson ($data, $statuscode){
        header("Content-type: application/json");
        http_response_code($statuscode);
        $json = json_encode($data);
        echo $json;
        exit();
    }

    function checkRequestMethod ($requestMethod){
        if($requestMethod != "POST"){
            $message = ["message" => "This Request Method $requestMethod is not allowd"];
            sendJson($message, 400);
        }
    }

    function checkCorrectDog ($correctDog, $controllDog) {
        if ($correctDog == $controllDog){
            return true;
        }else {
            return false;
        }
    }
?>