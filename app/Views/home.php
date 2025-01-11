<?= $this->extend('layout/template_h'); ?>

<?= $this->section('content'); ?>

<div class="container mt-3"> 
    <div class="d-flex justify-content-between align-items-center mb-2"> 
        <h1 class="text-center fs-4">Listado de Equipamiento</h1> 
        <div class="d-flex">
           
            <a href="<?= base_url('formulario'); ?>" class="btn btn-success btn-sm">Nuevo Registro</a> 

           
            <div class="dropdown ms-2">
                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    Páginas
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item" href="<?= base_url('marcas'); ?>">Listado Marcas</a></li>
                    <li><a class="dropdown-item" href="<?= base_url('responsable'); ?>">Listado Responsables</a></li>
                </ul>
            </div>

           
            <a href="<?= base_url('logout'); ?>" class="btn btn-primary btn-sm ms-2">Cerrar</a> 
        </div>
    </div>

    <table class="table table-striped table-sm" id="responsablesTable"> 
        <thead class="table-dark">
            <tr>
                <th>N° Inventario</th> 
                <th>Descripción</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Año</th> 
                <th>Responsable</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($equipos)): ?>
            <?php foreach ($equipos as $equipo): ?>
                <tr>
                    <td><?= esc($equipo['numero_inventario']); ?></td>
                    <td><?= esc($equipo['descripcion']); ?></td>
                    <td><?= esc($equipo['nombre_marca']); ?></td>
                    <td><?= esc($equipo['modelo']); ?></td>
                    <td><?= esc($equipo['ano_fabricacion']); ?></td>
                    <td><?= esc($equipo['nombre_responsable']); ?></td>
                    <td><?= esc($equipo['estado']); ?></td>
                    <td>
                        <a href="<?= base_url('editar/' . $equipo['id_formulario']) ?>" class="btn btn-warning btn-sm" style="font-size: 0.9rem; color: black;">Editar</a>


                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="8" class="text-center">No hay registros disponibles.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection(); ?>
