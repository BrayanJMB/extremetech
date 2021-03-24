<?php
$message ='';
$message ='';
$date=date("Y-m-d H:i:s");
session_start();
if(!isset($_SESSION['user']) && (!isset($_SESSION['user_id']) && (!isset($_SESSION['rol'])))){
    header("location:login.php");
}

if(isset($_POST['form'])){
    $message='Se ha creado el registro correctamente';
}



require 'database.php';

if(!empty($_POST['asunto_pqr']) && (!empty($_POST['pqr_type']))){
    if($_POST['pqr_type']==1){
        $sql = "INSERT INTO pqrs (asunto_pqr,fk_user,fk_pqr_types,deadline) VALUES(:asunto_pqr,:fk_user,:fk_pqr_types, date_add(now(),interval 7 day))";
    }else if ($_POST['pqr_type']==2) {
        $sql = "INSERT INTO pqrs (asunto_pqr,fk_user,fk_pqr_types,deadline) VALUES(:asunto_pqr,:fk_user,:fk_pqr_types, date_add(now(),interval 3 day))";
    }else{
        $sql = "INSERT INTO pqrs (asunto_pqr,fk_user,fk_pqr_types,deadline) VALUES(:asunto_pqr,:fk_user,:fk_pqr_types, date_add(now(),interval 2 day))";
    }
    $pqr=$conn->prepare($sql); 
    $pqr->bindParam(':asunto_pqr',$_POST['asunto_pqr']);
    $pqr->bindParam(':fk_pqr_types',$_POST['pqr_type']);
    $pqr->bindParam(':fk_user',$_SESSION['user_id']);
    $pqr->execute();
}
$query_date= "SELECT * FROM pqr_types";
$query_date=$conn->prepare($query_pqrtype);
$query_date->execute();
$result = $query_date->fetchAll(PDO::FETCH_ASSOC);

$query_pqrtype= "SELECT deadlines FROM pqrs";
$pqrtype=$conn->prepare($query_pqrtype);
$pqrtype->execute();
$result = $pqrtype->fetchAll(PDO::FETCH_ASSOC);
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
    <?php if($_SESSION['rol']=='administrator'):?>
        <div class="ml-5"> <a href="pqrs_admin.php">Volver atrás</a></div>
        <?php else:?>
        <div class="ml-5"> <a href="pqr_user.php">Para ver sus solicitudes PQR haga clic aquí</a></div>
        <?php endif?>
    <div class="container col-5">
        <h1 class="text-center mb-5">Extreme Techonologics</h1>
        <h2 class="text-center">Ingrese su solictud por favor</h2>
        
        <form action="pqr_form.php" method="POST">
            <div class="form-group my-5">
                <label for="pqr_type">Tipo de PQR</label>
                <select class="form-control" id="pqr_type" name="pqr_type">
                <option></option>   
                <?php 
                foreach($result as $pqrtype){
                ?>
                <option value="<?php echo $pqrtype['idPqrs_Type'] ?>"><?php echo $pqrtype['pqr_type'];  ?></option>
                <?php
                }
                ?>              
                </select>
            <div class="form-group mt-5">
                <label for="asunto_pqr">Asunto PQR</label>
                <textarea class="form-control" name="asunto_pqr" rows="5" placeholder="Ingrese su solicitud"></textarea> 
            </div>
            </div>
            <button type="submit" class="btn btn-primary" name="form">Enviar</button>
            <?php if(!empty($message)):?>
            <div class="alert alert-success mt-3" role="alert">
                <?=$message?>
            </div>
            <?php endif ?>
        </form>
        <?php if(!empty($notification)):?>
        <div class="alert alert-alert mt-3" role="alert">
                <?=$message?>
            </div>
        <?php endif ?>
    </div>
    <a href="logout.php">Cerrar Sesión</a>
</body>
</html>