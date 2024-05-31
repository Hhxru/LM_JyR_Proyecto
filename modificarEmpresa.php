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
            <li><a href="dashboardTutor.php">Inicio </a></li>
            <li><a href="gestorAlumnos.php">Alumno</a></li>
            <li><a href="gestorEmpresas.php">Empresas</a></li>
        </ul>
        <div id="logo">
            <img src="img/OIG2-removebg-preview.png" alt="">
            
        </div>
    </header>
    <section id="cuerpoPrincipal">
        <article>
        <?php

            $id = $_POST['id'] ?? null;
            $cif = $_POST['cif'] ?? null;
            $nombre = $_POST['nombre'] ?? null;
            $nombreFiscal = $_POST['nombre_fiscal'] ?? null;
            $email = $_POST['email'] ?? null;
            $direccion = $_POST['direccion'] ?? null;
            $localidad = $_POST['localidad'] ?? null;
            $provincia = $_POST['provincia'] ?? null;
            $numPlazas = $_POST['plazas'] ?? null;
            $telefono = $_POST['tel'] ?? null;
            $contacto = $_POST['contacto'] ?? null;
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
                $mostrarFila = "SELECT * FROM empresa WHERE nombre='$id'";
                $stmt = $pdo->prepare($mostrarFila);
                $stmt->execute($datos);
                $empresa=$stmt->fetch();

            ?>  

            <h2>Modificar Empresa</h2>

            <form action="modificarEmpresa.php" method="post">
                <input type="text" class="textbox" name="nombre" value="<?php print($empresa['nombre'])?>" readonly>
                <input type="text" class="textbox" name="cif" placeholder="CIF/NIF" value="<?php print($empresa['cif'])?>" maxlength="9" required>
                <input type="text" class="textbox" name="nombre_fiscal" placeholder="Nombre Fiscal" value="<?php print($empresa['nombre_fiscal'])?>" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ. ]+" title="Ingrese situación fiscal" required>
                <input type="email" class="textbox" name="email" placeholder="Email" value="<?php print ($empresa['email'])?>" title="Tipo: @gmail.com" pattern=".+@gmail\.com" required>
                <input type="text" class="textbox" name="direccion" placeholder="Dirección" value="<?php print($empresa['direccion'])?>" title="Introdice C/ o Avnd/ _direccion_, _numero_" pattern="^(C\/|Avnd\/)\s.+,\s\d+$" required>
                <input type="text" class="textbox" name="localidad" placeholder="Localidad" value="<?php print($empresa['localidad'])?>" required>
                <select class="textbox" name="provincia" required>
                        <option value="seleccionar"><?php print($empresa['provincia'])?></option>
                        <option value="alava">Álava</option>
                        <option value="albacete">Albacete</option>
                        <option value="alicante">Alicante</option>
                        <option value="almeria">Almería</option>
                        <option value="avila">Ávila</option>
                        <option value="badajoz">Badajoz</option>
                        <option value="baleares">Baleares</option>
                        <option value="barcelona">Barcelona</option>
                        <option value="burgos">Burgos</option>
                        <option value="caceres">Cáceres</option>
                        <option value="cadiz">Cádiz</option>
                        <option value="cantabria">Cantabria</option>
                        <option value="castellon">Castellón</option>
                        <option value="ceuta">Ceuta</option>
                        <option value="ciudad_real">Ciudad Real</option>
                        <option value="cordoba">Córdoba</option>
                        <option value="cuenca">Cuenca</option>
                        <option value="gerona">Gerona</option>
                        <option value="granada">Granada</option>
                        <option value="guadalajara">Guadalajara</option>
                        <option value="guipuzcoa">Guipúzcoa</option>
                        <option value="huelva">Huelva</option>
                        <option value="huesca">Huesca</option>
                        <option value="jaen">Jaén</option>
                        <option value="la_coruna">La Coruña</option>
                        <option value="la_rioja">La Rioja</option>
                        <option value="las_palmas">Las Palmas</option>
                        <option value="leon">León</option>
                        <option value="lerida">Lérida</option>
                        <option value="lugo">Lugo</option>
                        <option value="madrid">Madrid</option>
                        <option value="malaga">Málaga</option>
                        <option value="melilla">Melilla</option>
                        <option value="murcia">Murcia</option>
                        <option value="navarra">Navarra</option>
                        <option value="orense">Orense</option>
                        <option value="palencia">Palencia</option>
                        <option value="pontevedra">Pontevedra</option>
                        <option value="salamanca">Salamanca</option>
                        <option value="segovia">Segovia</option>
                        <option value="sevilla">Sevilla</option>
                        <option value="soria">Soria</option>
                        <option value="tarragona">Tarragona</option>
                        <option value="tenerife">Tenerife</option>
                        <option value="teruel">Teruel</option>
                        <option value="toledo">Toledo</option>
                        <option value="valencia">Valencia</option>
                        <option value="valladolid">Valladolid</option>
                        <option value="vizcaya">Vizcaya</option>
                        <option value="zamora">Zamora</option>
                        <option value="zaragoza">Zaragoza</option>
                    </select>
                <input type="number" class="textbox" name="plazas" placeholder="Número de Plazas" value="<?php print($empresa['numero_plazas'])?>" pattern="[0-9]*" maxlength="3" required>
                <input type="tel" class="textbox" name="tel" placeholder="Nº Teléfono" title="Formato junto 9 digitos" value="<?php print($empresa['telefono'])?>" pattern="[0-9]*" minlength="9" maxlength="9" required>
                <input type="text" class="textbox" name="contacto" placeholder="Contacto" value="<?php print($empresa['persona_contacto'])?>" required>
                <div>
                    <input type="hidden" name="id" value="<?php $empresa['nombre']?>">
                    <input type="submit" class="button" name="modificar" value="Modificar"></a>
                    <a href="gestorEmpresas.php" class="button">Volver</a>
                </div>
            </form>



            <?php

            $datos = [
                
                ":nombre" => $nombre,
                ":cif" => $cif,
                ":nom_fisc" => $nombreFiscal,
                ":email" => $email,
                ":direcc" => $direccion,
                ":localidad" => $localidad,
                ":provincia" => $provincia,
                ":plazas" => $numPlazas,
                ":telefono" => $telefono,
                ":contacto" => $contacto,
                
            ];

            if(isset($_POST['modificar'])){
                $sql = "UPDATE empresa SET cif = :cif, nombre_fiscal = :nom_fisc, email = :email, direccion = :direcc, localidad = :localidad, provincia = :provincia, numero_plazas = :plazas, telefono = :telefono, persona_contacto = :contacto WHERE nombre = :nombre";
                $stmt = $pdo->prepare($sql);
                $empresa = $stmt->execute($datos);
                echo "Empresa modificada con éxito";
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
