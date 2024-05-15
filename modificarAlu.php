<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Alumno</title>
    <link rel="stylesheet" href="css/dashboardAlu.css">
</head>
<body>
    <header>
        <div id="logo">
            <img src="img/OIG2-removebg-preview.png" alt="">
            
        </div>
    </header>
    <section id="cuerpoPrincipal">
        <?php

            $id = $_GET['id'] ?? null;
            $email = $_POST['email'] ?? null;
            $nia = $_POST['nia'] ?? null;
            $tel = $_POST['telefono'] ?? null;
            $nombre = $_POST['nombre'] ?? null;
            $password = $_POST['contrasena'] ?? null;

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
                
                $datos=[];

                //numero id (fila) a mostrar
                $mostrarFila = "SELECT * FROM alumno WHERE email=\"$id\"";
                $stmt = $pdo->prepare($mostrarFila);
                $stmt->execute($datos);
                $usuario=$stmt->fetch();

            ?>  


            <form action="dashboardAlu.php" method="post">
            <input type="email" name="email" value="<?php print($usuario['email'])?>" readonly>
            <input type="text" name="nia" placeholder="NIA" value="<?php print($usuario['nia'])?>" pattern="[0-9]*" minlength="8" maxlength="8" required>
            <input type="text" name="telefono" placeholder="Nº Telefono" value="<?php print($usuario['telefono'])?>" pattern="[0-9]*" minlength="9" maxlength="9" required>
            <input type="text" name="nombre" placeholder="Nombre" value="<?php print($usuario['nombre'])?>" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]+" title="Ingrese solo letras" required>
            <input type="password" name="contrasena" placeholder="Contraseña" value="<?php print($usuario['passwrd'])?>" minlength="4" required>
            <input type="submit" value="Modificar">
            </form>

            <a href="dashboardTutor.php">Volver</a>


            <?php

            $datos = [
                /*
                ":email" => $email,
                ":nia" => $nia,
                ":telefono" => $tel,
                ":nombre" => $nombre,
                ":contrasena" => $password
                */
            ];

            $sql = "UPDATE alumno SET nia = \"$nia\", telefono = \"$tel\", nombre = \"$nombre\", passwrd = \"$password\" WHERE email = \"$email\"";
            $stmt = $pdo->prepare($sql);
            $usuario = $stmt->execute($datos);

            if($usuario){
                echo "Usuario modificado con éxito";
            }else{
                echo "Upps!!! Algo salió mal";
                echo "Revise los campos y vuelva a intentarlo";
            }


            }catch(PDOException $e){
                echo "Error de conexion con la BD";
            }
        ?>
    </section>
    
</body>
</html>