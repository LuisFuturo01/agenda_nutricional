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

    addMealForm.addEventListener('submit', (e) => {
        e.preventDefault(); 

        const mealName = document.getElementById('mealName').value;
        const mealQuantity = document.getElementById('mealQuantity').value;

        let mealDate = `${window.currentYear}-${String(window.currentMonth + 1).padStart(2, '0')}-${String(window.selectedDay).padStart(2, '0')}`;

        /* endpoint a añadirAlimento.php */
        

            document.getElementById("addMealForm").addEventListener("submit", (e) => {
                e.preventDefault();
                const alimento = document.getElementById("mealName").value;
                const cantidad = document.getElementById("mealQuantity").value;
                const fecha = mealDate;
                const id_user = 1; //modificar luego por el id del cookie
                let sw = consultarAlimento(alimento);
                if(sw['estado']=== 'ok'){
                    registroAlimentoDelDia(id_user, sw['id'], cantidad, fecha);
                }else{
                    //consultas a la IA
                    const alimento = document.getElementById("mealName").value;
                    const cantidad = document.getElementById("mealQuantity").value;
                    const fecha = mealDate;
                    const calorias = "550"
                    const proteinas = "30"
                    const grasas = "20"
                    const carbohidratos = "40"
                    agregarNuevoAlimento(alimento, calorias, proteinas, grasas, carbohidratos, cantidad, fecha);
                }
            });

        /* Cerrar endpoint */
        console.log('Enviando datos de comida:', { mealName, mealQuantity, mealDate });

        alert(`Comida registrada (simulado): ${mealName}, ${mealQuantity}g el ${mealDate}`);

        addMealModal.style.display = 'none';
        addMealForm.reset(); 

        /* Falta modulo de añadir alimento al detalle del dia */
    });
});