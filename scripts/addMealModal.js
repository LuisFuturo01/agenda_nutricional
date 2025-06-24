document.addEventListener('DOMContentLoaded', () => {
    const addMealModal = document.getElementById('addMealModal');
    const addMealBtn = document.getElementById('addMealBtn');
    const closeAddMealBtn = document.getElementById('closeAddMealBtn');
    const addMealForm = document.getElementById('addMealForm');

    addMealBtn.addEventListener('click', () => {
        addMealModal.style.display = 'flex';
    });

    closeAddMealBtn.addEventListener('click', () => {
        addMealModal.style.display = 'none';
        addMealForm.reset(); // Reset form fields on close
    });

    window.addEventListener('click', (event) => {
        if (event.target === addMealModal) {
            addMealModal.style.display = 'none';
            addMealForm.reset();
        }
    });

    addMealForm.addEventListener('submit', (e) => {
        e.preventDefault(); // Prevent default form submission

        const mealName = document.getElementById('mealName').value;
        const mealQuantity = document.getElementById('mealQuantity').value;

        // OBTENER LA FECHA DEL DÍA SELECCIONADO EN EL CALENDARIO (directamente de agenda.js variables globales)
        let mealDate = `${window.currentYear}-${String(window.currentMonth + 1).padStart(2, '0')}-${String(window.selectedDay).padStart(2, '0')}`;

        // SIMULACIÓN: En un sistema real, aquí harías una petición AJAX (fetch/axios)
        // a un endpoint PHP (ej. 'api/add_meal.php') para guardar en la DB.
        console.log('Enviando datos de comida:', { mealName, mealQuantity, mealDate });

        alert(`Comida registrada (simulado): ${mealName}, ${mealQuantity}g el ${mealDate}`);

        // Después de un registro exitoso (simulado)
        addMealModal.style.display = 'none'; // Close modal
        addMealForm.reset(); // Clear form

        // Refrescar la lista de comidas para el día actual sin recargar la página
        window.fetchDataForDate(window.currentYear, window.currentMonth, window.selectedDay);
    });
});