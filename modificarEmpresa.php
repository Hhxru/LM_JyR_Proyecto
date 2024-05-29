<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Empresa</title>
    <link rel="stylesheet" href="css/modificar.css">
</head>
<body>
    <header>
        <h1>MediaGestCT</h1>
        <ul>
            <li><a href="dashboardTutor.php">Empresas</a></li>
            <li><a href="">Usuario </a></li>
        </ul>
        <div id="logo">
            <img src="img/OIG2-removebg-preview.png" alt="">
            
        </div>
    </header>
    <section id="cuerpoPrincipal">
        <article>
        <?php

            $id = $_GET['id'] ?? null;
            $cif = $_POST['cif'] ?? null;
            $nombre = $_POST['nombre'] ?? null;
            $nombreFiscal = $_POST['nombre_fiscal'] ?? null;
            $email = $_POST['email'] ?? null;
            $direccion = $_POST['direccion'] ?? null;
            $localidad = $_POST['localidad'] ?? null;
            $provincia = $_POST['provincia'] ?? null;
            $numero_plazas = $_POST['plazas'] ?? null;
            $telefono = $_POST['tel'] ?? null;
            $persona_contacto = $_POST['contacto'] ?? null;
            $modificar = $_POST['modificar'] ?? null;

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
                $mostrarFila = "SELECT * FROM empresa WHERE nombre=\"$id\"";
                $stmt = $pdo->prepare($mostrarFila);
                $stmt->execute($datos);
                $empresa=$stmt->fetch();

            ?>  

            <h2>Modificar Empresa</h2>

            <form action="modificarEmpresa.php" method="post">
                <input type="text" class="textbox" name="cif" value="<?php echo isset($empresa['cif']) ? $empresa['cif'] : '' ?>" readonly>
                <input type="text" class="textbox" name="nombre" placeholder="Nombre" value="<?php echo isset($empresa['nombre']) ? $empresa['nombre'] : '' ?>" required>
                <input type="text" class="textbox" name="nombre_fiscal" placeholder="Nombre Fiscal" value="<?php echo isset($empresa['nombre_fiscal']) ? $empresa['nombre_fiscal'] : '' ?>" required>
                <input type="email" class="textbox" name="email" placeholder="Email" value="<?php echo isset($empresa['email']) ? $empresa['email'] : '' ?>" required>
                <input type="text" class="textbox" name="direccion" placeholder="Dirección" value="<?php echo isset($empresa['direccion']) ? $empresa['direccion'] : '' ?>" required>
                <input type="text" class="textbox" name="localidad" placeholder="Localidad" value="<?php echo isset($empresa['localidad']) ? $empresa['localidad'] : '' ?>" required>
                <input type="text" class="textbox" name="provincia" placeholder="Provincia" value="<?php echo isset($empresa['provincia']) ? $empresa['provincia'] : '' ?>" required>
                <input type="number" class="textbox" name="plazas" placeholder="Número de Plazas" value="<?php echo isset($empresa['numero_plazas']) ? $empresa['numero_plazas'] : '' ?>" required>
                <input type="tel" class="textbox" name="tel" placeholder="Teléfono" value="<?php echo isset($empresa['telefono']) ? $empresa['telefono'] : '' ?>" required>
                <input type="text" class="textbox" name="contacto" placeholder="Contacto" value="<?php echo isset($empresa['persona_contacto']) ? $empresa['persona_contacto'] : '' ?>" required>
                <input type="submit" class="button" name="modificar" value="Modificar">
            </form>

           <a href="gestorEmpresas.php"> <input type="submit" class="button" value="Volver"></a>


            <?php

            $datos = [
                /*
                ":nombre" => $nombre,
                ":nombre_fiscal" => $nombreFiscal,
                ":email" => $email,
                ":direccion" => $direccion,
                ":localidad" => $localidad,
                ":provincia" => $provincia,
                ":plazas" => $numPlaza,
                ":telefono" => $telefono,
                ":contacto" => $contacto,
                */
            ];

            if(isset($_POST['modificar'])){
                $sql = "UPDATE empresa SET nombre = '$nombre', nombre_fiscal = '$nombreFiscal', email = '$email', direccion = '$direccion', localidad = '$localidad', provincia = '$provincia', numero_plazas = '$numero_plazas', telefono = '$telefono', persona_contacto = '$persona_contacto' WHERE cif = '$cif'";
                $stmt = $pdo->prepare($sql);
                $empresa = $stmt->execute($datos);
                echo "Empresa modificada con éxito";
            }else{
                echo "Upps!!! Algo salió mal";
                echo "Revise los campos y vuelva a intentarlo";
            }


            }catch(PDOException $e){
                echo "Error de conexion con la BD";
            }
        ?>
        </article>
    </section>
    <footer>
        <p>2024 Mediagest. Todos los derechos reservados.</p>
    </footer>

    
</body>
</html>
