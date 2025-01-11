<?= $this->extend('layout/template_e'); ?>

<?= $this->section('content'); ?>
<div class="con-borde d-flex flex-column bg-white shadow-sm rounded" style="max-width: 700px; margin: 0 auto; min-height: auto;">
    <h2 class="text-center mb-2 text-primary" style="font-size: 1.5rem;">Formulario de Registro de Marcas</h2>

    <!-- Mostrar mensajes de error o éxito -->
    <?php if (session()->getFlashdata('success')): ?>
        <div id="mensaje-success" class="alert alert-success">
            <?= session()->getFlashdata('success'); ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('errors')): ?>
        <div id="mensaje-error" class="alert alert-danger">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="d-flex align-items-stretch flex-grow-1">
        <form method="POST" action="marcasform/registrar" autocomplete="off" class="flex-grow-1 px-2 py-2" style="overflow-y: auto;">
            <?= csrf_field() ?>
            <input type="hidden" id="id_marcas" name="id_marcas" value="<?= old('id_marcas', isset($marca) ? $marca['id_marcas'] : '') ?>">

            <!-- Información del Responsable -->
            <div class="mb-2">
                <h5 class="text-secondary" style="font-size: 1.1rem;">Información del Responsable</h5>
            </div>
            
            <div class="mb-2">
                <label for="nombre_marca" class="form-label">Nombre de la marca:</label>
                <input type="text" id="nombre_marca" name="nombre_marca" class="form-control form-control-sm" value="<?= old('nombre_marca', isset($marca) ? $marca['nombre_marca'] : '') ?>"/>
                <?php if (isset($errors['nombre_marca'])): ?>
                    <div class="text-danger"><?= esc($errors['nombre_marca']) ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-2">
                <label for="vigencia" class="form-label">Vigencia:</label>
                <select id="vigencia" name="vigencia" class="form-control form-control-sm">
                    <option value="">Seleccione un estado</option>
                    <option value="1" <?= old('vigencia', isset($marca) ? $marca['vigencia'] : '') == '1' ? 'selected' : '' ?>>Activo</option>
                    <option value="0" <?= old('vigencia', isset($marca) ? $marca['vigencia'] : '') == '0' ? 'selected' : '' ?>>Baja</option>
                </select>
                <?php if (isset($errors['vigencia'])): ?>
                    <div class="text-danger"><?= esc($errors['vigencia']) ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-2">
                <label for="fecha_audita" class="form-label">Fecha de Auditoría:</label>
                <input type="date" id="fecha_audita" name="fecha_audita" class="form-control form-control-sm" value="<?= old('fecha_audita', isset($marca) ? $marca['fecha_audita'] : '') ?>"/>
                <?php if (isset($errors['fecha_audita'])): ?>
                    <div class="text-danger"><?= esc($errors['fecha_audita']) ?></div>
                <?php endif; ?>
            </div>

            <hr>

            <div class="mb-2">
                <h5 class="text-secondary" style="font-size: 1.1rem;">Información de Usuario</h5>
            </div>

            <div class="mb-2">
                <label for="id_usuario" class="form-label">Responsable:</label>
                <select id="id_usuario" name="id_usuario" class="form-control form-control-sm">
                    <option value="">Seleccione un Responsable</option>
                    <?php foreach ($usuarios as $usuario): ?>
                        <?php if ($usuario['vigencia'] == 1): ?>
                            <option value="<?= $usuario['id_usuario']; ?>" <?= old('id_usuario', isset($marca) ? $marca['id_usuario'] : '') == $usuario['id_usuario'] ? 'selected' : '' ?>><?= $usuario['nombre_usuario']; ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
                <?php if (isset($errors['id_usuario'])): ?>
                    <div class="text-danger"><?= esc($errors['id_usuario']) ?></div>
                <?php endif; ?>
            </div>

            <!-- Botones de acción -->
            <div class="text-center mt-2 d-flex justify-content-center w-100">
                <button type="submit" class="btn btn-success btn-sm px-4 me-4">Registrar</button>
                <a href="<?= base_url('marcasform'); ?>" class="btn btn-warning btn-sm px-4 text-white me-4">Nuevo Registro</a>
                <a href="<?= base_url('marcas'); ?>" class="btn btn-danger btn-sm px-4 text-white">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<!-- Ajustamos la funcion ObtenerMarca para que funcione con el Javascript -->
<script>
    const obtenerMarcaUrl = "<?= base_url('marcasform/obtenerMarca') ?>";
</script>

<?= $this->endSection(); ?>
