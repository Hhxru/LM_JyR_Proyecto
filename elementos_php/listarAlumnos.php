<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<table  border="5">
    <tr id="tabla_cab">
        
    </tr>

    <?php
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
        
          # SQLite Database
        

        $sql = "SELECT * FROM alumno";
        $datos = [];

        $stmt = $pdo->prepare($sql);
        $stmt->execute($datos);
    

        while($row = $stmt->fetch()){
                echo "<tr>"."<td>".$row['email']."</td>"."<td>".$row['nia']."</td>"."<td>".$row['telefono']."</td>"."<td>".$row['nombre']."</td>"."<td>".$row['cv_file']."</td>"."<td>".$row['passwrd']."</td>"."</tr>";

                echo $row['email'].$row['nia'];
            }
        }

    catch(PDOException $e) {
        echo $e->getMessage();
    }
    ?>
</table>
</body>
</html>