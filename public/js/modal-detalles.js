function mostrarDetalles(id) {
    fetch(`/tramite/detalle-estudiante/${id}`)
        .then(res => res.json())
        .then(data => {
            let contenido = `
                <p><strong>Tipo de Trámite:</strong> ${data.tipo}</p>
                <p><strong>Fecha de Envío:</strong> ${data.fecha}</p>
                <p><strong>Especialidad:</strong> ${data.especialidad}</p>
                <p><strong>DNI:</strong> ${data.dni}</p>
                <p><strong>Correo:</strong> ${data.correo}</p>
                <p><strong>Descripción:</strong> ${data.descripcion}</p>
                <p><strong>Estado:</strong> ${data.estado}</p>
                <p><strong>Archivo Enviado:</strong> <a href="${data.archivo}" target="_blank">Ver PDF</a></p>
            `;
            document.getElementById('detalleContenido').innerHTML = contenido;
            document.getElementById('modalDetalle').style.display = 'flex';
        });
}

function cerrarModalDetalle() {
    document.getElementById('modalDetalle').style.display = 'none';
}
