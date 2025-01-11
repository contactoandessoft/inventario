document.addEventListener('DOMContentLoaded', function () {
    console.log("El DOM está completamente cargado.");

    const nombreMarcaInput = document.getElementById('nombre_marca');
    nombreMarcaInput.addEventListener('input', function () {
        const nombreMarca = nombreMarcaInput.value.trim();
        
        if (nombreMarca.length > 0) {
            fetch(`${obtenerMarcaUrl}/${nombreMarca}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.marca.nombre_marca === nombreMarca) {
                        document.getElementById('vigencia').value = data.marca.vigencia == 1 ? '1' : '0';
                        const fechaAudita = data.marca.fecha_audita;
                        if (fechaAudita) {
                            const fechaFormateada = new Date(fechaAudita);
                            document.getElementById('fecha_audita').value = fechaFormateada.toISOString().split('T')[0];
                        }
                        document.getElementById('id_marcas').value = data.marca.id_marcas;
                        document.getElementById('id_usuario').value = data.marca.id_usuario;
                    } else {
                        limpiarFormulario();
                    }
                })
                .catch(() => {
                    limpiarFormulario();
                });
        } else {
            limpiarFormulario();
        }
    });

    function limpiarFormulario() {
        document.getElementById('vigencia').value = '';
        document.getElementById('fecha_audita').value = '';
        document.getElementById('id_marcas').value = '';
        document.getElementById('id_usuario').value = '';
    }

    setTimeout(function() {
        const successMessage = document.getElementById('mensaje-success');
        const errorMessage = document.getElementById('mensaje-error');

        function fadeOut(element) {
            if (element) {
                element.style.transition = "opacity 1s ease-out";
                element.style.opacity = 0;
                setTimeout(function() {
                    element.style.display = 'none';
                }, 1000);
            }
        }

        fadeOut(successMessage);
        fadeOut(errorMessage);

    }, 2000);
});
