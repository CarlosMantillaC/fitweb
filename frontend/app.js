// Registrar un nuevo usuario
if (document.getElementById('registroForm')) {
    document.getElementById('registroForm').addEventListener('submit', (e) => {
        e.preventDefault();

        const nombre = document.getElementById('nombre').value;
        const email = document.getElementById('email').value;
        const edad = document.getElementById('edad').value;

        fetch('https://fitweb-ze2e.onrender.com/', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ nombre, email, edad })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Usuario registrado correctamente');
                document.getElementById('registroForm').reset();
                // Recargar la lista de usuarios después de registrar uno nuevo
                cargarUsuarios();
            } else {
                alert('Error al registrar el usuario');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al conectar con el servidor');
        });
    });
}

// Función para cargar y mostrar los usuarios
function cargarUsuarios() {
    if (document.getElementById('usuariosList')) {
        fetch('https://fitweb-ze2e.onrender.com/')
            .then(response => response.json())
            .then(data => {
                const usuariosList = document.getElementById('usuariosList');
                usuariosList.innerHTML = ''; // Limpiar la lista antes de cargar
                if (data.status === 'success') {
                    data.data.forEach(usuario => {
                        const usuarioItem = document.createElement('div');
                        usuarioItem.className = 'usuario-item';
                        usuarioItem.innerHTML = `
                            <p><strong>Nombre:</strong> ${usuario.nombre}</p>
                            <p><strong>Email:</strong> ${usuario.email}</p>
                            <p><strong>Edad:</strong> ${usuario.edad}</p>
                            <p><strong>Fecha de registro:</strong> ${new Date(usuario.fecha_registro).toLocaleString()}</p>
                        `;
                        usuariosList.appendChild(usuarioItem);
                    });
                } else {
                    usuariosList.innerHTML = '<p>Error al cargar los usuarios</p>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('usuariosList').innerHTML = '<p>Error al conectar con el servidor</p>';
            });
    }
}

// Cargar los usuarios al abrir la página
if (document.getElementById('usuariosList')) {
    cargarUsuarios();
}