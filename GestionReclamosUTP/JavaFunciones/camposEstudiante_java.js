/* MENÚ DE USUARIO - CURSOS Y NOTAS */
document.addEventListener('DOMContentLoaded', function () {
    const userInfo = document.querySelector('.user-info');
    const userMenu = document.querySelector('.user-menu');
    if (userInfo && userMenu) {
        userInfo.addEventListener('click', () => {
            userMenu.classList.toggle('visible');
        });
    }
});

/* REGISTRO DE RECLAMOS */
function mostrarInfo() {
    const select = document.getElementById('nota_id');
    const option = select.options[select.selectedIndex];

    if (select.value) {
        document.getElementById('info-box').style.display = 'block';
        document.getElementById('infoCurso').textContent = option.getAttribute('data-curso');
        document.getElementById('infoProfesor').textContent = option.getAttribute('data-profesor');
        document.getElementById('infoNota').textContent = option.getAttribute('data-nota');
        document.getElementById('infoObservacion').textContent = option.getAttribute('data-observacion');
    } else {
        document.getElementById('info-box').style.display = 'none';
    }
}

/* SEGUIMIENTO DE RECLAMOS */
function normalizarEstado(estado) {
    if (!estado) return '';
    const limpio = estado.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
    if (limpio.includes("pendiente")) return "pendiente";
    if (limpio.includes("revision")) return "revision";
    if (limpio.includes("aceptado")) return "aceptado";
    if (limpio.includes("rechazado")) return "rechazado";
    return "";
}

function generarBarraEstado(estadoTexto) {
    const estado = normalizarEstado(estadoTexto);
    const estadoVisible = estadoTexto ?? '-';
    return `
        <div class="barra-progreso ${estado}">
            <div class="progreso"></div>
        </div>
        <div class="estado-texto">${estadoVisible}</div>
    `;
}

function cargarSeguimientos() {
    if (typeof ESTUDIANTE_ID === 'undefined') {
        console.error("La variable global ESTUDIANTE_ID no está definida.");
        return;
    }

    fetch("seguimiento_envivo_10sg.php?id_estudiante=" + ESTUDIANTE_ID)
        .then(res => res.json())
        .then(data => {
            const tbody = document.querySelector("#tabla-seguimiento tbody");
            tbody.innerHTML = "";

            if (!data || data.length === 0) {
                const fila = document.createElement("tr");
                fila.innerHTML = `<td colspan="5">No hay datos disponibles</td>`;
                tbody.appendChild(fila);
                return;
            }

            data.forEach(item => {
                const fila = document.createElement("tr");

                let fechaTexto = '-';
                if (item.fecha) {
                    const fechaCruda = item.fecha.$date ?? item.fecha;
                    const fecha = new Date(fechaCruda);
                    if (!isNaN(fecha)) {
                        const year = fecha.getFullYear();
                        const month = String(fecha.getMonth() + 1).padStart(2, '0');
                        const day = String(fecha.getDate()).padStart(2, '0');
                        fechaTexto = `${year}-${month}-${day}`;
                    }
                }

                const columnas = [
                    item.reclamo_id ?? '-',
                    generarBarraEstado(item.estado),
                    item.comentario ?? '-',
                    fechaTexto,
                    item.actualizado_por ?? '-'
                ];

                columnas.forEach(col => {
                    const td = document.createElement("td");
                    td.innerHTML = col;
                    fila.appendChild(td);
                });

                tbody.appendChild(fila);
            });
        })
        .catch(error => {
            console.error("Error cargando datos:", error);
        });
}

setInterval(cargarSeguimientos, 10000);
window.onload = cargarSeguimientos;
