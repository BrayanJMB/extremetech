<?php require 'database.php';
session_start();

if(!empty($_POST['user']) && !empty($_POST['password'])){
    //"SELECT user, rol FROM users INNER JOIN roles ON users.fk_roles = roles.idRoles WHERE idRoles=2"
    $records = $conn->prepare('SELECT idUsers,user,password,rol FROM users INNER JOIN roles ON users.fk_roles = roles.idRoles WHERE user=:user');
    $records->bindParam(':user',$_POST['user']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);
    $message='';

    if (count($results) > 0 && password_verify($_POST['password'], $results['password'])) {
        $_SESSION['user_id']=$results['idUsers'];
        $_SESSION['user']=$results['user'];
        $_SESSION['rol']=$results['rol'];
    }else{
        $message='El usuario o la contraseña son incorrectos';
    }
}
if(isset($_SESSION['rol'])){
    if($_SESSION['rol']=='administrator'){
        header('location:pqrs_admin.php');
    }else{
        header('location:pqr_form.php');
    }
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<div class="ml-5"><?php require 'partials/header.php' ?></div>
<div class="container col-5">
        <h1 class="text-center mb-5">Extreme Technologies</h1>
        <h2 class="text-center">Inicio de Sesión</h2>
        <p class="text-center">No estás registrado? <a href="register.php">Regístrate</a></p>
        <form action="login.php" method="POST">
        <div class="form-group">
            <label for="user">Usuario</label>
            <input type="text" class="form-control" id="user" name="user"  placeholder="Ingrese el usuario">
        </div>
        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese la contraseña">
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
        <?php if(!empty($message)):?>
            <p class="alert alert-danger mt-3" role="alert"><?= $message?> </p> 
        <?php endif; ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>