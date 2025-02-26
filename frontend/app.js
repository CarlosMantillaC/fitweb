document.addEventListener('DOMContentLoaded', () => {
    // Ejemplo de conexión con el backend
    fetch('https://tu-backend-en-render.onrender.com/')
        .then(response => response.json())
        .then(data => {
            const contentDiv = document.getElementById('content');
            if(data.status === 'success') {
                contentDiv.innerHTML = `
                    <p>✅ Conexión exitosa con el backend</p>
                    <p>Hora del servidor: ${data.data.current_time}</p>
                `;
            } else {
                contentDiv.innerHTML = `❌ Error: ${data.message}`;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('content').innerHTML = '❌ Error conectando al backend';
        });
});