<?php
    
    session_start();
    
    include 'conexion_sqli.php';
    
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $contrasena = hash('sha256', $contrasena);

    $validar_login = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo='$correo' 
    and contraseña='$contrasena' ");

    if(mysqli_num_rows($validar_login) > 0){
       $_SESSION['correo'] = $correo;
    header("location: ../pages/index.html");
    exit;
    }

    else{
        echo '
        <script>
            alert("Usuario inexistente, verifique sus datos");
            window.location = "../pages/login.php";
        </script>
        ';
        exit;
    }
?>