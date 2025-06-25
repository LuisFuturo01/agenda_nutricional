import {getCookie,deleteCookie} from './cookies.js';
if( getCookie( "usuario" == null)) window.location.href = "./login.php";
const calendarDates = document.getElementById('calendarDates');
const currentMonthYear = document.getElementById('currentMonthYear');
const prevMonthBtn = document.getElementById('prevMonth');
const nextMonthBtn = document.getElementById('nextMonth');
window.currentMonth = new Date().getMonth();
window.currentYear = new Date().getFullYear();
window.selectedDay = new Date().getDate();
const today = new Date();
const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
function renderCalendar() {
    calendarDates.innerHTML = '';
    currentMonthYear.textContent = `${monthNames[window.currentMonth]} ${window.currentYear}`;
    const firstDayOfMonth = new Date(window.currentYear, window.currentMonth, 1).getDay();
    const daysInMonth = new Date(window.currentYear, window.currentMonth + 1, 0).getDate();
    const startDayOffset = (firstDayOfMonth === 0) ? 6 : firstDayOfMonth - 1;
    for (let i = 0; i < startDayOffset; i++) {
        const emptyDiv = document.createElement('div');
        emptyDiv.classList.add('empty-day');
        calendarDates.appendChild(emptyDiv);
    }
    for (let day = 1; day <= daysInMonth; day++) {
        const dayDiv = document.createElement('div');
        dayDiv.textContent = day;
        dayDiv.dataset.day = day;
        const isToday = (day === today.getDate() && window.currentMonth === today.getMonth() && window.currentYear === today.getFullYear());
        if (isToday) {
            dayDiv.classList.add('current-day');
            dayDiv.classList.add('today');
            window.selectedDay = day;
        }
        dayDiv.addEventListener('click', () => {
            document.querySelectorAll('.calendar-dates div').forEach(div => {
                div.classList.remove('current-day');
            });
            dayDiv.classList.add('current-day');
            window.selectedDay = day;
        });
        calendarDates.appendChild(dayDiv);
    }
}
prevMonthBtn.addEventListener('click', () => {
    window.currentMonth--;
    if (window.currentMonth < 0) {
        window.currentMonth = 11;
        window.currentYear--;
    }
    renderCalendar();
});
nextMonthBtn.addEventListener('click', () => {
    window.currentMonth++;
    if (window.currentMonth > 11) {
        window.currentMonth = 0;
        window.currentYear++;
    }
    renderCalendar();
});
renderCalendar();

/* Menejo del cookie de sesion logout */
document.getElementById("logout").addEventListener("click", (e) => {
    e.preventDefault();
    const logout = confirm("¿Seguro que quieres cerrar sesión?");
    if (logout) {
        deleteCookie("usuario");
        window.location.href="./index.html";
    }
})
