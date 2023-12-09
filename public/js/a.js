// URLs de ejemplo para las solicitudes
const urls = [
    'https://jsonplaceholder.typicode.com/todos',
    'https://jsonplaceholder.typicode.com/users',
    'https://jsonplaceholder.typicode.com/comments',
    'https://jsonplaceholder.typicode.com/posts/'
];

// Función para hacer una solicitud utilizando Axios
const makeRequest = (url) => {
    return axios.get(url)
        .then(response => {
            // Manejar la respuesta de la solicitud
            console.log(`Respuesta de ${url}:`, response.data);
            return response.data;
        })
        .catch(error => {
            // Manejar errores de la solicitud
            console.error(`Error en ${url}:`, error);
            throw error;
        });
};

// Realizar las solicitudes en paralelo
const parallelRequests = urls.map(makeRequest);

// Realizar otras tareas mientras esperas las respuestas
console.log('Realizando otras tareas...');
console.log('Tarea completada');

setTimeout(() => {
    console.log('Tarea adicional completada.');
}, 2000);

// Esperar todas las respuestas al mismo tiempo
Promise.all(parallelRequests)
.then(responses => {
    // Manejar las respuestas de todas las solicitudes
    console.log('Todas las respuestas:', responses);
})
.catch(error => {
    // Manejar errores si alguna de las solicitudes falla
    console.error('Error en una o más solicitudes:', error);
});