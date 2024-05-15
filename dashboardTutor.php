<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Tutor</title>
    <link rel="stylesheet" href="css/dashboardTutor.css">
</head>
<body>
    <header>
        <ul>
            <li><a href="">Alumnos</a></li>
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
                <h2>Informacion de usuario</h2>
                <p>Nombre: <?php  echo"$userLog"?></p>
                <p>Email: x@y.com</p>
                <p>Iniciado como: Tutor</p>
            </article>

            <article id="altaUsuarios">
                    <form id="formularioAlta" action="dashboardTutor.php" method="post">
                        <h2>Alta usuarios</h2>
                        <input type="email" name="email" placeholder="Email" pattern=".+@gmail\.com" required>
                        <input type="text" name="nia" placeholder="NIA" pattern="[0-9]*" minlength="8" maxlength="8" required> 
                        <input type="text" name="telefono" placeholder="Nº Telefono" pattern="[0-9]*" minlength="9" maxlength="9" required>
                        <input type="text" name="nombre" placeholder="Nombre" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]+" title="Ingrese solo letras" required>
                        <input type="password" name="contrasena" placeholder="Contraseña" minlength="4" required>
                        <input type="submit" name="alta" value="Registrar alumno">
                        <input type="reset" value="Borrar datos">
                    </form>

                <?php

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

                        if(isset($_POST['alta'])){
                            echo"Usuario registrado con éxito";
                        }else{
                            echo"Error en el registro. No se han podido registrar los datos.";
                        }
                    }catch(PDOException $e){
                        echo $e->getMessage();
                    }
                ?>

            </article> 
        </article>       

        <article id="tabla">
            <h1>Busqueda de alumnos</h1>
            <form action="dashboardTutor.php" method="post">
                    <input type="text" id="buscar" name="buscar" placeholder='Busqueda por nombre'>
                    <input id="buscar" type="submit">
            </form>
            <p></p>
            <table border="2">
                <tr>
                <td class="tdmain">Email</td>
                <td class="tdmain">NIA</td>
                <td class="tdmain">Telefono</td>
                <td class="tdmain">Nombre</td>
                <td class="tdmain">CV_FILE</td>
                <td class="tdmain">Contraseña</td>
                <td class="tdmain">--</td>
                </tr>

        <?php
            $datos = [];
            //query para recoger el numero de datos
            $totalFilas = "SELECT count(*) as filas_totales FROM alumno";
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
            $sql = "SELECT * FROM alumno Where true";

            if(!empty($buscar)){
                $sql .= " and nombre = :buscar";
                $datos [":buscar"]=$buscar;
            }else{
                $sql .= " limit 10 offset $mostrar_pag";
            }
            
        
            //ejecutar consulta
            $stmt = $pdo->prepare($sql);
            $stmt->execute($datos);

                //mientras i sea menor a los resultados(10) repetir
                //for($i=1; $i<=$resultados_pag; $i++){
                    while($row=$stmt->fetch()){
                        echo "<tr>"."<td>".$row['email']."</td>"."<td>".$row['nia']."</td>"."<td>".$row['telefono']."</td>"."<td>".$row['nombre']."</td>"."<td>".$row['cv_file']."</td>"."<td>".$row['passwrd']."</td>"."<td>"."<a href='modificarAlu.php?id=".$row['email']."'>Editar</a>"."<a href='dashboardTutor.php?id=".$row['email']."'>Eliminar</a>".
                        "</td>"."</tr>";
                    }
                    if($row['email']=null){
                        echo"No hay datos relacionados.";
                    }

                    if(isset($_GET['id'])){
                        $sql = "DELETE FROM alumno WHERE email = \"$id\"";
                        print($id);
                        print($sql);
                        //$datos [":eliminar"]=$del;
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute($datos);
                        echo"Usuario eliminado con éxito";
                        echo '<script>window.location.href = "dashboardTutor.php";</script>';
                    }
                    
                //}

            }catch(PDOException $e){
                echo "Error de conexion con la BD";
            }
        ?>
        
            </table>
            <form id="formAlumnos" action="dashboardTutor.php" method="post">
                <input type="submit" name="ant_pag" value="<">
                <input type="number" name="pagina" <?php echo "value=".$page;?>>
                <input type="submit" name="ir" value="IR">
                <input type="submit" name="sig_pag" value=">">
            </form>
        </article>
    </section>
</body>
</html>     
