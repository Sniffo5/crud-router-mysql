<?php
session_start(['cookie_httponly'=>true]);

require("template.php");
require("routerClass.php");
require("db.php");
require("response.php");

/* app::get("/", function(){
    Render::view("welcome", ["name" => "Sven","age" => 32,"grades" => [3, 5, 5]]);
});

app::get('/quotes/$title/$comment', function($title, $comment){
    Render::view("quote", ["title" => $title, "comment" => $comment]);
}); */

app::get("/cars", function () {

    if (isset($_GET['s'])) {
        Response::json(db::search_car($_GET['s']));
        return;
    }

    Response::json(db::getCars());
});

app::get('/cars/$id', function ($id) {

    $id = intval($id);
    Response::json(db::get_car($id));
});

app::post("/cars", function () {

    if(empty($_SESSION['auth']) || !$_SESSION['auth']){
        return Response::json(["error" => "not logged in"]);
    };

    if (count($_POST) == 0) {
        $data = (array) json_decode(file_get_contents("php://input")); // could also add true as a second paramater in json_decode to convert the object to an array

        response::json(Db::insert_cars($data));
    } else {
        response::json(Db::insert_cars($_POST));
    }
});

app::put('/cars/$id', function ($id) {

    Response::json(Db::update_car($id, json_decode(file_get_contents("php://input"), true)));
});

app::delete('/cars/$id', function ($id) {

    $id = intval($id);
    Response::json(db::delete_car($id));
});


app::post("/register", function () {

    $user = $_POST;

    // Validera först egentligen.

    response::json(db::register($user));
});

app::post("/login", function () {
    $user = $_POST;
    response::json(db::login($user));
});

app::get("/session", function () {

    Response::debug($_SESSION);

});
