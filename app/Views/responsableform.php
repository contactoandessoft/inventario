<?= $this->extend('layout/template_f'); ?>

<?= $this->section('content'); ?>
<div class="con-borde d-flex flex-column bg-white shadow-sm rounded" style="max-width: 700px; margin: 0 auto; min-height: auto;">
    <h2 class="text-center mb-2 text-primary" style="font-size: 1.5rem;">Formulario de Registro de Responsable</h2>

    <div class="mb-3">
        <?php if (session()->getFlashdata('errors')): ?>
            <div id="mensaje-error" class="alert alert-danger">
                <ul class="list-unstyled m-0">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li class="ms-3"><?= esc($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div id="mensaje-success" class="alert alert-success text-center">
                <?= session()->getFlashdata('success'); ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="d-flex align-items-stretch flex-grow-1">
        <form method="POST" action="<?= site_url('responsableform/registrar'); ?>" autocomplete="off" class="flex-grow-1 px-2 py-2" style="overflow-y: auto;">
            <input type="hidden" id="id_responsable" name="id_responsable" value="<?= old('id_responsable'); ?>">

            <!-- Información del Responsable -->
            <div class="mb-2">
                <h5 class="text-secondary" style="font-size: 1.1rem;">Información del Responsable</h5>
            </div>

            <div class="mb-2">
                <label for="nombre_responsable" class="form-label">Nombre del Responsable:</label>
                <input type="text" id="nombre_responsable" name="nombre_responsable" class="form-control form-control-sm" value="<?= old('nombre_responsable'); ?>">
            </div>

            <div class="mb-2">
                <label for="vigencia" class="form-label">Vigencia:</label>
                <select id="vigencia" name="vigencia" class="form-control form-control-sm">
                    <option value="">Seleccione un estado</option>
                    <option value="activo" <?= old('vigencia') == 'activo' ? 'selected' : ''; ?>>Activo</option>
                    <option value="baja" <?= old('vigencia') == 'baja' ? 'selected' : ''; ?>>Baja</option>
                </select>
            </div>

            <div class="mb-2">
                <label for="fecha_audita" class="form-label">Fecha de Auditoría:</label>
                <input type="date" id="fecha_audita" name="fecha_audita" class="form-control form-control-sm" value="<?= old('fecha_audita'); ?>"/>
            </div>

            <hr>

            <div class="mb-2">
                <h5 class="text-secondary" style="font-size: 1.1rem;">Información de Usuario</h5>
            </div>

            <div class="mb-2">
                <label for="id_usuario" class="form-label">Usuario:</label>
                <select id="id_usuario" name="id_usuario" class="form-control form-control-sm">
                    <option value="">Seleccione un Usuario</option>
                    <?php foreach ($usuarios as $usuario): ?>
                        <option value="<?= $usuario['id_usuario']; ?>" <?= old('id_usuario') == $usuario['id_usuario'] ? 'selected' : ''; ?>>
                            <?= $usuario['nombre_usuario']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Botones de acción -->
            <div class="text-center mt-2 d-flex justify-content-center w-100">
                <button type="submit" class="btn btn-success btn-sm px-4 me-4">Registrar</button>
                <a href="<?= base_url('responsableform'); ?>" class="btn btn-warning btn-sm px-4 text-white me-4">Nuevo Registro</a>
                <a href="<?= base_url('responsable'); ?>" class="btn btn-danger btn-sm px-4 text-white">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>
