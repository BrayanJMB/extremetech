<?php 
    require 'database.php';
    session_start();
    if(!isset($_SESSION['user_id']) && isset($_SESSION['user']) && (!isset($_SESSION['rol']))){
            header("location:login.php");
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
        <th scope="col">Asunto PQR</th>
        <th scope="col">Tipo de PQR</th>
        <th scope="col">Fecha Creación</th>
        <th scope="col">Fecha Límite</th>
        <th scope="col">Estado</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql="SELECT *,pqr_type,state FROM pqrs 
        INNER JOIN pqr_types ON pqrs.fk_pqr_types = pqr_types.idPqrs_Type 
        INNER JOIN states ON pqrs.fk_state = states.idState
        INNER JOIN users ON pqrs.fk_user = users.idUsers WHERE fk_user=". $_SESSION['user_id'];"";
        $data=$conn->prepare($sql); 
        $data->execute(); 
        $result = $data->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $pqr){
        echo "<tr>";
        echo "<td>".$pqr['asunto_pqr'] . "</td>";
        echo "<td>".$pqr['pqr_type'] . "</td>";
        echo "<td>".$pqr['creation_date'] . "</td>";
        echo "<td>".$pqr['deadline'] . "</td>";
        echo "<td>".$pqr['state'] . "</td>";
        echo"</tr>";
        }
    ?>
    </tbody>
    </table>
    
</div> 
<a href="logout.php">Cerrar Sesión</a>
<a href="pqr_form.php">Crear un nuevo PQR</a>
</body>
</html>
