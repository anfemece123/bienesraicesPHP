<?php  
// importar la conexion
require 'includes/config/database.php';
$db= conectarDB();


//crear un email y password

$email= "correo@correo.com";
$password= "123456";

//hashear un password 
//todos los password hasehados tienes una extencion de 60 en su base de datos CHAR(60)

$passwordHash= password_hash($password, PASSWORD_BCRYPT);

//query para crear el usuario

$query="INSERT INTO usuarios(email, password) VALUES ('{$email}', '{$passwordHash}')"; 



//agregarlo a la base de datos
mysqli_query($db, $query);

?>