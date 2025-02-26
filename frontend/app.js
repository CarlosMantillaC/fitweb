const API_URL = "https://fitweb-ze2e.onrender.com";

// Cargar usuarios al iniciar
document.addEventListener('DOMContentLoaded', cargarUsuarios);

// Función para obtener usuarios
async function obtenerUsuarios() {
  try {
      const response = await fetch(`${API_URL}/usuarios`);
      if (!response.ok) throw new Error("Error en la respuesta");
      const usuarios = await response.json();
      console.log("Usuarios:", usuarios);
      return usuarios;
  } catch (error) {
      console.error("Error al obtener usuarios:", error);
  }
}

// Función para registrar un usuario
async function registrarUsuario(nombre, email, edad) {
  try {
      const response = await fetch(`${API_URL}/usuarios`, {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ nombre, email, edad }),
      });
      if (!response.ok) throw new Error("Error en la respuesta");
      const resultado = await response.json();
      console.log("Resultado:", resultado);
      return resultado;
  } catch (error) {
      console.error("Error al registrar usuario:", error);
  }
}

// Ejemplo de uso
document.addEventListener('DOMContentLoaded', async () => {
  const usuarios = await obtenerUsuarios();
  console.log(usuarios);
});

document.getElementById("formUsuario").addEventListener("submit", async (e) => {
  e.preventDefault();
  const nombre = document.getElementById("nombre").value;
  const email = document.getElementById("email").value;
  const edad = document.getElementById("edad").value;
  await registrarUsuario(nombre, email, edad);
});