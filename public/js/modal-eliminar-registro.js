let formularioActual = null;

    document.querySelectorAll('.form-eliminar').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault(); // detener el envío

            formularioActual = this;
            const nombre = this.dataset.nombre;

            document.getElementById('modal-texto').textContent =
                `¿Seguro que deseas eliminar al estudiante "${nombre}"?`;
            document.getElementById('modal-confirmar').style.display = 'flex';
        });
    });

    document.getElementById('btn-cancelar').addEventListener('click', function () {
        document.getElementById('modal-confirmar').style.display = 'none';
    });

    document.getElementById('btn-confirmar').addEventListener('click', function () {
        if (formularioActual) formularioActual.submit();
    });