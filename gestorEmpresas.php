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
    <title>Mis Empresas</title>
    <link rel="stylesheet" href="css/Template.css">

</head>
<body>
    <header>
        <h1>MediaGestCT</h1>
        <ul>
            <li><a href="dashboardTutor.php">Inicio</a></li>
            <li><a href="gestorAlumnos.php">Alumnos</a></li>
            <form action="dashboardTutor.php" method="post">
                <li><input class="button" type="submit" name="logout" value="Cerrar Sesión"></li>
            </form>
        </ul>
        <div id="logo">
            <img src="img/OIG2-removebg-preview.png" alt="">
        </div>
    </header> 

    <?php
            $buscar=$_POST['buscar'] ?? null;
            $resultadosPag = 10;
            $page = $_POST['pagina'] ?? 1;
            $sig_pag = $_POST['sig_pag'] ?? null;
            $ant_pag = $_POST['ant_pag'] ?? null;
            $ir = $_POST['ir'] ?? null;
            $id = $_GET['id'] ?? null;
            $userLog = $_GET['user'] ?? null;

            $nombre = $_POST['nombre'] ?? null;
            $cif = $_POST['cif'] ?? null;
            $nombreFiscal = $_POST['nombre_fiscal'] ?? null;
            $email = $_POST['email'] ?? null;
            $direccion = $_POST['direccion'] ?? null;
            $localidad = $_POST['localidad'] ?? null;
            $provincia = $_POST['provincia'] ?? null;
            $numPlaza = $_POST['plazas'] ?? null;
            $telefono = $_POST['telefono'] ?? null;
            $contacto = $_POST['contacto'] ?? null;


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
                <p>Iniciado como: Tutor</p>
            </article>
            <article>
            <form id="formularioAlta" action="gestorEmpresas.php" method="post">
                <h2 class="text">Alta Empresa</h2>
                    <input type="text" class="textbox" name="nombre" placeholder="Nombre" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]+" title="Ingrese solo letras" required>
                    <input type="text" class="textbox" name="cif" placeholder="CIF/NIF" pattern="^[A-W][0-9]{8}$" maxlength="9" required>
                    <input type="text" class="textbox" name="nombre_fiscal" placeholder="Nombre Fiscal" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ. ]+" title="Ingrese situación fiscal" required>
                    <input type="email" class="textbox" name="email" placeholder="Email" title="Tipo: @gmail.com" pattern=".+@gmail\.com" required>
                    <input type="text" class="textbox" name="direccion" placeholder="Dirección" title="Introdice C/ o Avnd/ _direccion_, _numero_" pattern="^(C\/|Avnd\/)\s.+,\s\d+$" required>
                    <input type="text" class="textbox" name="localidad" placeholder="Localidad" required>
                    <select class="textbox" name="provincia" required>
                        <option value="seleccionar">Seleccione provincia</option>
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
                    <input type="number" class="textbox" name="plazas" placeholder="Plazas disponibles" pattern="[0-9]*" maxlength="3">
                    <input type="text" class="textbox" name="telefono" placeholder="Nº Telefono" title="Formato junto 9 digitos" pattern="[0-9]*" minlength="9" maxlength="9" required>
                    <input type="text" class="textbox" name="contacto" placeholder="Contacto">
                    <input type="submit" class="button" name="alta" value="Registrar Empresa">
                    <input type="reset" class="button" value="Borrar datos">
            </form>

            <?php

                

                $datos=[
                    ":nombre"=>$nombre,
                    ":cif"=>$cif,
                    ":nombre_fiscal"=>$nombreFiscal,
                    ":email"=>$email,
                    ":direccion"=>$direccion,
                    ":localidad"=>$localidad,
                    ":provincia"=>$provincia,
                    ":num_plazas"=>$numPlaza,
                    ":telefono"=>$telefono,
                    ":per_contact"=>$contacto
                ];


                if(isset($_POST['alta'])){
                    $sql = "INSERT INTO empresa (nombre, cif, nombre_fiscal, email, direccion, localidad, provincia, numero_plazas, telefono, persona_contacto) VALUES (:nombre, :cif, :nombre_fiscal, :email, :direccion, :localidad, :provincia, :num_plazas, :telefono, :per_contact)";

                    $stmt = $pdo->prepare($sql);
                    $row = $stmt->execute($datos);
                    echo"Empresa registrada con éxito";
                }
            ?>

            </article>
        </article>

        <article id="tabla">
            <h1 class="text">Busqueda de empresas</h1>
            <form action="gestorEmpresas.php" method="post">
                    <input type="text" class="textbox" name="buscar" placeholder='Busqueda por nombre'>
                    <input class="button" type="submit" value="Buscar">
            </form>
                <table>
                    <tr>
                        <th class="tdmain">Nombre</th>
                        <th class="tdmain">CIF/NIF</th>
                        <th class="tdmain">Email</th>
                        <th class="tdmain">Localidad</th>
                        <th class="tdmain">Telefono</th>
                        <th class="tdmain">Nº Plazas</th>
                        <th class="tdmain">--</th>
                    </tr>
            </article>
            <article>

            <?php

                $datos = [];

                //query para recoger el numero de datos
                $totalFilas = "SELECT count(*) as filas_totales FROM empresa WHERE true";

                if(!empty($buscar)){
                    $totalFilas .= " and nombre like :buscar";
                    $datos [":buscar"]='%'.$buscar.'%';
                }

                $stmt = $pdo->prepare($totalFilas);
                $stmt->execute($datos);
                $totalDatos=$stmt->fetch();


                //capturar el numero de filas por el alias de la query
                $totalFilas = $totalDatos['filas_totales'];
                
                //paginas totales a paginar y edondear alto el resultado
                $totalPag = ceil($totalFilas / $resultadosPag);                


                //si pulsa el boton ">" pagina +1
                if(isset($_POST['sig_pag'])){
                    $page ++;
                }

                //si pulsa el boton "<" pagina -1
                if(isset($_POST['ant_pag'])){
                    $page--;
                }
                
                if($page>$totalPag){
                    $page=$totalPag;
                    echo "No existen más datos sobre la busqueda relacionada";
                }
                
                if($page<1){
                    $page=1;
                }

                //parsear el numero introducido a int
                $num_pag=intval($page);

                //mostrar pagina con: pagina-1 * resultados por pagina(=10)
                $mostrar_pag = ($num_pag - 1) * $resultadosPag;
                
                //inicializar a 0 datos
                $datos=[];

                //query para mostrar los datos
                $sql = "SELECT * FROM empresa Where true";

                if(!empty($buscar)){
                    $sql .= " and nombre like :buscar";
                    $datos [":buscar"]='%'.$buscar.'%';
                }
                
                $sql .= " limit 10 offset $mostrar_pag";
                
            
                //ejecutar consulta
                $stmt = $pdo->prepare($sql);
                $stmt->execute($datos);

                    //mientras i sea menor a los resultados(10) repetir
                    //for($i=1; $i<=$resultados_pag; $i++){
                        while($row=$stmt->fetch()){
                            echo "<tr>
                                    <td>".$row['nombre']."</td> 
                                    <td>".$row['cif']."</td>
                                    <td>".$row['email']."</td>
                                    <td>".$row['localidad']."</td>
                                    <td>".$row['telefono']."</td>
                                    <td>".$row['numero_plazas']."</td>
                                    <td>
                                        <form action='modificarEmpresas.php' method='post'>
                                            <input type='hidden' name='id' value=".$row['nombre'].">
                                            <input type='submit' class='button' value='Editar'>
                                        </form>
                                        <button class= button onclick=window.location='gestorEmpresas.php?id=".$row['nombre']."'>Eliminar</button>
                                    </td>
                                </tr>";
                        }
                        
                        if($row['nombre']=null){
                            echo"No hay datos relacionados.";
                        }

                        if(isset($_GET['id'])){
                            $sql = "DELETE FROM empresa WHERE nombre = '$id'";
                            print($id);
                            print($sql);
                            //$datos [":eliminar"]=$del;
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute($datos);
                            echo"Usuario eliminado con éxito";
                            echo '<script>window.location.href = "gestorEmpresas.php";</script>';
                        }
                        
                    //}

                }catch(PDOException $e){
                    echo $e->getMessage();
                }
            ?>
            </table>
            
            <?php

                    echo "<form id=formAlumnos action=gestorEmpresas.php method=post>";
                    if($page!=1){
                        echo"<input type=submit class=button name= ant_pag value='<'>";
                    }

                    echo"<input type=number  name=pagina value=$page>
                    <input type=submit class=button name=ir value=IR>";

                    if($page!=$totalPag){
                        echo"<input type=submit class=button name=sig_pag
                        value='>'>";
                    }
                    echo"</form>";

            ?>
        </article>
            </article>
            
    </section>
    <footer>
        <p>2024 Mediagest. Todos los derechos reservados.</p>
    </footer>

</body>
</html>