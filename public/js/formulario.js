document.addEventListener('DOMContentLoaded', function () {
    const numeroInventarioInput = document.getElementById('numero_inventario');
    const imagenEquipo = document.getElementById('imagen_equipo');

    numeroInventarioInput.addEventListener('input', function () {
        const numeroInventario = numeroInventarioInput.value;

        if (numeroInventario.length > 0) {
            fetch(`${baseUrl}/${numeroInventario}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (data.equipo.numero_inventario === numeroInventario) {
                            document.getElementById('descripcion').value = data.equipo.descripcion || '';
                            document.getElementById('id_marcas').value = data.equipo.id_marcas || '';
                            document.getElementById('modelo').value = data.equipo.modelo || '';
                            document.getElementById('ano_fabricacion').value = data.equipo.ano_fabricacion || '';
                            document.getElementById('valor_adquisicion').value = data.equipo.valor_adquisicion || '';
                            document.getElementById('id_responsable').value = data.equipo.id_responsable || '';
                            document.getElementById('estado').value = data.equipo.estado || '';
                            document.getElementById('numero_serie').value = data.equipo.numero_serie || '';
                            document.getElementById('vida_util').value = data.equipo.vida_util || '';
                            document.getElementById('fecha_alta').value = data.equipo.fecha_alta || '';
                            document.getElementById('seccion').value = data.equipo.seccion || '';
                            document.getElementById('dependencia').value = data.equipo.dependencia || '';
                            document.getElementById('comentarios').value = data.equipo.comentarios || '';

                            const imagePath = `http://localhost/empresa/public/uploads/${data.equipo.numero_inventario}.jpg?timestamp=${new Date().getTime()}`;

                            imagenEquipo.src = imagePath;

                            imagenEquipo.onerror = function () {
                                console.log('Imagen no encontrada, cargando imagen predeterminada.');
                                imagenEquipo.src = 'https://static.vecteezy.com/system/resources/previews/005/337/799/non_2x/icon-image-not-found-free-vector.jpg'; // Cambia esto a la URL de tu imagen predeterminada
                            };
                        } else {
                            limpiarFormulario();
                        }
                    } else {
                        limpiarFormulario();
                    }
                })
                .catch(error => {
                    console.error('Error al obtener los datos:', error);
                    limpiarFormulario();
                });
        } else {
            limpiarFormulario();
        }
    });

    function limpiarFormulario() {
        document.getElementById('descripcion').value = '';
        document.getElementById('id_marcas').value = '';
        document.getElementById('modelo').value = '';
        document.getElementById('ano_fabricacion').value = '';
        document.getElementById('valor_adquisicion').value = '';
        document.getElementById('id_responsable').value = '';
        document.getElementById('estado').value = '';
        document.getElementById('numero_serie').value = '';
        document.getElementById('vida_util').value = '';
        document.getElementById('fecha_alta').value = '';
        document.getElementById('seccion').value = '';
        document.getElementById('dependencia').value = '';
        document.getElementById('comentarios').value = '';

        imagenEquipo.src = 'https://2.bp.blogspot.com/-Xfmhk1tfniM/W3c8iSrhQLI/AAAAAAAApQg/ThaakYPo1_oGrKTxODFUMFHF5BuyUb5lACLcBGAs/s1600/inventario.jpg'; // Cambia esto a la URL de tu imagen predeterminada
    }

    const imagenInput = document.getElementById('imagen_input');

    imagenInput.addEventListener('change', function (event) {
        const archivo = event.target.files[0];

        if (archivo) {
            const reader = new FileReader();
            
            reader.onload = function (e) {
                imagenEquipo.src = e.target.result;
            };

            reader.readAsDataURL(archivo);  
        }
    });

    setTimeout(function() {
        const successMessage = document.getElementById('mensaje-success');
        const errorMessage = document.getElementById('mensaje-error');

        function fadeOut(element) {
            element.style.transition = "opacity 1s ease-out";
            element.style.opacity = 0; 
            setTimeout(function() {
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
