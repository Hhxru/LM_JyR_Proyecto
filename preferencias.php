<?php 
    include 'sesion.php';
    $logout=$_POST['logout'] ?? null;
    if(isset($logout)){
        header('Location: login.php');
        session_destroy();
    }   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/Template.css">
</head>
<body>
    <header>
        <h1>MediaGestCT</h1>
        <ul>
            <li><a href="dashboardAlumno.php">Inicio</a></li>
            <form action="dashboardAlumno.php" method="post">
                    <li><input type="submit" name="logout" value="Cerrar Sesión"></li>
            </form>
        </ul>
        <div id="logo">
            <img src="img/OIG2-removebg-preview.png" alt="">
        </div>
    </header>
    <?php

            $empresa=$_GET['empresa'] ?? null;

            $host='localhost';
            $dbname='fct';
            $user='root';
            $pass='';

            try {
                # MySQL con PDO_MYSQL
                # Para que la conexion al mysql utilice las collation UTF-8 añadir charset=utf8 al string de la conexion.
                $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
                
                # Para que genere excepciones a la hora de reportar errores.
                $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );  
     ?> 
    <section id="cuerpoPrincipal">
        <article id="usuario">
            <article>
                <h2 class="text">Informacion de usuario</h2>
                <p>Nombre: <?php  print($_SESSION['user'])?></p>
                <p>Email: <?php print($_SESSION['email'])?></p>
                <p>Iniciado como: Alumno</p>
            </article>
        </article>

        <article id="tabla">
            <h1 class="text">Mis Preferencias</h1>
                <table>
                    <tr>
                        <th class="tdmain">Preferencia</th>
                        <th class="tdmain">Empresa</th>
                        <th class="tdmain">Año</th>
                        <th class="tdmain">Periodo</th>
                        <th class="tdmain">--</th>
                    </tr>

                <?php

                    $datos = [":usuario"=>$_SESSION['email']];   
                    $sql = "SELECT orden, empresa_id, anyo, periodo FROM prioridades WHERE alumno_id=:usuario";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute($datos);

                    while($row=$stmt->fetch()){
                        echo"<tr>
                            <td>".$row['orden']."</td>
                            <td>".$row['empresa_id']."</td>
                            <td>".$row['anyo']."</td>
                            <td>".$row['periodo']."</td>
                            <td>
                                <button class= 'button' name='borrar' onclick=window.location='preferencias.php?empresa=".$row['empresa_id']."'>Eliminar</button>
                            </td>
                        </tr>";
                    }

                    if(isset($_GET['empresa'])){

                        $datos = [
                            ":usuario"=>$_SESSION['email'],
                            ":empresa"=>$empresa
                        ];
                        $sql = "DELETE FROM prioridades WHERE alumno_id=:usuario and empresa_id=:empresa";
                        print($sql);
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute($datos);
                        echo '<script>window.location.href = "preferencias.php";</script>';
                    }
                    
                }catch(PDOException $e){
                    echo $e->getMessage();
                }
                ?>
        </article>
</body>
</html>