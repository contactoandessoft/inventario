<?= $this->extend('layout/template_c'); ?>

<?= $this->section('content'); ?>

<div class="container mt-3"> 
    <div class="d-flex justify-content-between align-items-center mb-2"> 
        <h1 class="text-center fs-4">Listado de Responsables</h1> 
        <div class="d-flex">
            <a href="<?= base_url('responsableform'); ?>" class="btn btn-success btn-sm">Nuevo Registro</a>

            <div class="dropdown ms-2">
                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    Páginas
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item" href="<?= base_url('home'); ?>">Listado Equipamiento</a></li>
                    <li><a class="dropdown-item" href="<?= base_url('marcas'); ?>">Listado Marcas</a></li>
                </ul>
            </div>
            
            <a href="<?= base_url('logout'); ?>" class="btn btn-primary btn-sm ms-2">Cerrar Sesión</a>
        </div>
    </div>

    <!-- Mensajes de éxito o error -->
    <?php if (session()->getFlashdata('error')): ?>
        <div id="mensaje-error" class="alert alert-danger">
            <?= session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <div id="mensaje-success" class="alert alert-success">
            <?= session()->getFlashdata('success'); ?>
        </div>
    <?php endif; ?>

    <table class="table table-striped table-sm" id="responsablesTable"> 
        <thead class="table-dark">
            <tr>
                <th>Nombre del Responsable</th>
                <th>Vigencia</th>
                <th>Fecha de Auditoría</th>
                <th>Nombre de Usuario</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($responsables)): ?>
            <?php foreach ($responsables as $responsable): ?>
                <tr>
                    <td><?= esc($responsable['nombre_responsable']); ?></td>
                    <td><?= esc($responsable['vigencia'] == 1 ? 'Activo' : 'Baja'); ?></td>
                    <td><?= esc($responsable['fecha_audita'] ?? 'No disponible'); ?></td>
                    <td><?= esc($responsable['nombre_usuario'] ?? 'Desconocido'); ?></td>
                    <td>
                    <a href="<?= site_url('editarresponsable/' . $responsable['id_responsable']); ?>" class="btn btn-warning btn-sm">Editar</a>
                    <a href="<?= base_url('responsable/eliminar/' . $responsable['id_responsable']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este responsable?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="text-center">No hay registros disponibles.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Javascript-->
<script src="<?= base_url('js/borrar-mensajes.js') ?>"></script>



<?= $this->endSection(); ?>
