<?php 
    require 'database.php';
    session_start();
    if(!isset($_SESSION['user']) && (!isset($_SESSION['user_id']) && (!isset($_SESSION['rol'])))){
        header("location:login.php");
    }
    if($_SESSION['rol']=='user'){
        header("location:pqr_form.php");
    }
    
?>
    <h1 class="text-center">Welcome</h1>
    <?php
    echo "<div class='text-center'> Bienvenido " . $_SESSION['user'] . " su rol es " . $_SESSION['rol'] . "<div>";
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
  
<div class="container">
    <h2 class="text-center mb-4">PQRS</h2>

    <table class="table">
    <thead class="thead-dark">
        <tr>
        <th scope="col">#</th>
        <th scope="col">Usuario</th>
        <th scope="col">Asunto PQR</th>
        <th scope="col">Tipo de PQR</th>
        <th scope="col">Fecha Creación</th>
        <th scope="col">Fecha Límite</th>
        <th scope="col">Estado</th>
        <th scope="col">Acciones</th>
        
        
        </tr>
    </thead>
    <tbody>
        <?php
        $sql="SELECT *,user,pqr_type,state FROM pqrs 
        INNER JOIN pqr_types ON pqrs.fk_pqr_types = pqr_types.idPqrs_Type 
        INNER JOIN states ON pqrs.fk_state = states.idState
        INNER JOIN users ON pqrs.fk_user = users.idUsers ORDER BY idPqrs";
        $data=$conn->prepare($sql); 
        $data->execute(); 
        $result = $data->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $pqr):?>
        <tr>
            <th scope='row'><?php echo $pqr['idPqrs']?>
            <td><?php echo $pqr['user'] ?> </td>
            <td><?php echo $pqr['asunto_pqr'] ?> </td>
            <td><?php echo $pqr['pqr_type'] ?> </td>
            <td><?php echo $pqr['creation_date'] ?> </td>
            <td><?php echo $pqr['deadline'] ?> </td>
            <td><?php echo $pqr['state'] ?> </td>
            <td> 
            <?php if ($pqr['state']!='Cerrado'):?>
                <a href='pqr_update.php?id=<?php echo $pqr['idPqrs']?>& state=<?php echo $pqr['state']?>'>Editar</a>
            <?php endif ?>
            <a href='pqr_delete.php?id=<?php echo $pqr['idPqrs']?>'>Eliminar</a> </td>
        </tr>
        <?php
            endforeach
        ?>
    </tbody>
    </table>
 
    <?php
    /* class Datetime,to calculate the difference of the
     current date and the limit according to the type of pqr
        $hoy = date("Y-m-d H:i:s");
        echo $hoy;
        $mañana =  date("2021-03-24 8:50:60");    
          $datetime1 = new DateTime($hoy);
          $datetime2 = new DateTime($mañana);
          $interval = $datetime1->diff($datetime2);
          echo $interval-> i. ' dias'; 
          */
        ?>
</div> 
<a href="logout.php">Cerrar Sesión</a>
<a href="pqr_form.php">Crear un nuevo PQR</a>
</body>
</html>
