<?php

require("routerClass.php");

app::get("/", function(){

    echo "Hello World!";

});


app::get("/quotes",function(){
    app::out("quotes");
});

/* app::get('/cars/$id', function($id){

    app::out("car with id $id");

}); */

app::get('/cars/$id', "views/car");

 app::delete('/cars/$id', function($id){
    
    app::out("Delete Car with id $id");

}); 