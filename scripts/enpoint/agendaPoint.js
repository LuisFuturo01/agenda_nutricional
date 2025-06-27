
export const registroAlimentoDelDia = async (id_user, id_alimento ,cantidad, fecha) => {
    try {
        const response = await fetch("../db/registroAlimentoDelDia.php",{
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                id_user: id_user,
                id_alimento: id_alimento,
                cantidad: cantidad,
                fecha: fecha
            })
        })
        const data = await response.json();
        return data;
    } catch (error) {
        console.error("Error: ", error )
        return { estado: "error", message: "Error ingresar un dato" }
    }
}

export const consultarAlimento = async (nombre) => {
    try {
        const response = await fetch("../db/consultarAlimento.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ nombre: nombre }),
        });
        const data = await response.json();
        return data;
    } catch (error) {
        console.error("Error:", error);
        return { estado: "error", message: "Error de conexión" };
    }
};

export const agregarNuevoAlimento = async (alimento, calorias, proteinas, grasas, carbohidratos, id_user, cantidad, fecha) => {
    try {
        const response = await fetch("../db/registroNuevoAlimento.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ 
                alimento: alimento,
                calorias: calorias,
                proteinas: proteinas,
                grasas: grasas,
                carbohidratos: carbohidratos,
                id_user: id_user,
                cantidad: cantidad,
                fecha: fecha
            }),
        });
        const data = await response.json();
        return data;
    } catch (error) {
        console.error("Error:", error);
        return { estado: "error", message: "Error al enviar datos" };
    }
};

export const consultarAlimentoDelDia = async (alimento, fecha) => {
    try {
        const response = await fetch("../db/consultarAlimentoDelDia.php",{
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                alimento: alimento,
                fecha: fecha
            })
        })
        const data = await response.json();
        return data;
    } catch (error) {
        console.error("Error:", error);
        return { estado: "error", message: "Error al recibir la consulta"}
    }
}