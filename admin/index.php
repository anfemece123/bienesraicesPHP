<?php 
    require '../includes/funciones.php';
$auth= estadoAutenticado();

    if(!$auth){
        header('Location: /'); //hacer que la url sea privada y no se pueda ingresar si no esta autenticado
    }


    //importar la conexion
    require '../includes/config/database.php';
    $db=  conectarDB();
    //Escribir el query
    $query = "SELECT * FROM propiedades";

    //consultar la DB 
    $resultadoConsulta= mysqli_query($db, $query);


    //muestra mensaje condicional
    $resultado= $_GET['resultado'] ?? null; //busca el valor y si no existe le asigna null

    if($_SERVER['REQUEST_METHOD']=== 'POST'){ //el post no va a existir hasta que no se mande el request metod
        $id=$_POST['id'];
        // $id=filter_var($id, FILTER_VALIDATE_INT); //FILTRAR para validar 




        if($id){

            //Eliminar el archivo

            $query= "SELECT imagen FROM propiedades WHERE id= {$id}";

            $resultado= mysqli_query($db,$query); 

            $propiedad= mysqli_fetch_assoc($resultado);

           unlink('../imagenes/'.$propiedad['imagen']);

            //Eliminar la propiedad
            $query= "DELETE FROM propiedades WHERE id= {$id}";
         
            $resultado= mysqli_query($db, $query);
            if($resultado){
                header('location: /admin?resultado=3');
            }
        }
    }


    //incluye un template

    incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Administrador de bienes raices</h1>

        <?php if( intval($resultado) ===1):?>
            <p class="alerta exito"> Anuncio Creado correctamente</p>

            <?php elseif(intval($resultado) ===2):?>
                <p class="alerta exito"> Anuncio Actualizado Correctamente</p>
                <?php elseif(intval($resultado) ===3):?>
                    <p class="alerta exito"> Anuncio Eliminado Correctamente</p>
                    
        <?php endif ?>
        <a href="/admin/propiedades/crear.php" class="boton-verde">Nueva propiedad</a>

        <table class="tabla">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Imagen</th>
                    <th>Preio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody> <!-- mOSTRAR LOS RESULTADOS -->

            <?php while($propiedad = mysqli_fetch_assoc($resultadoConsulta)): ?>
                <tr>
                    <td><?php echo $propiedad['id'] ?></td>
                    <td><?php echo $propiedad['titulo'] ?></td>
                    <td><img src="/imagenes/<?php echo $propiedad['imagen']; ?>" class="imagen-tabla" /></td>
                    <td>$<?php echo $propiedad['precio'] ?></td>
                    <td>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $propiedad['id']; ?>"> <!-- input hidden no se puede ver para enviar atributos de forma oculta-->
                            <input type="submit" class="boton-rojo-block" value="Eliminar" >
                        </form>
                        <a href="admin/propiedades/actualizar.php?id=<?php echo $propiedad['id'];?>" class="boton-amarillo-block">Actualizar</a>  <!-- se envia el id por el enlace para tomarlo -->
                    </td>
                    <?php endwhile; ?>
                </tr>
            </tbody>
        </table>
    </main>

    <?php 
    //CERRAR LA CONEXION 
    mysqli_close($db);
    incluirTemplate('footer');
    ?>

  