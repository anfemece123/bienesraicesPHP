<?php 

//proteger el url 
$auth= estadoAutenticado();

    if(!$auth){
        header('Location: /'); //hacer que la url sea privada y no se pueda ingresar si no esta autenticado
    }
//Base de datos 
require '../../includes/config/database.php';
$db=  conectarDB();

//consultar para obtener los vendedores 
$consulta = "SELECT * FROM vendedores";
$resultado= mysqli_query($db, $consulta);

//arreglo con mensajes de errores 

$errores= [];

$titulo= '';
$precio='';
$descripcion='';
$habitaciones='';
$estacionamiento='';
$wc='';
$vendedores_id='';


if($_SERVER["REQUEST_METHOD"]==='POST'){

    $numero= '1hola@GMAKS.COM/.FF';
    $numero2= 'SDA';


    //sanitizar 
    // $resultado = filter_var($numero, FILTER_SANITIZE_EMAIL); //filtra solo los numeros
    // $resultado= filter_var($numero2,FILTER_VALIDATE_INT);

    // var_dump($resultado);


    // exit;
    // echo '<pre>';
    // var_dump($_POST);
    // echo '</pre>';

    echo '<pre>';
    var_dump($_FILES);
    echo '</pre>';
   

    $titulo= mysqli_real_escape_string($db,$_POST['titulo'] );
    $precio=mysqli_real_escape_string($db,$_POST['precio'] ) ;
    $descripcion= mysqli_real_escape_string($db,$_POST['descripcion'] ) ;
    $habitaciones=mysqli_real_escape_string($db,$_POST['habitaciones'] ) ;
    $estacionamiento=mysqli_real_escape_string($db,$_POST['estacionamiento']) ;
    $wc=mysqli_real_escape_string($db,$_POST['wc'] ) ;
    $vendedores_id=mysqli_real_escape_string($db,$_POST['vendedores_id'] ) ;
    $creado= date('Y/m/d');


    //asignar files hacia una variable 

    $imagen = $_FILES['imagen'];

    

    if(!$titulo){
        $errores[]= "Debes añadir un titulo";
    }

    if(!$precio){
        $errores[]= "El precio es obligatorio";
    }

    if(strlen($descripcion)< 50){
        $errores[]= "La descripcion es obligatoria y debe tener al menos 50 caracteres";
    }

    if(!$habitaciones){
        $errores[]= "El numero de habitaciones es obligatorio";
    }

    if(!$wc){
        $errores[]= "El numero de baños es obligatorio";
    }

    if(!$estacionamiento){
        $errores[]= "El numero de lugares de estacionamiento es obligatorio";
    }

    if(!$vendedores_id){
        $errores[]= "Elige un vendedor";
    }

    if(!$imagen['name'] || $imagen['error']){
        $errores[]= "La imagen es obligatoria"; 
    }

    //validar por tamaño(1mb maximo)
    $medida= 1000*1000; // convertir de bts a kbs

    if($imagen['size']> $medida){
        $errores[]= "La imagen es muy pesada";
    }


    // echo '<pre>';
    // var_dump($errores);
    // echo '</pre>';

   


    //revisar que el arreglo de errores este vacio 

    if(empty($errores)){ //empty para ver si el arreglo esta vacio

        /** SUBIDA DE ARCHIVOS */
        //Crear una carpeta
        $carpetaImagenes= '../../imagenes/';

        if(!is_dir($carpetaImagenes)){ //si no existe la crea

            mkdir($carpetaImagenes);
        }

        //generar un nombre unico

        $nombreImagen= md5(uniqid(rand(), true)).".jpg"; //md5=>  genera un hash aleatorio  ||  uniqid=> genera un id unico 


        //subir imagen 

        move_uploaded_file($imagen['tmp_name'],$carpetaImagenes.$nombreImagen); 

        //insertar en la base de datos 
        $query= "INSERT INTO propiedades (titulo,precio,imagen, descripcion, habitaciones, estacionamiento, wc,creado, vendedores_id) VALUES ('$titulo', '$precio', '$nombreImagen', '$descripcion', '$habitaciones', '$estacionamiento', '$wc', '$creado', '$vendedores_id')";
        // echo $query;
    
        $resultado= mysqli_query($db, $query);
    
        if($resultado){
           //redireccionar al usuario
           header('Location: /admin?resultado=1'); //query string en el enlace 
        }
    }
};


incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>crear</h1>
        <a href="/admin" class="boton boton-verde">volver</a>

        <?php  foreach($errores as $error):?>
            <div class="alerta error"> 
                
                <?php echo $error; ?>
            </div>
        <?php  endforeach?>

        <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">
            <fieldset>
                <legend> informacion general </legend>


                <label for="titulo"> Titulo:</label>
                <input type="text" id="titulo" name="titulo" placeholder="titulo propiedad" value="<?php echo $titulo; ?>">

                <label for="precio"> Precio:</label>
                <input type="text" id="precio" name="precio" placeholder="precio propiedad" value="<?php echo $precio; ?>">

                <label for="imagen"> Imagen:</label>
                <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen"> 

                <label for="descricion">Descripcion:</label>
                <textarea id="descripcion" name="descripcion" ><?php echo $descripcion; ?></textarea>

            </fieldset>

            <fieldset>

            <legend>Informacion propiedad</legend>

            <label for="habitaciones"> Habitaciones: </label>
            <input type="number" id="habitaciones" placeholder="Ej:3" min="1" max="9" name="habitaciones"  value="<?php echo $habitaciones; ?>"> 
            
            <label for="wc"> Baños: </label>
            <input type="number" id="wc" placeholder="Ej:3" min="1" max="9" name="wc" value="<?php echo $wc; ?>"> 

            <label for="estacionamiento">Estacionamiento:</label>
            <input type="number" id="estacionamiento" placeholder="Ej:3" min="1" max="9" name="estacionamiento" value="<?php echo $estacionamiento; ?>"> 

            </fieldset>

            <fieldset>
                <legend>Vendedor</legend>
                
                <select name="vendedores_id" id="">

                    
                    <option value="">---seleccione---</option>
                   <?php while($vendedor= mysqli_fetch_assoc($resultado)): ?>
                            <option <?php echo $vendedores_id === $vendedor['id']? 'selected' : ''; ?> value="<?php echo $vendedor['id']; ?>"><?php echo $vendedor['nombre']." ".$vendedor['apellido']; ?></option>
                    <?php endwhile ?>


                </select>
            </fieldset>
            <input type="submit" value="Crear propiedad" class="boton boton-verde">
        </form>
    </main>

<?php 

incluirTemplate('footer');
?>

  