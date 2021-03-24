<?php
session_start();
if(isset($_SESSION['user_id'])){
  header('location:pqrs_admin.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Extreme Tech</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>  
  <div class="container text-center mt-5">
        <h1 >Bienvenido a Extreme Technologies</h1>
        <h2 >¿Qué deseas hacer?</h2>

        <a href="login.php" >Iniciar Sesión</a> o
        <a href="register.php">Registrarte</a>

  </div>
</body>
</html>