<?php 
 
require 'includes/config/database.php'; 
$db = conectarDB();



//autenticar el usuario 

$errores= [];

if($_SERVER['REQUEST_METHOD']==='POST'){ //se ejecuta cuando enviamos el formulario

    // echo '<pre>';
    // var_dump($_POST);
    // echo '</pre>';

    $email = mysqli_real_escape_string($db, filter_var($_POST['email'],FILTER_VALIDATE_EMAIL));//   (mysqli_real_escape_string)=> interactua directamente con la base de datos  //?  (filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))valida que sea un email
    $password = mysqli_real_escape_string($db, $_POST['password']);

    echo '<pre>';
    var_dump($password);
    echo '</pre>';
    

    if(!$email){
        $errores[]= "El email es obligatorio o no es valido ";
    }

    if(!$password){
        $errores[]= "el password es obligatorio";
    }
    if(empty($errores)){
        //Revisar si un usuario existe 
        $query= "SELECT * FROM usuarios WHERE email= '{$email}' ";
        $resultado= mysqli_query($db, $query); 

        if($resultado -> num_rows){
            //revisar si el password es correcto
            
            $usuario = mysqli_fetch_assoc($resultado);
            var_dump($usuario);

            //verificar si el password es correcto o no 

            $auth= password_verify($password, $usuario['password'] );
            echo '<pre>';
            var_dump($auth);
            echo '</pre>';

            if($auth){
                //el usuario esta autenticado
                session_start();

                //llenar el arreglo de la sesion SESSION es un arreglo para llenar  SON COMO ESTADOS GLOBLALES  las superglobales 

                $_SESSION['usuario']= $usuario['email'];
                $_SESSION['auth']= $auth;

                header('location:/admin');



            }else{
                $errores[]= 'el password es incorrecto';
            }

        }else{
            $errores[]="El usuario no existe";
        }
    }   

}
//incluye el header
require 'includes/funciones.php';

incluirTemplate('header');
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Iniciar Sesión</h1>

        <?php foreach($errores as $error):  ?>
            <div class="alerta error">
            <?php echo $error; ?> 
            </div>

        <?php endforeach;  ?>   
        <form  method="POST" class="formulario">
        <fieldset>
                <legend>Email y password</legend>

                <label for="email">E-mail</label>
                <input type="email" name="email"  placeholder="Tu Email" id="email" required> <!-- required para que no se pueda enviar vacio en el cliente y si aparezcan las validaciones internas  -->

                <label for="password">Password</label>
                <input type="password" name="password" placeholder="Tu password" id="password" required>

                <input type="submit" value="Iniciar sesion" class="boton boton-verde">
           
            </fieldset>
        </form>
    </main>

    <?php 

incluirTemplate('footer');
?>

  