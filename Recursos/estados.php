<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<?php
        $estado=$_POST['estado'] ?? null;

        if($_POST){
            $host='localhost';
            $dbname='fct';
            $user='root';
            $pass='';
            
            try {
              # MySQL con PDO_MYSQL
              # Para que la conexion al mysql utilice las collation UTF-8 añadir charset=utf8 al string de la conexion.
              $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
            
              # Para que genere excepciones a la hora de reportar errores.
              $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            
              
              $sql= "select * from estado";
              $datos = [
                /*":dni"=>$dni,
                ":nombre"=>$nombre,
                ":apellido_1"=>$apellido*/
              ];
              $stmt = $pdo->prepare($sql);
              $row = $stmt->execute($datos);

              if($row){
                echo $e->getMessage();
              }
    ?>

<body>
    <form action="estados.php" method="$_POST">

        <label for="">Estados:</label>
        <select name="estado" id="">
            <option value="">--seleccion--</option>
            <?php
                while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
                    echo "<option value='".$row['nombre']."'>".$row['nombre']."<option>";
                }
            ?>
        </select>
        <input type="submit">
    </form>

    <?php
        }catch(PDOException $e){
            echo "Error de conexión";
        }
    } 
    ?>
</body>
</html>