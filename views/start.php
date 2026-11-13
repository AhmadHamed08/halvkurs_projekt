<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        <?php
            include("style.css");
        ?>
    </style>

</head>
<body>
    <header>
        <nav>
            <a href="/">HOME</a>
            <a href="/register">REGISTER</a>
            <a href="/login">LOGIN</a>
        </nav>
    </header>
    <section>
        <?php 
        if(!empty($_GET['error']))
            echo  $_GET['error'];
        ?>
    </section>
    <section class = "success">
        <?php 
        if(!empty($_GET['message']))
            echo  $_GET['message'];
        ?>
    </section>
    <main>
