<?= $this->extend('layout/template_d'); ?>

<?= $this->section('content'); ?>

<div class="container mt-3"> 
    <div class="d-flex justify-content-between align-items-center mb-2"> 
        <h1 class="text-center fs-4">Listado de Marcas</h1> 
        <div class="d-flex">
            <a href="<?= base_url('marcasform'); ?>" class="btn btn-success btn-sm">Nuevo Registro</a>

            <div class="dropdown ms-2">
                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    Paginas
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item" href="<?= base_url('home'); ?>">Listado Equipamiento</a></li>
                    <li><a class="dropdown-item" href="<?= base_url('responsable'); ?>">Listado Responsables</a></li>
                </ul>
            </div>
            
            <a href="<?= base_url('logout'); ?>" class="btn btn-primary btn-sm ms-2">Cerrar Sesión</a>
        </div>
    </div>

    <?php if (session()->getFlashdata('message')): ?>
        <div id="mensaje-success" class="alert alert-success">
            <?= session()->getFlashdata('message') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div id="mensaje-error" class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <table class="table table-striped table-sm" id="marcasTable"> 
        <thead class="table-dark">
            <tr>
                <th>Nombre de Marca</th>
                <th>Vigencia</th>
                <th>Fecha de Auditoría</th>
                <th>Nombre de Usuario</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($marcas)): ?>
            <?php foreach ($marcas as $marca): ?>
                <tr>
                    <td><?= esc($marca['nombre_marca']); ?></td>
                    <td><?= esc($marca['vigencia'] == 1 ? 'Activo' : 'Baja'); ?></td>
                    <td><?= esc($marca['fecha_audita']); ?></td>
                    <td><?= esc($marca['nombre_usuario']); ?></td>
                    <td>
                        <a href="<?= base_url('editarmarca/' . $marca['id_marcas']); ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="<?= base_url('marcas/eliminar/' . $marca['id_marcas']); ?>" 
                           class="btn btn-danger btn-sm" 
                           onclick="return confirm('¿Estás seguro de que deseas eliminar esta marca?');">Borrar</a>
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
