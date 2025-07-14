function toggleRequisitos(id) {
    const div = document.getElementById(id);
    const isVisible = div.style.display === 'block';

    // Oculta todos los requisitos primero
    document.querySelectorAll('.requisitos').forEach(el => {
        el.style.display = 'none';
    });

    // Solo muestra el que corresponde si no estaba ya visible
    if (!isVisible) {
        div.style.display = 'block';
    }
}
