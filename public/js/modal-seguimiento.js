function cerrarModal() {
    const modal = document.getElementById("modalResultado");
    if (modal) modal.style.display = "none";
}

window.addEventListener('load', () => {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('codigo')) {
        const modal = document.getElementById("modalResultado");
        if (modal) modal.style.display = "flex";

        // Quitar el parámetro "codigo" de la URL (sin recargar)
        const url = new URL(window.location);
        url.searchParams.delete('codigo');
        window.history.replaceState({}, document.title, url.toString());
    }
});
