<?php

class Db
{

    private static function connect()
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

    public static function get_car(int $id)
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

    public static function insert_cars($data)
    {

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

    public static function update_car($id, $data)
    {

        $old_data = self::get_car($id);
        extract($old_data);

        $new_data = [];
        $new_data["brand"]  = $data["brand"] ?? $brand;
        $new_data["model"]  = $data["model"] ?? $model;
        $new_data["price"]  = $data["price"] ?? $price;
        $new_data["img"]    = $data["img"] ?? $img;
        extract($new_data);


        $query = "UPDATE cars SET model = ?, brand = ?, price = ?, img = ? WHERE id = ?";

        $con = self::connect();

        $stmt = $con->prepare($query);
        $stmt->bind_param("ssisi", $brand, $model, $price, $img, $id);

        $stmt->execute();

        $con->close();

        return $id;
    }

    public static function update_car2($id, $data)
    {

        if (!isset($data["brand"]) && !isset($data["model"]) && !isset($data["price"]) && !isset($data["img"])) {
            return;
        }

        $query = "UPDATE cars SET";
        $param_types = "";
        $param_amount = 0;

        if (isset($data["brand"])) {
            if ($param_amount == 0) {
                $query .= " brand = ?";
                $param_amount++;
            } else {
                $query .= " ,brand = ?";
            }
            $param_types .= "s";
        }
        if (isset($data["model"])) {
            if ($param_amount == 0) {
                $query .= " model = ?";
                $param_amount++;
            } else {
                $query .= " ,model = ?";
            }
            $param_types .= "s";
        }
        if (isset($data["price"])) {
            if ($param_amount == 0) {
                $query .= " price = ?";
                $param_amount++;
            } else {
                $query .= " ,price = ?";
            }
            $param_types .= "i";
        }
        if (isset($data["img"])) {
            if ($param_amount == 0) {
                $query .= " img = ?";
                $param_amount++;
            } else {
                $query .= " ,img = ?";
            }

            $param_types .= "s";
        }

        $param_types .= "i";
        $query .= " WHERE id = ?";

        $con = self::connect();
        $stmt = $con->prepare($query);

        extract($data);

        $stmt->bind_param($param_types, [...array_values($data), $id]);

        $stmt->execute();

        $con->close();

        return $id;
    }

    public static function delete_car($id)
    {
        if ($id) {
            $query = "DELETE FROM cars WHERE id= ?";

            $con = self::connect();

            $stmt = $con->prepare($query);
            $stmt->bind_param("i", $id);

            $stmt->execute();

            $con->close();

            return  self::getCars();
        }
    }

    public static function search_car($search)
    {


        $query = "SELECT * FROM cars WHERE brand LIKE ? OR model LIKE ?";

        $con = self::connect();

        $stmt = $con->prepare($query);
        $search_query = "$search%";
        $stmt->bind_param("ss", $search_query, $search_query);

        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $con->close();

        return $data;
    }
}
