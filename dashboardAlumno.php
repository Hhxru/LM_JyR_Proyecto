<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Alumno</title>
    <link rel="stylesheet" href="css/dashboardTutor.css">
</head>
<body>
    <header>
        <h1>MediaGestCT</h1>
        <ul>
            <li><a href="dashboardAlumno.php">Empresas</a></li>
            <li><a href="">Usuario </a></li>
        </ul>
        <div id="logo">
            <img src="img/OIG2-removebg-preview.png" alt="">
        </div>
    </header> 
    <?php
        $host='localhost';
        $dbname='fct';
        $user='root';
        $pass='';
    ?>
    <section id="cuerpoPrincipal">
        <article id="usuario">
            <article>
                <h2 class="text">Informacion de usuario</h2>
                <p>Nombre: <?php  echo"$userLog"?></p>
                <p>Email: x@y.com</p>
                <p>Iniciado como: Alumno</p>
            </article>
        </article>
        <article id="tabla">
            <h1 class="text">Busqueda de empresas</h1>
            <form action="dashboardTutor.php" method="post">
                    <input type="text" class="textbox" name="buscar" placeholder='Busqueda por nombre'>
                    <input class="button" type="submit" value="Buscar">
            </form>
            <p></p>
                <table>
                    <tr>
                    <th class="tdmain">Nombre</th>
                    <th class="tdmain">Telefono</th>
                    <th class="tdmain">Email</th>
                    <th class="tdmain">Web</th>
                    <th class="tdmain">--</th>
                    </tr>
                </table>
            </article>
    </section>
</body>
</html>     
