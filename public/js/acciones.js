// Búsqueda instantánea
const inputBuscar = document.getElementById('buscar');
const filas = document.querySelectorAll('#tabla-usuarios tbody tr[data-id]');
const sinResultados = document.getElementById('sin-resultados');

inputBuscar.addEventListener('input', () => {
    const termino = inputBuscar.value.trim().toLowerCase();
    let visibles = 0;

    filas.forEach(fila => {
        const coincide = fila.textContent.toLowerCase().includes(termino);
        fila.style.display = coincide ? '' : 'none';
        if (coincide) visibles++;
    });

    sinResultados.style.display = visibles === 0 ? '' : 'none';
});

// Eliminar sin recargar
document.querySelectorAll('.btn-eliminar').forEach(boton => {
    boton.addEventListener('click', async () => {
        if (!confirm('¿Eliminar este usuario?')) return;

        const id = boton.dataset.id;
        const datos = new FormData();
        datos.append('id', id);

        const respuesta = await fetch('../controllers/deleteUsuario.php', {
            method: 'POST',
            body: datos
        });
        const resultado = await respuesta.json();

        if (resultado.success) {
            boton.closest('tr').remove();
        } else {
            alert(resultado.message);
        }
    });
});