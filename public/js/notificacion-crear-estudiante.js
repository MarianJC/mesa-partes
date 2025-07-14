setTimeout(() => {
        const alerta = document.querySelector('.alert-exito');
        if (alerta) {
            alerta.style.transition = 'opacity 0.6s';
            alerta.style.opacity = '0';
            setTimeout(() => alerta.remove(), 600);
        }
    }, 3000); // Desaparece en 3 segundos

