<?php

require("template.php");

$data = [
    "name" => "Sven",
    "age" => 32,
    "grades" => [3, 5, 5]
];

Render::view("welcome", $data);
 