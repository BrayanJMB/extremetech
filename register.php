<?php
session_start();
if(isset($_SESSION['user_id']) &&isset($_SESSION['rol'])){
    if($_SESSION['rol']=='administrator'){
        header('location:pqrs_admin.php');
    }else{
        header('location:pqr_form.php'); 
    }
}

require 'database.php';
$message='';
$message_error='';
if(!empty($_POST['user']) && !empty($_POST['password'] && !empty($_POST['password_confirmation'] && !empty($_POST['roles'])))){
    $sql = "INSERT INTO users (user,password,password_confirmation,fk_roles) VALUES(:user,:password,:password_confirmation,:roles)";
    $sql2= "SELECT user FROM users";
    $user=$conn->prepare($sql2); 
    $user->bindParam(':user',$_POST['user']);
    $user->execute();
    $state = $conn->prepare($sql);
    $state->bindParam(':user',$_POST['user']);
    $state->bindParam(':roles',$_POST['roles']);
    $password = password_hash($_POST['password'],PASSWORD_BCRYPT);
    $password_c = password_hash($_POST['password_confirmation'],PASSWORD_BCRYPT);
    $state->bindParam(':password',$password);
    $state->bindParam(':password_confirmation',$password_c);

    if($user->fetchColumn()>0){
        $message_error = "El usuario con el que intenta ingresar ya se encuentra registrado.";
    }else if ($_POST['password'] <> $_POST['password_confirmation']){
        $message_error="Las contraseñas ingresadas no coinciden, ingrese nuevamente los datos.";
    }else{
        if($state->execute()){
            $message='El usuario ha sido creado sastifactoriamente.';
        }else{
            $message_error='Ha ocurrido un error en el registro intenta de nuevo.';
        }
    }
}
$query_roles= "SELECT * FROM roles";
$roles=$conn->prepare($query_roles);
$roles->execute();
$result = $roles->fetchAll(PDO::FETCH_ASSOC);
foreach($result as $rol){
    $_SESSION['rol_name']=$rol['idRoles'];
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
        <h1 class="text-center mb-5">Extreme Techonologics</h1>
        <h2 class="text-center">Registro</h2>
        <p class="text-center">Ya estás registrado? <a href="login.php">Iniciar Sesión</a></p>
        <form action="register.php" method="POST">
        <div class="form-group">
            <label for="user">Usuario</label>
            <input type="text" class="form-control" id="user" name="user"  placeholder="Ingrese el usuario">
        </div>
        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese la contraseña">
        </div>
        <div class="form-group">
            <label for="password">Confirmación contraseña</label>
            <input type="password" class="form-control" id="password" name="password_confirmation" placeholder="Ingrese la contraseña nuevamente">
        </div>
        <div class="form-group">
            <label for="roles">Seleccione un rol</label>
            <select class="form-control" id="roles" name="roles">
            <option></option>   
            <?php 
            foreach($result as $rol){
            ?>
            <option value="<?php echo $rol["idRoles"]; ?>"><?php echo $rol["rol_nmae"] ?></option>
            <?php
			}
			?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
        <?php if(!empty($message)):?>
            <p class="alert alert-success mt-3" role="alert"><?= $message?> </p> 
        <?php endif; ?>
        <?php if(!empty($message_error)):?>
            <p class="alert alert-danger mt-3" role="alert"><?= $message_error?> </p> 
        <?php endif; ?>
    
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>