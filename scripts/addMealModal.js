import { registroAlimentoDelDia, consultarAlimento, agregarNuevoAlimento } from './enpoint/agendaPoint.js';

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
        addMealForm.reset(); 
    });

    window.addEventListener('click', (event) => {
        if (event.target === addMealModal) {
            addMealModal.style.display = 'none';
            addMealForm.reset();
        }
    });

    addMealForm.addEventListener('submit', async (e) => {
        e.preventDefault(); 

        const mealName = document.getElementById('mealName').value;
        const mealQuantity = document.getElementById('mealQuantity').value;
        const mealDate = `${window.currentYear}-${String(window.currentMonth + 1).padStart(2, '0')}-${String(window.selectedDay).padStart(2, '0')}`;
        const id_user = 1; // Cambiar por el ID real del usuario

        try {
            // Verificar si el alimento existe
            const resultado = await consultarAlimento(mealName);
            
            if (resultado.estado === 'ok') {
                // El alimento existe, registrarlo
                await registroAlimentoDelDia(id_user, resultado.id, mealQuantity, mealDate);
                alert('Comida registrada correctamente');
            } else {
                // El alimento no existe, crear uno nuevo con datos de IA
                const calorias = "550"; // Aquí deberías consultar a la IA
                const proteinas = "30";
                const grasas = "20";
                const carbohidratos = "40";
                
                const response = await agregarNuevoAlimento(
                    mealName, calorias, proteinas, grasas, 
                    carbohidratos, id_user, mealQuantity, mealDate
                );
                
                if (response.estado === 'ok') {
                    alert('Nuevo alimento añadido correctamente');
                } else {
                    alert('Error al añadir alimento: ' + response.mensaje);
                }
            }
            
            addMealModal.style.display = 'none';
            addMealForm.reset();
            
        } catch (error) {
            console.error('Error:', error);
            alert('Error al procesar la solicitud');
        }
    });
});