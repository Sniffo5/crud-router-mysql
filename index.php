<?php

require("template.php");
require("routerClass.php");
require("db.php");

/* app::get("/", function(){
    Render::view("welcome", ["name" => "Sven","age" => 32,"grades" => [3, 5, 5]]);
});

app::get('/quotes/$title/$comment', function($title, $comment){
    Render::view("quote", ["title" => $title, "comment" => $comment]);
}); */

app::get("/cars", function(){

    db::debug(db::getCars());



});
