<?php
// Inicializa la sesion
session_start();

//Compruebe si el usuario ha iniciado sesión, si no, rediríjalo a
//la página de inicio de sesión 
#cuando el usuario envía su nombre de usuario y contraseña a través del formulario de inicio de sesión,
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Error</title>
    <!-- dependencias visuales -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 750px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper"> <!--Boostrap Elementos compuestos -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>Solicitud no válida</h1>
                    </div>
                    <div class="alert alert-danger fade in">
                        <p>Lo sentimos, has hecho una solicitud no válida. Por favor <a href="index.php" class="alert-link">regresa</a> e intenta de nuevo.</p>
                    </div>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>