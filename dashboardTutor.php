<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/Template.css">
</head>
<body>
    <header>
            <h1>MediaGestCT</h1>
            <ul>
                <li><a href="gestorAlumnos.php">Alumnos</a></li>
                <li><a href="gestorEmpresas.php">Empresas</a></li>
                <li><a href="">Usuario </a></li>
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

            //variables de altas
            $alta = $_POST['alta'] ?? null;
            $email = $_POST['email'] ?? "";
            $nia = $_POST['nia'] ?? null;
            $tel = $_POST['telefono'] ?? null;
            $nombre = $_POST['nombre'] ?? "";
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
        ?>

        <section id="cuerpoPrincipal">
            <article id="usuario">
                <article>
                    
                </article>
                <article id="desplegable">
                    <button id="usuarioBoton">
                         <p>Nombre: <?php  echo"$userLog"?></p>
                    </button>
                    <div id="desplegableContenido">
                    <h2 class="text">Informacion de usuario</h2>
                        <p>Nombre: <?php  echo"$userLog"?></p>
                        <p>Email: x@y.com</p>
                        <p>Iniciado como: Tutor</p>
                    </div>
                </article>
        
            </article>   
            
            <article id="tabla">
                <h1 class="text">Busqueda de alumnos</h1>
                <form action="dashboardTutor.php" method="post">
                        <input type="text" class="textbox" name="buscar" placeholder='Busqueda por nombre'>
                        <input class="button" type="submit" value="Buscar">
                </form>
                <table>
                    <tr>
                    <th class="tdmain">Email</th>
                    <th class="tdmain">Empresa</th>
                    <th class="tdmain">Fecha Fin</th>
                    <th class="tdmain">Fecha Confirmacion</th>
                    <th class="tdmain">--</th>
                    </tr>

                    <?php

                        $datos = [];

                        //query para recoger el numero de datos
                        $totalFilas = "SELECT count(*) as filas_totales FROM alumno WHERE true";

                        if(!empty($buscar)){
                            $totalFilas .= " and nombre = :buscar";
                            $datos [":buscar"]=$buscar;
                        }

                        $stmt = $pdo->prepare($totalFilas);
                        $stmt->execute($datos);
                        $totalDatos=$stmt->fetch();


                        //capturar el numero de filas por el alias de la query
                        $totalFilas = $totalDatos['filas_totales'];
                        
                        //paginas totales a paginar y redondear alto el resultado
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
                        $sql = "SELECT a.email, e.nombre, p.fecha_fin, p.fecha_confirmacion FROM alumno a LEFT JOIN practica p ON a.email=p.alumno_id LEFT JOIN empresa e ON e.nombre=p.empresa_id WHERE true";

                        if(!empty($buscar)){
                            $sql .= " and nombre = :buscar";
                            $datos [":buscar"]=$buscar;
                        }
                        
                        $sql .= " limit 10 offset $mostrar_pag";
                        
                    
                        //ejecutar consulta
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute($datos);

                            //mientras i sea menor a los resultados(10) repetir
                            //for($i=1; $i<=$resultados_pag; $i++){


                        while($row=$stmt->fetch()){

                            $buscEmpresa = "<button class=button onclick=window.location='modificarAlumno.php?id=".$row['email']."'>Buscar Empresa</button>";

                            $gestEmpresa = "<button class=button onclick=window.location='modificarAlumno.php?id=".$row['email']."'>Gestionar Practica</button>";

                            echo"<tr>
                                <td>".$row['email']."</td>
                                <td>".$row['nombre'];
                                if($row['nombre']==null){echo"<strong>Sin empresa</strong>";}echo"</td>
                                <td>".$row['fecha_fin']."</td>
                                <td>".$row['fecha_confirmacion']."</td>
                                <td>";
                                        if($row['nombre']==null){print($buscEmpresa);}else{echo"<button class=button0>Buscar Empresa</button>";}
                                        
                                        if($row['nombre']!=null){print($gestEmpresa);}else{echo"<button class=button0>Gestionar Empresa</button>";}
                                        
                                "</td>
                            </tr>";
                        }
                                
                        if($row['email']=null){
                            echo"No hay datos relacionados."; "vee";
                        }       
                            //}
                    ?>
                </table>

                <?php

                    echo "<form id=formAlumnos action=dashboardTutor.php method=post>";
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

                    }catch(PDOException $e){
                        //echo "Error de conexion con la BD";
                        echo $e->getMessage();
                    }
                ?>
        </article>
    </section>
    <footer>
        <p>2024 Mediagest. Todos los derechos reservados.</p>
    </footer>

</body>
</html>
