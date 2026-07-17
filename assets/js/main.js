document.addEventListener("DOMContentLoaded", function() {
    // Buscamos todos los enlaces que tengan "eliminar" en su clase o URL
    const linksEliminar = document.querySelectorAll('a[href*="eliminar.php"]');

    linksEliminar.forEach(link => {
        link.addEventListener('click', function(e) {
            // Mostramos una confirmación más amigable
            if (!confirm('¿Estás seguro de que deseas eliminar este elemento? Esta acción no se puede deshacer.')) {
                e.preventDefault(); // Cancelamos la acción si el usuario dice "No"
            }
        });
    });
});