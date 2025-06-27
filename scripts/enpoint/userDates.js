export const obtenerNombre = async (id_user)=>{
    try {
        const response = await fetch('../db/obtenerDatosUser.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({id_user: id_user})
        });
        const data = await response.json();
        return data;
    } catch (error) {
        console.error("Error:", error);
        return { estado: "error", message: "Error al obtener datos"}
    }
    
}