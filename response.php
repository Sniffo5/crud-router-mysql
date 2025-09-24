<?php

class Response
{

    public static function debug($d)
    {
        echo "<pre>";
        var_dump($d);
        echo "</pre><hr>";
    }

    public static function json($data) {

        header("Content-Type:application/json");
        echo json_encode($data, JSON_PRETTY_PRINT);
        

    }
}
