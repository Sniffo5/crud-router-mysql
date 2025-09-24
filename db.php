<?php


class Db
{

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

    public static function getCars()
    {

        $query = "SELECT * FROM cars";

        $con = self::connect();

        $result = $con->query($query);

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $con->close();

        return $data;
    }

    public static function getCar(int $id)
    {

        $query = "SELECT * FROM cars WHERE id= ?";

        $con = self::connect();

        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $id);

        $stmt->execute();
        $result = $stmt->get_result();
        // $rows = $result->num_rows;      <--- hämtar antal resultat
        $data = $result->fetch_assoc();

        /*   
            $result->free(); ifall vi vill återamvända samma connection och köra med olika params flera gånger så kör du free mellan.
            $stmt->close(); 
        */

        $con->close();

        return $data;
    }

    public static function insert_cars($data){

        extract($data);

        $query = "INSERT INTO cars VALUES(NULL, ?, ?, ?, ?)";

        $con = self::connect();

        $stmt = $con->prepare($query);
        $stmt->bind_param("ssis", $brand, $model, $price, $img);

        $stmt->execute();

         $id = $stmt->insert_id;

        $con->close();

        return $id;
    }
}
