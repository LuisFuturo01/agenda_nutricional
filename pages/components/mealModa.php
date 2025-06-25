<div id="addMealModal" class="modal">
        <div class="modal-content">
            <span class="close-button" id="closeAddMealBtn">&times;</span>
            <h4>🍽️ Registrar Nueva Comida</h4>
            <form id="addMealForm">
                <label for="mealName">Nombre del Alimento:</label>
                <input type="text" id="mealName" name="mealName" required>

                <label for="mealQuantity">Cantidad (gramos):</label>
                <input type="number" id="mealQuantity" name="mealQuantity" min="1" required>

                <button type="submit" class="submit-button">Registrar Comida</button>
            </form>
        </div>
</div>