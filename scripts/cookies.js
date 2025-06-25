export function setCookie(nombre, valor, dias) {
  const fecha = new Date();
  fecha.setTime(fecha.getTime() + (dias * 24 * 60 * 60 * 1000));
  const expiracion = "expires=" + fecha.toUTCString();
  document.cookie = `${nombre}=${valor}; ${expiracion}; path=/`;
}
export function getCookie(nombre) {
  const nombreEQ = nombre + "=";
  const cookies = document.cookie.split(';');
  for (let c of cookies) {
    c = c.trim();
    if (c.indexOf(nombreEQ) === 0) return c.substring(nombreEQ.length);
  }
  return null;
}
export function deleteCookie(nombre) {
  document.cookie = `${nombre}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/`;
}

