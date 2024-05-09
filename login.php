<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <header>
        <h1>MediaGestCT</h1>
    </header>
    <section class="login">
        <form class="loginFormulario">
            <h2>
                <img src="img/OIG2-removebg-preview.png" alt="">
            </h2>
            <article class="formularios">
                <label for="email">
                    <input type="text" id="email" placeholder="Correo electrónico:" name="email" required>
                </label>
            </article>
            <article class="formularios">
                <label for="password">
                    <input type="password" id="password" placeholder="Contraseña:" name="password" required>
                </label>
            </article>
            <button type="submit">Iniciar sesión</button>
        </form>
    </section>

    <?php

$host='localhost';
$dbname='fct';
$user='root';
$pass='';

$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;

try {
    # MySQL con PDO_MYSQL
    # Para que la conexion al mysql utilice las collation UTF-8 añadir charset=utf8 al string de la conexion.
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    
    # Para que genere excepciones a la hora de reportar errores.
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

    $sql = "SELECT email, passwrd FROM alumno where email=\"$email\" and passwrd=\"$password\"";
    $datos=[];
    echo $sql;

    $stmt = $pdo->prepare($sql);
    $stmt->execute($datos);

    if($result = $stmt->fetch()){
        echo"Usuario registrado correctamente";
        echo $result['email'].$result['passwrd'];
    }else{
        echo "Usuario no registrado";
    }
    

}catch(PDOException $e){
    echo $e->getMessage();
}
?>
</body>
</html>
