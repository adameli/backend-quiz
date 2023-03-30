<?php
    function sendJson ($data, $statuscode){
        header("Content-type: application/json");
        http_response_code($statuscode);
        $json = json_encode($data);
        echo $json;
        exit();
    }

    function checkContentType ($contentType) {
        if ($contentType != "application/json"){
            $message = ["message" => "This content-type '$contentType' is not allowad it must be 'application/json'"];
            sendJson($message, 415);
        }
    }

    function checkRequestMethod ($requestMethod, $rightMethod){
        if($requestMethod != $rightMethod){
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