import { consultarAlimentoDelDia, eliminarAlimento } from './enpoint/agendaPoint.js';

document.addEventListener('DOMContentLoaded', () => {
    const removeMealModal = document.getElementById('removeMealModal');
    const removeMealBtn = document.getElementById('removeMealBtn');
    const closeremoveMealBtn = document.getElementById('closeRemoveMealBtn');
    const removeMealForm = document.getElementById('removeMealForm');

    removeMealBtn.addEventListener('click', () => {
        removeMealModal.style.display = 'flex';
    });

    closeremoveMealBtn.addEventListener('click', () => {
        removeMealModal.style.display = 'none';
        removeMealForm.reset();
    });

    window.addEventListener('click', (event) => {
        if (event.target === removeMealModal) {
            removeMealModal.style.display = 'none';
            removeMealForm.reset();
        }
    });

    removeMealForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const mealName = document.getElementById('mealNameRemove').value;
        const mealDate = `${window.currentYear}-${String(window.currentMonth + 1).padStart(2, '0')}-${String(window.selectedDay).padStart(2, '0')}`;
        const id_user = window.idUser;

        try {
            const resultado = await consultarAlimentoDelDia(mealName, mealDate);

            if (resultado.estado !== 'ok') {
                alert("El alimento no se puede eliminar, porque no está registrado");
            } else {
                const confirmDelete = confirm("¿Seguro que desea eliminar el alimento de tu lista?");
                if (confirmDelete) {
                    const removeAlimento = await eliminarAlimento(id_user, resultado.id, mealDate);

                    if (removeAlimento.estado === 'ok') {
                        alert("Alimento eliminado con éxito");
                    } else {
                        alert("Hubo un problema al intentar eliminar el alimento");
                    }
                }
            }

            removeMealModal.style.display = 'none';
            removeMealForm.reset();

        } catch (error) {
            console.error('Error:', error);
            alert('Error al procesar la solicitud');
        }
    });
});
