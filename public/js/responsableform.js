document.addEventListener('DOMContentLoaded', function () {
    const nombreResponsableInput = document.getElementById('nombre_responsable'); 

    nombreResponsableInput.addEventListener('input', function () {
        const nombreResponsable = nombreResponsableInput.value.trim();

        if (nombreResponsable.length > 0) {
            fetch(`responsableform/obtenerResponsable/${nombreResponsable}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.responsable.nombre_responsable === nombreResponsable) {
                        document.getElementById('vigencia').value = data.responsable.vigencia == 1 ? 'activo' : 'baja';

                        const fechaAudita = data.responsable.fecha_audita;
                        if (fechaAudita) {
                            const fechaFormateada = new Date(fechaAudita);
                            document.getElementById('fecha_audita').value = fechaFormateada.toISOString().split('T')[0];
                        }

                        document.getElementById('id_responsable').value = data.responsable.id_responsable;

                        const usuarioSelect = document.getElementById('id_usuario');
                        usuarioSelect.value = data.responsable.id_usuario;  

                        for (let option of usuarioSelect.options) {
                            if (option.value == data.responsable.id_usuario) {
                                option.selected = true;
                                break;
                            }
                        }
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
        document.getElementById('id_responsable').value = '';
        document.getElementById('id_usuario').value = '';
    }

    setTimeout(function () {
        const successMessage = document.getElementById('mensaje-success');
        const errorMessage = document.getElementById('mensaje-error');

        function fadeOut(element) {
            element.style.transition = "opacity 1s ease-out";
            element.style.opacity = 0; 
            setTimeout(function () {
                element.style.display = 'none'; 
            }, 1000); 
        }

        if (successMessage) {
            fadeOut(successMessage);
        }

        if (errorMessage) {
            fadeOut(errorMessage);
        }
    }, 2000); 
});
