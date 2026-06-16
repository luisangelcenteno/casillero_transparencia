<?php $title = 'Registro - Casillero Digital'; ob_start(); ?>
<div class="container py-5">
    <div class="card shadow mx-auto" style="max-width: 700px; border-top: 5px solid var(--pj-gold);">
        <div class="card-body p-5">
            <div class="text-center mb-4">
                <img src="<?= asset('img/poderjudicial.png') ?>" width="70" alt="Logo PJ">
                <h3 class="text-pj-blue mt-3">Registro de Usuario</h3>
                <p class="text-muted">Complete sus datos para crear su Casillero Digital</p>
            </div>
            <?php if (old_query('error') === 'password'): ?>
                <div class="alert alert-danger">Las contrasenas no coinciden.</div>
            <?php endif; ?>
            <form action="<?= url('/registro') ?>" method="POST" class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Tipo de Persona</label>
                    <select name="c_tipo_persona" class="form-select" required>
                        <?php foreach ($tiposPersona as $tp): ?>
                            <option value="<?= e($tp['c_tipo_persona']) ?>"><?= e($tp['x_tipo_persona']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Nro. de Documento</label>
                    <input type="text" name="n_documento" class="form-control" required maxlength="20">
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-bold">Nombres</label>
                    <input type="text" name="x_nombres" class="form-control" required maxlength="100">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Apellido Paterno</label>
                    <input type="text" name="x_ap_paterno" class="form-control" required maxlength="50">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Apellido Materno</label>
                    <input type="text" name="x_ap_materno" class="form-control" maxlength="50">
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-bold">Correo Electronico</label>
                    <input type="email" name="x_correo" class="form-control" required maxlength="100">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Contrasena</label>
                    <input type="password" name="x_contrasena" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Confirmar Contrasena</label>
                    <input type="password" name="conf_contrasena" class="form-control" required>
                </div>
                <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-pj-blue w-100 py-2"><i class="bi bi-person-check me-2"></i>Finalizar Registro</button>
                </div>
                <div class="col-12 text-center mt-3">
                    <p class="small">Ya tiene una cuenta? <a href="<?= url('/login') ?>" class="text-pj-gold fw-bold">Inicie sesion aqui</a></p>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); require dirname(__DIR__) . '/layouts/guest.php'; ?>
