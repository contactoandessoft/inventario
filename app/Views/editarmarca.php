<?= $this->extend('layout/template_i'); ?>

<?= $this->section('content'); ?>
<div class="con-borde d-flex flex-column bg-white shadow-sm rounded" style="max-width: 700px; margin: 0 auto; min-height: auto;">
    <h2 class="text-center mb-2 text-primary" style="font-size: 1.5rem;">Formulario de Edición de Marcas</h2>

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
        <form method="POST" action="<?= base_url('editarmarca/actualizar') ?>" autocomplete="off" class="flex-grow-1 px-2 py-2" style="overflow-y: auto;">
            <?= csrf_field() ?>
            <input type="hidden" id="id_marcas" name="id_marcas" value="<?= esc($marca['id_marcas']) ?>">

            <!-- Información del Responsable -->
            <div class="mb-2">
                <h5 class="text-secondary" style="font-size: 1.1rem;">Información del Responsable</h5>
            </div>
            
            <div class="mb-2">
                <label for="nombre_marca" class="form-label">Nombre de la marca:</label>
                <input type="text" id="nombre_marca" name="nombre_marca" class="form-control form-control-sm" value="<?= esc($marca['nombre_marca']) ?>"/>
            </div>

            <div class="mb-2">
                <label for="vigencia" class="form-label">Vigencia:</label>
                <select id="vigencia" name="vigencia" class="form-control form-control-sm">
                    <option value="">Seleccione un estado</option>
                    <option value="1" <?= $marca['vigencia'] == '1' ? 'selected' : '' ?>>Activo</option>
                    <option value="0" <?= $marca['vigencia'] == '0' ? 'selected' : '' ?>>Baja</option>
                </select>
            </div>

            <div class="mb-2">
                <label for="fecha_audita" class="form-label">Fecha de Auditoría:</label>
                <input type="date" id="fecha_audita" name="fecha_audita" class="form-control form-control-sm" value="<?= esc($marca['fecha_audita']) ?>"/>
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
                            <option value="<?= $usuario['id_usuario']; ?>" <?= $marca['id_usuario'] == $usuario['id_usuario'] ? 'selected' : '' ?>><?= $usuario['nombre_usuario']; ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Botones de acción -->
            <div class="text-center mt-2 d-flex justify-content-center w-100">
                <button type="submit" class="btn btn-success btn-sm px-4 me-4">Guardar Cambios</button>
                <a href="<?= base_url('marcas'); ?>" class="btn btn-danger btn-sm px-4 text-white">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<!-- Javascript-->
<script src="<?= base_url('js/borrar-mensajes.js') ?>"></script>


<?= $this->endSection(); ?>
