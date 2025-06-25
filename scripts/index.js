import {setCookie,getCookie,deleteCookie} from './cookies.js';

let valmenu=false;
let details = document.querySelectorAll("details");
let navbar = document.getElementById("navbar");
details.forEach((detail) => {
  detail.addEventListener("toggle", () => {
    if (detail.open) {
      details.forEach((d) => {
        if (d !== detail) d.open = false;
      });
    }
  });
});

if(getCookie("usuario") == "claveID"){
  valmenu=true;
  navbar.innerHTML = `
    <a href="#inicio">Inicio</a>
    <a href="#funciones">Funciones</a>
    <a href="#beneficios">Beneficios</a>
    <a href="agenda.php">Agenda</a>
    <a href="perfil.php">Perfil</a>
    <a href="#" id="logout">Cerrar Sesión</a>
  `;
}else{
  valmenu=false;
  navbar.innerHTML = `
    <a href="#inicio">Inicio</a> 
    <a href="#funciones">Funciones</a>
    <a href="#beneficios">Beneficios</a>
    <a href="login.php" id="login">Ingresar</a>
    <a href="registro.php">Registrarse</a>
  `;
}
if (valmenu){
  document.getElementById("logout").addEventListener("click", () => {
    var logout=confirm("¿Seguro que quieres cerrar sesión?");
    if (logout) {
      deleteCookie("usuario");
      location.reload();
    }
  });
}else{
  document.getElementById("login").addEventListener("click", (e) => {
    e.preventDefault();
    setCookie("usuario", "claveID", 1);
    location.reload(); 
  })
}

