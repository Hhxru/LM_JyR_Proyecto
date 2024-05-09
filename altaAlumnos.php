<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Formulario de alta Alumnos</h1>
    <form action="altaAlumnos.php" method="post">

        <input type="email" name="email" placeholder="Email" pattern=".+@gmail\.com" required>
        <input type="text" name="nia" placeholder="NIA" pattern="[0-9]*" minlength="8" maxlength="8" required>
        <input type="text" name="telefono" placeholder="Nº Telefono" pattern="[0-9]*" minlength="9" maxlength="9" required>
        <input type="text" name="nombre" placeholder="Nombre" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]+" title="Ingrese solo letras" required>
        <input type="password" name="contrasena" placeholder="Contraseña" minlength="4" required>
        <input type="submit" value="Registrar alumno">
        <input type="reset" value="Borrar datos">

    </form>

    <?php
        $email=$_POST['email'] ?? null;
        $nia=$_POST['nia'] ?? null;
        $tel=$_POST['telefono'] ?? null;
        $nombre=$_POST['nombre'] ?? null;
        $password=$_POST['contrasena'] ?? null;

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
                $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

                $sql = "insert into alumno (email, nia, telefono, nombre, passwrd) values (:email, :nia, :telefono, :nombre, :password)";


                $datos=[
                    ":email"=>$email,
                    ":nia"=>$nia,
                    ":telefono"=>$tel,
                    ":nombre"=>$nombre,
                    ":password"=>$password
                ];

                $stmt = $pdo->prepare($sql);
                $row = $stmt->execute($datos);

                if($row){
                    echo"Usuario registrado con éxito";
                }else{
                    echo"Error en el registro. No se han podido registrar los datos.";
                }
            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }
    ?>
</body>
</html>