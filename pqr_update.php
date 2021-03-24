<?php 
require 'database.php';
session_start();
if(!isset($_SESSION['user']) && (!isset($_SESSION['user_id']) && (!isset($_SESSION['rol'])))){
    header("location:login.php");
}

if($_SESSION['rol']=='user'){
    header("location:pqr_form.php");
}

if(!isset($_POST['update'])){
    $id=$_GET['id'];
    $state=$_GET['state'];
    $sql="SELECT * from states WHERE idState !=$id";
    $show=$conn->prepare($sql); 
    $show->execute();
    $result = $show->fetchAll(PDO::FETCH_ASSOC);
    
}else{
    $id=$_POST['id'];
    $state=$_POST['state']; 
    $sql="UPDATE pqrs SET fk_state=:fk_state WHERE idPqrs=:id";
    $update=$conn->prepare($sql); 
    $update->bindParam(':id',$_POST['id']);
    $update->bindParam(':fk_state',$_POST['state']);
    $update->execute();
}

if(isset($_POST['update'])){
    $message='Se ha actualizado el registro correctamente';
}
?>
    
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <title>Document</title>
    </head>
    <body>
    <body>
     <div class="ml-5"> <a href="pqrs_admin.php">Volver atrás</a></div>
        <div class="container col-5">
            <h1 class="text-center mb-5">Extreme Techonologics</h1>
            <h2 class="text-center">Ingrese los campos a cambiar</h2>
            <form action="pqr_update.php" method="POST">
                <div class="form-group">
                    <input type="hidden" value="<?php echo $id?>" class="form-control" name="id">
                </div>
                <div class="form-group my-5">
                    <label for="pqr_type">Seleccione el estado del PQR:</label>
                    <select class="form-control" id="state" name="state">
                    <?php
                        foreach($result as $state):
                            if (
                                (($_REQUEST['state'] == 'Nuevo') && $state['state']!= "Cerrado") 
                                ||
                                (($_REQUEST['state'] == 'En Ejecución') && $state['state']!= "Nuevo") 
                            ):
                    ?>   
                        <option value="<?php echo $state['idState'];?>"><?php echo $state['state'];?></option>
                    <?php endif; endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" name="update">Enviar</button>
            </form>
            <?php if(!empty($message)):?>
            <div class="alert alert-success mt-3" role="alert">
                <?=$message?>
            </div>
            <?php endif ?>
        </div>
        <a href="logout.php">Cerrar Sesión</a>
    </body>
    </html>
</html>