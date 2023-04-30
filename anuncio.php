

    
<?php 

require 'includes/funciones.php';


incluirTemplate('header');


//importar la base de datos la conexion 
require 'includes/config/database.php';

//Validar que sea un id valido 
$id= $_GET['id']; //obtener el id de la url


$id= filter_var($id,FILTER_VALIDATE_INT); //valida si es entero 

$db= conectarDB();
//consultar
$query= "SELECT * FROM propiedades WHERE id={$id}"; // limite de 3 cards de las propiedades 
//obtener los resultados 
$resultado =mysqli_query($db, $query);
if(!$resultado->num_rows){ // sintaxis para buscar algo en un objeto con PHP 
    header('Location: /'); //redirecciona a la pagna principal si el id no corresponde a los existentes 
}
?>


    <main class="contenedor seccion contenido-centrado">
<?php while ($propiedad = mysqli_fetch_assoc($resultado)):
        
        ?>
        <h1><?php echo $propiedad['titulo']; ?></h1>

     
            <img loading="lazy" src="/imagenes/<?php echo $propiedad['imagen']; ?>" alt="imagen de la propiedad">
        

        <div class="resumen-propiedad">
            <p class="precio">$<?php echo $propiedad['precio']; ?></p>
            <ul class="iconos-caracteristicas">
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                    <p><?php echo $propiedad['wc']; ?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                    <p><?php echo $propiedad['estacionamiento']; ?></p>
                </li>
                <li>
                    <img class="icono"  loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                    <p><?php echo $propiedad['habitaciones']; ?></p>
                </li>
            </ul>

             <p>
            <?php echo $propiedad['descripcion']; ?>
            </p>

            
        </div>
        <?php endwhile; ?>
    </main>

    <?php 
mysqli_close($db);
incluirTemplate('footer');
?>

