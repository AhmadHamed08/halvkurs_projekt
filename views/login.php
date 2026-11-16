<?php include("start.php"); ?>

<h1>LOGIN</h1>

<div class="form">
    <form action="/login" method="post">
        <input required type="email" name="email" placeholder="EMAIL">
        <input required type="password" name="password" placeholder="PASSWORD" minlength="4">
        <input type="submit" value="REGISTER">
    </form>
</div>

<?php include("end.php"); ?>