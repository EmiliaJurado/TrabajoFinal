<?php
// Inicializamos sesion
session_start();

//Compruebe si el usuario ha iniciado sesión, si no, rediríjalo a la página de inicio de sesión
# cuando el usuario envía su nombre de usuario y contraseña a través del formulario de
# inicio de sesión, normalmente comprobará su nombre de usuario y contraseña consultando
# una base de datos que contenga información de nombre de usuario y contraseña, como MySQL.
#Si la base de datos devuelve una coincidencia, puede establecer una variable de sesión para contener ese hecho. 

#Comprobar si una variable esta definida--- Variables de sesion 
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: index.php");
  exit;
}

//Incluir archivo de configuración
require_once "config.php";

// Procesamiento de datos del formulario cuando se envía el formulario

$username = $password = "";
$username_err = $password_err = "";


// Procesamiento de datos del formulario cuando se envía el formulario
if($_SERVER["REQUEST_METHOD"] == "POST"){

     //Compruebe si el nombre de usuario está vacío
#empty — Determina si una variable está vacía
#trim —  funcion--Eliminará  caractere
#POST- variable php denominada, almacenamos la información del campo.
    if(empty(trim($_POST["username"]))){
        $username_err = "Por favor ingrese su usuario.";
    } else{
        $username = trim($_POST["username"]);
    }

    // Compruebe si la contraseña está vacía
    if(empty(trim($_POST["password"]))){
        $password_err = "Por favor ingrese su contraseña.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validacion de credenciales
    if(empty($username_err) && empty($password_err)){
    //Prepare una declaración selecta,--secreo el query desde una cadena simple
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
    #Preparo cadena simple con el metodo prepare para una sentencia SQL para su ejecución y recibido parametros seguros
        if($stmt = mysqli_prepare($link, $sql)){
    //Vincular variables a la declaración preparada como parámetros
            # stmt--> Consulta preparada
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Establecer parámetros
            $param_username = $username;

            // Intente ejecutar la declaración preparada
            if(mysqli_stmt_execute($stmt)){
            // Transfiere un conjunto de resultados de la sentencia preparada
                mysqli_stmt_store_result($stmt);

                #script de inicio de sesión -->Verifique si existe el nombre de usuario, si es así, verifique la contraseña
                if(mysqli_stmt_num_rows($stmt) == 1){
                    // Vincular variables de resultado
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    #btienemos los resultados de una sentencia preparadas en las variables vinculadas
                    if(mysqli_stmt_fetch($stmt)){
                    #Comprueba que la contraseña coincida con un hash
                        if(password_verify($password, $hashed_password)){
                            // La contraseña es correcta, así que inicie una nueva sesión
                            session_start();

                            // Almacenar datos en variables de sesión
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            // Redirigir a la usuario a la página de bienvenida
                            header("location: index.php");
                        } else{
                            // Muestra un mensaje de error si la contraseña no es válida
                            $password_err = "La contraseña que has ingresado no es válida.";
                        }
                    }
                } else{
                    //muestra un mensaje de error si el nombre de usuario no existe
                    $username_err = "No existe cuenta registrada con ese nombre de usuario.";
                }
            } else{
                echo "Algo salió mal, por favor vuelve a intentarlo.";
            }
        }

        #Cierra una sentencia preparada
        mysqli_stmt_close($stmt);
    }

    #Cierra una conexión previamente abierta a una base de datos
    mysqli_close($link);
}
?>
<!--HTML-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
     <!-- dependencias visuales -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body style="background-color:cadetblue">
<img src="archivo.jpg" class="img-fluid" alt="Responsive image" width="1348" height="400">
<br>
<br> <!--Boostrap Elementos compuestos -->
<div class="container mt-3">
  <div class="row mt-3">
    <div class="col hvr-float">
    <div class="text-center"> <!--Imagenes al gusto-->
    <img src="computadora.png"  class="rounded" alt="..." width="110" height="110">
    <img src="carpetas.png" class="rounded float-left" alt="..." width="110" height="110">
    <img src="policial.png" class="rounded float-right" alt="..." width="110" height="110">
</div>
  </div>
  <div class="row">
    <div class="col">
    </div>
    </div>
<div class="row mt-3">
    <div class="col-sm-4"></div>
    <div class="col-sm-4">
    <div class="wrapper">
    <div id="rectangulo" class="display-3 text-center">
        <h1> <p style = "font-family:courier,arial,helvética;">Manejador de Archivos</p></h1>
    </div>
    <h5><p style = "font-family:courier,arial,helvética;">Por favor, complete sus credenciales para iniciar sesión.</p></h5>
        <div id="rectangulo" class="display-3 text-center">
        <p style = "font-family:courier,arial,helvética;">
        <label>Usuario:admin</label> <label>Contraseña:1234abcd..</label></p>
    </div>
        <!-- Cuando se envía el formulario, los datos del formulario se envían con method = "post". Y seguridad-->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <!--agregamos un pequeño script después de cada campo obligatorio, que genera el mensaje de error correcto si es necesario 
        (es decir, si el usuario intenta enviar el formulario sin completar los campos obligatorios):-->
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Usuario</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div> <!--agregamos un pequeño script después de cada campo obligatorio, que genera el mensaje de error correcto si es necesario 
        (es decir, si el usuario intenta enviar el formulario sin completar los campos obligatorios):-->
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Contraseña</label>
                                            <!--Evalua passwor de ususario como un valor en la entrada.-->
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Ingresar">
            </div>

        </form>
    </div>
    </div>
    </div>
</div>
    </div>
    <img src="archivo.jpg" class="img-fluid" alt="Responsive image" width="1348" height="400">
</body>
</html>