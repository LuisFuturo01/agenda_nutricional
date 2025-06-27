<?php

    include 'conexion_sqli.php';

    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $edad= $_POST['edad'];
    $sexo= $_POST['sexo'];
    $altura_cm= $_POST['altura_cm'];
    $fecha_registro= $_POST['fecha_registro'];
    
    //encriptamiento de contraseña
    $contrasena = hash('sha256', $contrasena); 

    $query = "INSERT INTO usuarios(nombre, correo, contraseña, edad, sexo, altura_cm, fecha_registro) 
            VALUES('$nombre','$correo', '$contrasena', '$edad', '$sexo', '$altura_cm','$fecha_registro')";
    //verificar los correos no se repitan
    $verificar_correo = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo='$correo' ");
    if(mysqli_num_rows($verificar_correo)>0){
        echo'
            <script>
                alert("Este correo ya esta registrado, intenta con otro diferente");
                window.location = "../pages/register.php";
            </script>';
            exit();
    }

    $ejecutar = mysqli_query($conexion, $query);
    if($ejecutar){
        echo '
        <script>
            alert("Usuario Almacenado exitosamente");
            window.location = "../pages/login.php";
        </script>';}
    else{
        echo '
        <script>
            alert("Error, Usuario no almacenado");
            window.location = "../pages/register.php";
        </script>';}
    
mysqli_close($conexion);

?>