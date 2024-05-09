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
            <li><a href="">Inicio  </a></li>
            <li><a href="">Alumnos</a></li>
            <li><a href="">Usuario </a></li>
        </ul>
        <div id="logo">
            <img src="img/OIG2-removebg-preview.png" alt="">
            
        </div>
    </header>
    <section id="cuerpoPrincipal">
        <article id="usuario">
            <article>
                <h2>Informacion de usuario</h2>
                <p>Nombre: X</p>
                <p>Email: x@y.com</p>
                <p>Iniciado como: Tutor
                </p>
            </article>

            <article id="altaUsuarios">
                <h2>Alta usuarios</h2>
            </article>
        </article>
            
        <article id="tabla">
            <?php

            $buscar=$_POST['buscar'] ?? null;
            $resultados_pag = 10;
            $page = $_POST['pagina'] ?? 1;
            $sig_pag = $_POST['sig_pag'] ?? null;
            $ant_pag = $_POST['ant_pag'] ?? null;
            $ir = $_POST['ir'] ?? null;


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

            <h1>Busqueda de alumnos</h1>
            <form action="dashboardTutor.php" method="post">
                    <input type="text" name="buscar" placeholder='Busqueda por nombre'>
                    <input type="submit">
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
                </tr>

            <?php
                $datos = [];

                //query para recoger el numero de datos
                $filas_totales = "SELECT count(*) FROM alumno";
                $stmt = $pdo->prepare($filas_totales);
                $stmt->execute($datos);
                $datos_totales=$stmt->fetch();

                //parsear el array del resultado de la query a entero
                $cadena = implode("", $datos_totales);
                $total_filas = intval($cadena);
                

                //paginas totales a paginar
                $paginas_totales = ceil($total_filas / $resultados_pag);
                $num_totalPag = (int)$paginas_totales;

                //si pulsa el boton ">" pagina +1
                if(isset($_POST['sig_pag'])){
                    $page ++;
                }if($page>$paginas_totales){
                    $page=$paginas_totales;
                    echo "No existen más datos sobre la busqueda relacionada";
                }

                if(isset($ir) and $page>$num_totalPag){
                    $page==$num_totalPag;
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
                $mostrar_pag = ($num_pag - 1) * $resultados_pag;
                
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
                            echo "<tr>"."<td>".$row['email']."</td>"."<td>".$row['nia']."</td>"."<td>".$row['telefono']."</td>"."<td>".$row['nombre']."</td>"."<td>".$row['cv_file']."</td>"."<td>".$row['passwrd']."</td>"."</tr>";
                        }
                        if($row['email']=null){
                            echo"No hay datos relacionados.";
                        }
                        
                //}

            }catch(PDOException $e){
                echo "Error de conexion con la BD";
            }
            ?>
            </table>
            <form action="dashboardTutor.php" method="post">
                <input type="submit" name="ant_pag" value="<">
                <input type="number" name="pagina" <?php echo "value=".$page;?>>
                <input type="submit" name="ir" value="IR">
                <input type="submit" name="sig_pag" value=">">   
            </form>
        </article>
    </section>
</body>
</html>     