function mostrarObservacion(texto) {
        document.getElementById('textoObservacion').innerText = texto;
        document.getElementById('modalObservacion').style.display = 'flex';
    }

    function cerrarObservacion() {
        document.getElementById('modalObservacion').style.display = 'none';
    }