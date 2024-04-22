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
        <td>DNI</td>
        <td>Apellido_1</td>
        <td>Apellido_2</td>
        <td>Nombre</td>
        <td>Direccion</td>
        <td>Localidad</td>
        <td>Provincia</td>
        <td>Fecha de nacimiento</td>
    </tr>

    <?php
        $host='rpsserv.com';
        $dbname='universidad';
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
                echo "<tr>"."<td>".$row['DNI']."</td>"."<td>".$row['APELLIDO_1']."</td>"."<td>".$row['APELLIDO_2']."</td>"."</tr>";
            }
        }

    catch(PDOException $e) {
        echo $e->getMessage();
    }
    ?>
</table>
</body>
</html>