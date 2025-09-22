<?php

class Render{
    
    public static function view($view, $data){

        extract($data);

        $viewFile = file_get_contents("views/" . $view . ".view");

        $viewFile = trim($viewFile);

        $viewFile = str_replace("{{", "<?= htmlspecialchars(", $viewFile);
        $viewFile = str_replace("}}", ") ?>", $viewFile);

        $viewFile = str_replace("{", "<?php ", $viewFile);
        $viewFile = str_replace("}", "?> ", $viewFile);

        file_put_contents("cache/$view.php", $viewFile);

        include("cache/$view.php");

    }

}