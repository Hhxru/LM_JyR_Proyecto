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
    <title>Dashboard Alumno</title>
    <link rel="stylesheet" href="css/Template.css">
</head>
<body>
    <header>
        <h1>MediaGestCT</h1>
        <ul>
            <li><a href="dashboardAlumno.php">Inicio</a></li>
            <li><a href="preferencias.php">Mis Preferencias </a></li>
            <form action="dashboardAlumno.php" method="post">
                    <li><input type="submit" name="logout" value="Cerrar Sesión"></li>
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
            $idEmpresa = $_GET['id'] ?? null;
            $seleccion = $_POST['seleccion'] ?? null;
            $userlog = $_SESSION['email'] ?? null;

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
            <h1 class="text">Busqueda de empresas</h1>
            <form action="dashboardAlumno.php" method="post">
                    <input type="text" class="textbox" name="buscar" placeholder='Busqueda por nombre'>
                    <input class="button" type="submit" value="Buscar">
            </form>
            <p></p>
                <table>
                    <tr>
                    <th class="tdmain">Nombre Fiscal</th>
                    <th class="tdmain">Telefono</th>
                    <th class="tdmain">Email</th>
                    <th class="tdmain">Persona Contacto</th>
                    <th class="tdmain">Plazas</th>
                    <th class="tdmain">Localidad</th>
                    <th class="tdmain">--</th>
                    </tr>
        </article>
        <article>
                
            <?php
            $datos = [];
            //query para recoger el numero de datos
            $totalFilas = "SELECT count(*) as filas_totales FROM empresa";
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
            }if($page>$totalPag){
                $page=$totalPag;
                echo "No existen más datos sobre la busqueda relacionada";
            }

            if(isset($ir) and $page>$totalPag){
                $page=$totalPag;
            }if(isset($ir) and $page<1){
                $page=1;
            }

            //si pulsa el boton "<" pagina -1
            if(isset($_POST['ant_pag'])){
                $page--;
            }if($page<1){
                $page=1;
            }

            //parsear el numero introducido a int
            $num_pag=intval($page);

            //mostrar pagina con: pagina-1 * resultados por pagina(=10)
            $mostrar_pag = ($num_pag - 1) * $resultadosPag;
            
            //query para mostrar los datos
            $sql = "SELECT * FROM empresa Where true";

            if(!empty($buscar)){
                $sql .= " and nombre_fiscal like :buscar";
                $datos [":buscar"]='%'.$buscar.'%';
            }else{
                $sql .= " limit 10 offset $mostrar_pag";
            }
            
        
            //ejecutar consulta
            $stmt = $pdo->prepare($sql);
            $stmt->execute($datos);

                //mientras i sea menor a los resultados(10) repetir
                //for($i=1; $i<=$resultados_pag; $i++){
                    while($row=$stmt->fetch()){
                        echo "<tr>
                            <td>".$row['nombre_fiscal']."</td> 
                            <td>".$row['telefono']."</td>
                            <td>".$row['email']."</td>
                            <td>".$row['persona_contacto']."</td>
                            <td>".$row['numero_plazas']."</td>
                            <td>".$row['localidad']."</td>
                            <td>
                                <button class='button' name='seleccion' onclick=window.location='dashboardAlumno.php?id=".$row['nombre']."'>Añadir</button>
                            </td>
                        </tr>";
                    }

                    if($row['email']=null){
                        echo"No hay datos relacionados.";
                    }


                    //realizar una prioridad de usuario
                    if(isset($_GET['id'])){
                        
                        //consulta para comprobar que no hay prioridades entre empresa y Usuario
                        //$datos=[":id_user"=>$_SESSION['email']];
                        $sql = "SELECT * FROM prioridades WHERE alumno_id = '$userlog' and empresa_id = '$idEmpresa'";
                        
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute($datos);
                        
                        if($row=$stmt->fetch()){
                            echo"Esta empresa ya ha sido seleccionada anteriormente";
                        }else{
                            //al no ser así capturaremos la ultima id y orden
                            $sql = "SELECT MAX(orden) as orden, (SELECT MAX(id) FROM prioridades) as id FROM prioridades WHERE alumno_id='$userlog'"; 
                            
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute($datos);
                            $prioridad = $stmt->fetch();

                            $idPrioridad=$prioridad['id'];
                            if($idPrioridad==null){
                                $idPrioridad=0;
                            }
                            $idPrioridad=$idPrioridad+1;

                            $orden = $prioridad['orden'];
                            if($orden==null){
                                $orden=0;
                            }
                            $orden = $orden + 1;

                            //query pra crear una prioridad
                            $sql = "Insert Into prioridades (id, alumno_id, empresa_id, anyo, periodo, orden) values ('$idPrioridad', '$userlog', '$idEmpresa', '2024', 'marzo', '$orden')";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute($datos);
                            
                            echo"Empresa añadida a favoritos";
                        }   
                    }

                    
                //}

            }catch(PDOException $e){
                echo $e->getMessage();
            }
        ?>
        
                </table>
                <form id="formAlumnos" action="dashboardAlumno.php" method="post">
                    <input type="submit" class="button" name="ant_pag" value="<">
                    <input type="number"  name="pagina" <?php echo "value=".$page;?>>
                    <input type="submit" class="button" name="ir" value="IR">
                    <input type="submit" class="button" name="sig_pag" value=">">
                </form>
            </article>
        </article>
    </section>
    <footer>
        <p>2024 Mediagest. Todos los derechos reservados.</p>
    </footer>


</body>
</html>     
