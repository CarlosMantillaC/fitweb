const API_URL = "https://ze2e.onrender.com";

// Cargar usuarios al iniciar
document.addEventListener('DOMContentLoaded', cargarUsuarios);

async function cargarUsuarios() {
    try {
        const response = await fetch(`${API_URL}/usuarios`);
        const usuarios = await response.json();
        renderizarUsuarios(usuarios);
    } catch (error) {
        mostrarMensaje("Error al cargar usuarios", "error");
    }
}

document.getElementById("formUsuario").addEventListener("submit", async (e) => {
    e.preventDefault();
    const datos = {
        nombre: document.getElementById("nombre").value,
        email: document.getElementById("email").value,
        edad: document.getElementById("edad").value
    };

    try {
        const response = await fetch(`${API_URL}/usuarios`, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(datos)
        });
        const resultado = await response.json();
        mostrarMensaje(resultado.mensaje, "success");
        cargarUsuarios(); // Recargar lista
    } catch (error) {
        mostrarMensaje("Error al registrar", "error");
    }
});

function renderizarUsuarios(usuarios) {
    const contenedor = document.getElementById("listaUsuarios");
    contenedor.innerHTML = usuarios.map(usuario => `
        <div class="usuario">
            <p>ID: ${usuario.id}</p>
            <p>Nombre: ${usuario.nombre}</p>
            <p>Email: ${usuario.email}</p>
            <p>Edad: ${usuario.edad}</p>
        </div>
    `).join("");
}

function mostrarMensaje(texto, tipo) {
    const mensajeDiv = document.getElementById("mensaje");
    mensajeDiv.className = tipo;
    mensajeDiv.textContent = texto;
}