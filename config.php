<?php
//Credenciales de la base de datos. Suponiendo que está ejecutando MySQL
//servidor con configuración predeterminada (usuario 'root' sin contraseña) 
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'demo');
/// * Intento de conectarse a la base de datos MySQL * /
#  #Estoy construyendo un objeto que tiene los elentos necesarios para conectarme a la BD
                        # Equipo PC,    Usuario, Password, Nombre de la BD    
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
//
// Verifica la conexión
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>