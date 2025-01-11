<?= $this->extend('layout/template_g'); ?>

<?= $this->section('content'); ?>

<div class="con-borde d-flex flex-column bg-white shadow-sm rounded" style="min-height: 100vh;">
    <h2 class="text-center mb-3 text-primary">Formulario de Registro de Equipo</h2>

    <!-- Mostrar mensajes de error -->
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger" id="mensaje-error">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Mostrar mensaje de éxito si existe -->
    <?php if (session()->getFlashdata('mensaje')): ?>
        <div class="alert alert-success" id="mensaje-success">
            <?= esc(session()->getFlashdata('mensaje')) ?>
        </div>
    <?php endif; ?>

    <div class="d-flex align-items-stretch flex-grow-1">
        <form method="POST" action="<?= base_url('registrar'); ?>" autocomplete="off" class="flex-grow-1 px-3 py-2" style="overflow-y: auto;" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <!-- Información General -->
            <div class="mb-3">
                <h5 class="text-secondary">Información General</h5>
            </div>

            <div class="mb-2 d-flex align-items-center flex-wrap">
                <div class="flex-grow-1 me-2 position-relative">
                    <label for="numero_inventario" class="form-label">Número de Inventario:</label>
                    <input type="text" id="numero_inventario" name="numero_inventario" class="form-control <?= isset($errors['numero_inventario']) ? 'is-invalid' : ''; ?>" value="<?= old('numero_inventario') ?>" style="font-size: 0.9rem;">
                    <?php if (isset($errors['numero_inventario'])): ?>
                        <div class="invalid-feedback" style="position: absolute; bottom: -20px; left: 0; width: 100%;"><?= esc($errors['numero_inventario']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="me-2" style="width: 150px;">
                    <label for="estado" class="form-label">Estado:</label>
                    <select id="estado" name="estado" class="form-control <?= isset($errors['estado']) ? 'is-invalid' : ''; ?>" style="font-size: 0.9rem;">
                        <option value="">Seleccione un estado</option>
                        <option value="Activo" <?= old('estado') == 'Activo' ? 'selected' : '' ?>>Activo</option>
                        <option value="Baja" <?= old('estado') == 'Baja' ? 'selected' : '' ?>>Baja</option>
                    </select>
                    <?php if (isset($errors['estado'])): ?>
                        <div class="invalid-feedback"><?= esc($errors['estado']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="ms-2" style="width: 150px;">
                    <label for="imagen_equipo" class="form-label">Imagen del Equipo:</label>
                    <input type="file" id="imagen_input" name="imagen" class="form-control" accept="image/*" style="font-size: 0.9rem;">
                </div>
            </div>

            <br>

            <div class="d-flex mb-2 flex-wrap">
                <div class="flex-grow-1 me-2">
                    <label for="descripcion" class="form-label">Descripción:</label>
                    <textarea id="descripcion" name="descripcion" class="form-control <?= isset($errors['descripcion']) ? 'is-invalid' : ''; ?>" rows="2" placeholder="Ingrese una descripción aquí..." style="font-size: 0.9rem;"><?= old('descripcion') ?></textarea>
                    <?php if (isset($errors['descripcion'])): ?>
                        <div class="invalid-feedback"><?= esc($errors['descripcion']) ?></div>
                    <?php endif; ?>
                </div>

                <div style="width: 150px;">
                    <label for="id_marcas" class="form-label">Marca:</label>
                    <select id="id_marcas" name="id_marcas" class="form-control <?= isset($errors['id_marcas']) ? 'is-invalid' : ''; ?>" style="font-size: 0.9rem;">
                        <option value="">Seleccione una marca</option>
                        <?php foreach ($marcas as $marca): ?>
                            <option value="<?= esc($marca['id_marcas']) ?>" <?= old('id_marcas') == $marca['id_marcas'] ? 'selected' : '' ?>><?= esc($marca['nombre_marca']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($errors['id_marcas'])): ?>
                        <div class="invalid-feedback"><?= esc($errors['id_marcas']) ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="d-flex mb-2">
                <div class="flex-grow-1 me-2">
                    <label for="modelo" class="form-label">Modelo:</label>
                    <input type="text" id="modelo" name="modelo" class="form-control <?= isset($errors['modelo']) ? 'is-invalid' : ''; ?>" value="<?= old('modelo') ?>" placeholder="Ingrese el modelo..." style="font-size: 0.9rem;">
                    <?php if (isset($errors['modelo'])): ?>
                        <div class="invalid-feedback"><?= esc($errors['modelo']) ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="d-flex mb-2 flex-wrap">
                <div class="me-2" style="width: 150px;">
                    <label for="id_tipo_equipo" class="form-label">Tipo de Equipo:</label>
                    <select id="id_tipo_equipo" name="id_tipo_equipo" class="form-control <?= isset($errors['id_tipo_equipo']) ? 'is-invalid' : ''; ?>" style="font-size: 0.9rem;">
                        <option value="">Seleccione un tipo de equipo</option>
                        <?php foreach ($tipo_equipo as $tipo): ?>
                            <option value="<?= esc($tipo['id_tipo_equipo']) ?>" <?= old('id_tipo_equipo') == $tipo['id_tipo_equipo'] ? 'selected' : '' ?>><?= esc($tipo['nombre_tipo_equipo']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($errors['id_tipo_equipo'])): ?>
                        <div class="invalid-feedback"><?= esc($errors['id_tipo_equipo']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="me-2" style="width: 150px;">
                    <label for="numero_serie" class="form-label">N° de Serie:</label>
                    <input type="text" id="numero_serie" name="numero_serie" class="form-control" value="<?= old('numero_serie') ?>" placeholder="Número de serie" style="font-size: 0.9rem;">
                </div>

                <div style="width: 150px;">
                    <label for="ano_fabricacion" class="form-label">Año de Fabricación:</label>
                    <input type="number" id="ano_fabricacion" name="ano_fabricacion" class="form-control <?= isset($errors['ano_fabricacion']) ? 'is-invalid' : ''; ?>" value="<?= old('ano_fabricacion') ?>" placeholder="Año" min="1900" style="font-size: 0.9rem;">
                    <?php if (isset($errors['ano_fabricacion'])): ?>
                        <div class="invalid-feedback"><?= esc($errors['ano_fabricacion']) ?></div>
                    <?php endif; ?>
                </div>

                <div style="width: 150px;">
                    <label for="vida_util" class="form-label">Vida Útil:</label>
                    <input type="number" id="vida_util" name="vida_util" class="form-control <?= isset($errors['vida_util']) ? 'is-invalid' : ''; ?>" value="<?= old('vida_util') ?>" placeholder="Vida útil" min="0" style="font-size: 0.9rem;">
                    <?php if (isset($errors['vida_util'])): ?>
                        <div class="invalid-feedback"><?= esc($errors['vida_util']) ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <hr>

            <!-- Información de Compra -->
            <div class="mb-2">
                <h5 class="text-secondary">Información de Compra</h5>
            </div>

            <div class="d-flex mb-2 flex-wrap">
                <div class="me-2" style="width: 150px;">
                    <label for="fecha_alta" class="form-label">Fecha de Alta:</label>
                    <input type="date" id="fecha_alta" name="fecha_alta" class="form-control" value="<?= old('fecha_alta') ?>" style="font-size: 0.9rem;">
                </div>

                <div style="width: 150px;">
                    <label for="valor_adquisicion" class="form-label">Valor de Adquisición:</label>
                    <input type="number" id="valor_adquisicion" name="valor_adquisicion" class="form-control <?= isset($errors['valor_adquisicion']) ? 'is-invalid' : ''; ?>" value="<?= old('valor_adquisicion') ?>" placeholder="Valor en $" style="font-size: 0.9rem;">
                    <?php if (isset($errors['valor_adquisicion'])): ?>
                        <div class="invalid-feedback"><?= esc($errors['valor_adquisicion']) ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <hr>

            <!-- Pertenencia -->
            <div class="mb-2">
                <h5 class="text-secondary">Pertenencia</h5>
            </div>

            <div class="d-flex mb-2 flex-wrap">
                <div class="me-2" style="width: 150px;">
                    <label for="id_responsable" class="form-label">Responsable:</label>
                    <select id="id_responsable" name="id_responsable" class="form-control <?= isset($errors['id_responsable']) ? 'is-invalid' : ''; ?>" style="font-size: 0.9rem;">
                        <option value="">Seleccione un responsable</option>
                        <?php foreach ($responsables as $responsable): ?>
                            <option value="<?= esc($responsable['id_responsable']) ?>" <?= old('id_responsable') == $responsable['id_responsable'] ? 'selected' : '' ?>><?= esc($responsable['nombre_responsable']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($errors['id_responsable'])): ?>
                        <div class="invalid-feedback"><?= esc($errors['id_responsable']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="me-2" style="width: 150px;">
                    <label for="seccion" class="form-label">Sección:</label>
                    <input type="text" id="seccion" name="seccion" class="form-control" value="<?= old('seccion') ?>" placeholder="Nombre de la sección" style="font-size: 0.9rem;">
                </div>

                <div style="width: 150px;">
                    <label for="dependencia" class="form-label">Dependencia:</label>
                    <input type="text" id="dependencia" name="dependencia" class="form-control" value="<?= old('dependencia') ?>" placeholder="Dependencia" style="font-size: 0.9rem;">
                </div>
            </div>

            <div class="mb-2">
                <label for="comentarios" class="form-label">Comentario:</label>
                <textarea id="comentarios" name="comentarios" class="form-control" rows="2" placeholder="Ingrese un comentario aquí..." style="font-size: 0.9rem;"><?= old('comentarios') ?></textarea>
            </div>

            <div class="text-center mt-3 d-flex justify-content-center w-100">
                <button type="submit" class="btn btn-success btn-lg px-5 me-5" style="font-size: 0.9rem;">Registrar</button>
                <a href="<?= base_url('Home'); ?>" class="btn btn-danger btn-lg px-5 text-white" style="font-size: 0.9rem;">Cancelar</a>
            </div>
        </form>

        <!-- Imagen de Equipo -->
        <div class="ms-3 text-center" style="flex-shrink: 0; width: 235px; position: relative;">
            <div class="position-relative" style="width: 100%; height: 200px;">
                <img id="imagen_equipo" 
                    src="https://2.bp.blogspot.com/-Xfmhk1tfniM/W3c8iSrhQLI/AAAAAAAApQg/ThaakYPo1_oGrKTxODFUMFHF5BuyUb5lACLcBGAs/s1600/inventario.jpg" 
                    alt="Imagen del equipo" 
                    style="width: 100%; height: 100%; object-fit: cover; border: 1px solid #ddd; border-radius: 8px; padding: 5px;">
            </div>
            <br><br>
            <div class="text-center">
                <a href="<?= base_url('formulario'); ?>" class="btn btn-warning btn-lg px-5 text-white" style="font-size: 0.9rem;">Nuevo Registro</a>
            </div>
        </div>
    </div>
</div>


<!-- Javascript-->
<script>
    const baseUrl = "<?= base_url('obtenerEquipo') ?>";
</script>

<?= $this->endSection(); ?>
