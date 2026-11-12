
const DATA = [
    { nombre: "Laura", apellidos: "García Pérez", password: "12345678", telefono: "600111222", email: "laura@example.com", sexo: "Mujer" },
    { nombre: "Carlos", apellidos: "Martínez López", password: "12345678", telefono: "600333444", email: "carlos@example.com", sexo: "Hombre" },
    { nombre: "Ana", apellidos: "Ruiz Sánchez", password: "12345678", telefono: "600555666", email: "ana@example.com", sexo: "Mujer" },
    { nombre: "David", apellidos: "Fernández Gil", password: "12345678", telefono: "600777888", email: "david@example.com", sexo: "Hombre" }
];

const tbody = document.querySelector("table tbody");
const search = document.querySelector("#search");

const renderizarTabla = (usuarios) => {
    tbody.innerHTML = "";

    usuarios.forEach(user => {
        const fila = document.createElement("tr");
        fila.innerHTML = `
            <td>${user.nombre}</td>
            <td>${user.apellidos}</td>
            <td>${"•".repeat(user.password.length)}</td>
            <td>${user.telefono}</td>
            <td>${user.email}</td>
            <td>${user.sexo}</td>
        `;

        const celdaAcciones = document.createElement("td");
        const boton = document.createElement("button");
        boton.textContent = "X";
        boton.addEventListener("click", () => {
            const i = DATA.indexOf(user);
            if (i > -1) DATA.splice(i, 1);
            aplicarFiltro(); 
        });
        celdaAcciones.appendChild(boton);
        fila.appendChild(celdaAcciones);

        tbody.appendChild(fila);
    });
};

const aplicarFiltro = () => {
    const texto = search.value.trim().toLowerCase();

    if (texto.length < 3) {
        renderizarTabla(DATA);
        return;
    }

    const coincidencias = DATA.filter(user =>
        user.nombre.toLowerCase().includes(texto) ||
        user.apellidos.toLowerCase().includes(texto)
    );

    renderizarTabla(coincidencias);
};

search.addEventListener("input", aplicarFiltro);
renderizarTabla(DATA);