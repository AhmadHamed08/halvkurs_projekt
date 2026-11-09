<?php
require_once("router.php");
require_once("response.php");

App::get("/", "views/home");


App::get("/register", "views/register");

App::post("/register", function(){
    if (empty($_POST['email']) || empty($_POST['password'])){
        Res::redirect_error("/register", "Fyll i formulär");
        return;
    }

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        Res::redirect_error("/register", "Epost-fel");
        return;
    }
    if (strlen($_POST['password']) < 4) {
        Res::redirect_error("/register", "Minst 4 tecken på lösenord");
        return;
    }
}); 