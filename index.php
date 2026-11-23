<?php

session_start([
    'cookie_httponly' => true,
]);

require_once("router.php");
require_once("response.php");
require_once("postsModel.php");

App::get("/", "views/home");
App::get("/register", "views/register");
App::get("/login", "views/login");
App::get("/posts/create", "views/createPost");

App::get("/session", function(){
    Res::debug($_SESSION);
});

App::get("/logout", function(){
    session_destroy();
    Res::redirect("/", "LOGGED OUT");
});

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

    $users = json_decode(file_get_contents("users.json"), true);
    $email = $_POST['email'];
    $password = $_POST['password'];

    $userFinns = array_find($users, function ($user) use($email) {
        return $user['email'] == $email;
    });

    if($userFinns == True){
        Res::redirect_error("/register", "Användare finns redan");
        return;
    }

    $id = uniqid(true);
    $users[] = [
        "email" => $email,
        "password" => password_hash($password, PASSWORD_DEFAULT),
        "id" => $id
    ];

    file_put_contents("users.json", json_encode($users, JSON_PRETTY_PRINT));
    Res::redirect("/register", "Register lyckades");
});

App::post("/login", function(){

    $users = json_decode(file_get_contents("users.json"), true);
    $email = $_POST['email'];
    $password = $_POST['password'];

    $userFinns = array_find($users, function ($user) use($email) {
        return $user['email'] == $email;
    });

    if($userFinns != true){
        Res::redirect_error("/login", "Användare finns inte");
        return;
    }

    if(!password_verify($password, $userFinns['password'])){
        Res::redirect_error("/login", "Fel lösenord");
        return;
    }

    $_SESSION["auth"] = true;
    $_SESSION['email'] = $email;
    $_SESSION['uid'] = $userFinns['id'];

    Res::redirect("/", "LOGGED IN");
});

App::post("/posts", function(){
    if(empty($_SESSION['uid'])){
        Res::redirect_error("/login", "Måste vara inloggad för att skapa post");
        return;
    }

    $title = $_POST["title"];
    $text = $_POST["text"];

    Posts::create($title, $text, $_SESSION['uid']);
    Res::redirect("/", "Post created");
});


App::any("/404", "views/404");
