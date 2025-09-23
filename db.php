<?php


class Db
{

    public static function debug($d){

        echo "<pre>";
        var_dump($d);
        echo "</pre><hr>";


    }

    public static function connect()
    {

        $host = "localhost";
        $user = "test";
        $password = "1234";
        $db = "crud2025";

        $con = new mysqli($host, $user, $password, $db);

        if ($con->connect_error) {
            return $con->connect_error;
        }

        return $con;
    }

    public static function getCars(){

        $query = "SELECT * FROM cars";

        $con = self::connect();

        $result = $con->query($query);

        $data = [];
        while($row = $result->fetch_assoc()){
            $data[] = $row;
        }

        $con->close();

        return $data;

    }
}
