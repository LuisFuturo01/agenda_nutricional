export const consultarAlimento = (nombre) => {
    fetch("../db/consultarAlimento.php",{
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({ nombre: nombre }),
    })
    .then((res)=> res.json())
    .then((data)=>{
        console.log(data.nombre + " " + data.id);
    })
    .catch((err) => {
        console.error("Error:", err);
    });
}
export const registroAlimentoDelDia = (id_user, id_alimento ,cantidad, fecha) => {
    fetch("../db/añadirAlimentoDelDia.php", {
        method: "POST",
        headers: {
        "Content-Type": "application/json",
        },
        body: JSON.stringify({ 
            id_user: id_user,
            id_alimento: id_alimento,
            cantidad: cantidad,
            fecha: fecha
        }),
    })
    .then((res) => res.json())
    .then((data) => {
        return data;
    })
    .catch((err) => {
    console.error("Error:", err);
    });
}


export const agregarNuevoAlimento=(alimento, calorias, proteinas, grasas, carbohidratos, cantidad, id_user, fecha) => {
    fetch("../db/añadirNuevoAlimento.php", {
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
    })
    .then(async res => {
        const text = await res.text();
        try {
            const data = JSON.parse(text);
            console.log("Respuesta JSON:", data);
            alert(data.mensaje);
        } catch(e) {
            console.error("No es JSON válido:", text);
        }
        })

}

window.agregarNuevoAlimento = agregarNuevoAlimento;
window.consultarAlimento = consultarAlimento;
window.registroAlimentodeldia = registroAlimentodeldia;
