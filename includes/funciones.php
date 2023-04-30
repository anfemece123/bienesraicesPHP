<?php 
require 'app.php'; 


function incluirTemplate(string $nombre, bool $inicio= false){
    include TEMPLATES_URL."/{$nombre}.php";
}

function estadoAutenticado(): bool {
    session_start();


    $auth= $_SESSION['auth'];//le asigo a la variable auth el booleano de autenticacion );

    if($auth){  
    
      return true;
    }
        return false; //lo mismo que el else con un coodigo mas corto
   
}