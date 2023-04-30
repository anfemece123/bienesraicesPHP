<?php 

if(isset($_SESSION)){// isset siginica que si esta definida o existe 
  session_start(); //se debe iniciar la sesion y para que aparezca... para traese informacion del usuario de la sesion que se almacena se debe colcoar este codigo
  
} 
 $auth = $_SESSION['auth'] ?? null;  // ?? signica si no existe solo se coloque como null

 var_dump($auth);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienes Raices</title>
    <link rel="stylesheet" href="/build/css/app.css">
</head>
<body>

<header class="header <?php echo $inicio ? 'inicio' : ''; ?>">
      <div class="contenedor contenido-header">
        <div class="barra">
          <a href="/">
            <img src="../../build/img/logo.svg" alt="Logotipo de Bienes Raices" />
          </a>

          <div class="mobile-menu">
            <img class="logo" src="/build/img/barras.svg" alt="icono menu responsive" />
          </div>

          <div class="derecha">
            <img class="dark-mode-boton" src="/build/img/dark-mode.svg" />

            <nav class="navegacion">
              <a href="nosotros.php">Nosotros</a>
              <a href="anuncios.php">Anuncios</a>
              <a href="blog.php">Blog</a>
              <a href="contacto.php">Contacto</a>
              <?php if($auth): ?>

                  <a href="cerrar-sesion.php"> Cerrar sesion </a>

              <?php endif ?>  

            </nav>
          </div>
        </div>
        <!--.barra-->
        <?php if($inicio){ ?>
        '<h1>Venta de Casas y Departamentos Exclusivos de Lujo</h1>';
       <?php } ?>
 
      </div>
    </header>