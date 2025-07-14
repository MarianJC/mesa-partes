function mostrarDetalle(id) {
    fetch(`/tramite/detalle/${id}`)
        .then(response => response.json())
        .then(data => {
            let contenido = `
                <p><strong>Estudiante:</strong> ${data.nombre}</p>
                <p><strong>Código:</strong> ${data.codigo}</p>
                <p><strong>Tipo:</strong> ${data.tipo}</p>
                <p><strong>Estado:</strong> ${data.estado}</p>
                <p><strong>Fecha de envío:</strong> ${data.fecha}</p>
            `;

            if (data.estado === 'derivado') {
                contenido += `
                    <p><strong>Derivado a:</strong> ${data.area}</p>
                    <p><strong>Fecha de derivación:</strong> ${data.fecha_derivacion}</p>
                `;
            }

            if (data.estado === 'rechazado') {
                contenido += `
                    <p><strong>Motivo del rechazo:</strong> ${data.respuesta}</p>
                    <p><strong>Fecha de rechazo:</strong> ${data.fecha_rechazo}</p>
                `;
            }

            document.getElementById('modal-info').innerHTML = contenido;
            document.getElementById('modalDetalle').style.display = 'flex';
        });
}

function cerrarModalDetalle() {
    document.getElementById('modalDetalle').style.display = 'none';
}
