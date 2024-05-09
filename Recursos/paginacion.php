<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php

    $buscar=$_POST['buscar'] ?? null;
    $resultados_pag = 10;
    $page = $_POST['pagina'] ?? 1;
    $sig_pag = $_POST['sig_pag'] ?? null;
    $ant_pag = $_POST['ant_pag'] ?? null;


    $host='localhost';
    $dbname='universidad';
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
    <form action="paginacion.php" method="post">
            <input type="text" name="buscar">
            <input type="submit">
    </form>

    <table border="2">
        <tr>
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

        $datos = [];

        //query para recoger el numero de datos
        $filas_totales = "SELECT count(*) FROM alumno";
        $stmt = $pdo->prepare($filas_totales);
        $stmt->execute($datos);
        $datos_totales=$stmt->fetch();

        //parsear el array del resultado de la query
        $cadena = implode("", $datos_totales);
        $total_filas = intval($cadena);
        

        //paginas totales a paginar
        $paginas_totales = ceil($total_filas / $resultados_pag);

        //si pulsa el boton ">" pagina +1
        if(isset($_POST['sig_pag'])){
            $page ++;
        }

        //si pulsa el boton "<" pagina -1
        if(isset($_POST['ant_pag'])){
            $page--;
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
                    echo "<tr>"."<td>".$row['DNI']."</td>"."<td>".$row['APELLIDO_1']."</td>"."<td>".$row['APELLIDO_2']."</td>"."<td>".$row['NOMBRE']."</td>"."<td>".$row['DIRECCION']."</td>"."<td>".$row['LOCALIDAD']."</td>"."<td>".$row['PROVINCIA']."</td>"."<td>".$row['FECHA_NACIMIENTO']."</td>"."</tr>";
                }
        //}

        print($sql);
    }catch(PDOException $e){
        echo "Error de conexion con la DB";
    }
?>
    </table>
    <form action="paginacion.php" method="post">
        <input type="submit"  value="<<">
        <input type="submit" name="ant_pag" value="<">
        <input type="number" name="pagina" <?php echo "value=".$page;?>>
        <input type="submit" name="sig_pag" value=">">
        <input type="submit" value=">>">
    </form>
</body>
</html>