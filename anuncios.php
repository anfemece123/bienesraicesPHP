
    
<?php 

require 'includes/funciones.php';

incluirTemplate('header');
?>

    <main class="contenedor seccion">

        <h2>Casas y Depas en Venta</h2>

        <?php  
      $limite=10; // se la pasa el limite de 3 al template anuncios para que solo se muetren 3 
      
      include 'includes/templates/anuncios.php' //anuncios que se encuentra en el tamplate 
      
      ?> 
     
    </main>

    <?php 

incluirTemplate('footer');
?>
