<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        form{
            display: flex;
            flex-direction: column;
            width: 30%;
        }
    </style>
</head>
<body>

    <h1>Formulario registro alu</h1>

    <form action="alumnoForm.php" method="post">

        <label for="nom">Nombre:</label>
        <input type="text" name="nom"required>

        <label for="ape">Apellido</label>
        <input type="text" name="ape" required>

        <label for="dni">DNI:</label>
        <input type="text" name="dni" required>

        <input type="submit" value="Enviar">
        <input type="reset">
    </form>


    <?php
        $dni=$_POST['dni'] ?? null;
        $nombre=$_POST['nom'] ?? null;
        $apellido=$_POST['ape'] ?? null;

        if($_POST){
            $host='localhost';
            $dbname='universidad';
            $user='root';
            $pass='';
            
            try {
              # MySQL con PDO_MYSQL
              # Para que la conexion al mysql utilice las collation UTF-8 añadir charset=utf8 al string de la conexion.
              $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
            
              # Para que genere excepciones a la hora de reportar errores.
              $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            
              
              $sql= "insert into alumno (dni, nombre, apellido_1) values (:dni, :nombre, :apellido_1)";
              $datos = [
                ":dni"=>$dni,
                ":nombre"=>$nombre,
                ":apellido_1"=>$apellido
              ];
              $stmt = $pdo->prepare($sql);
              $row = $stmt->execute($datos);

              if($row){
                echo "Usuario registrado con éxito";
                echo "<a href="."listarAlumnos.php"."><strong>Ver listado de Alumnos</strong></a>";
              }
            }

            catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
    ?>
</body>
</html>