<?php include("start.php"); ?>

<h1>HOME</h1>

<?php
$posts = Posts::getAll();

foreach($posts as $p):
    extract($p);
?>

    <div class="post" id="<?= $id ?>">
        <h2><?php App::out($title) ?></h2>
        <p><?php App::out($text) ?></p>

    </div>

<?php
endforeach
?>


<?php include("end.php"); ?>