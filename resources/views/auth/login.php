<?php
$title = 'Login - Casillero Digital';
$alert = '';
$alertClass = 'danger';

if (old_query('error') === 'campos_vacios') {
    $alert = 'Por favor, complete todos los campos obligatorios.';
} elseif (old_query('error') === 'credenciales_invalidas') {
    $alert = 'El correo electronico o la contrasena son incorrectos.';
} elseif (old_query('msg') === 'registro_exitoso') {
    $alert = 'Registro completado con exito. Ya puede ingresar al sistema.';
    $alertClass = 'success';
} elseif (old_query('msg') === 'sesion_cerrada') {
    $alert = 'Ha cerrado su sesion correctamente.';
    $alertClass = 'info';
}

ob_start();
?>
<div class="container">
    <div class="card login-card p-4">
        <div class="text-center mb-4">
            <img src="<?= asset('img/poderjudicial.png') ?>" alt="Logo PJ" width="80">
            <h5 class="mt-3 text-pj-blue">Casillero Digital</h5>
            <p class="text-muted small">Acceso Ciudadano</p>
        </div>
        <?php if ($alert): ?>
            <div class="alert alert-<?= $alertClass ?> alert-dismissible fade show" role="alert">
                <?= e($alert) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <form action="<?= url('/login') ?>" method="POST">
            <div class="mb-3">
                <label class="form-label fw-bold small text-secondary">Correo Electronico</label>
                <input type="email" name="correo" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold small text-secondary">Contrasena</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-pj-blue w-100 py-2 fw-bold">
                <i class="bi bi-box-arrow-in-right me-2"></i>INGRESAR
            </button>
            <div class="mt-4 text-center">
                <a href="<?= url('/recuperar') ?>" class="text-decoration-none small text-pj-blue">Olvido su contrasena?</a>
                <hr>
                <p class="small text-secondary">No tiene cuenta? <a href="<?= url('/registro') ?>" class="text-pj-gold fw-bold text-decoration-none">Registrese aqui</a></p>
            </div>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();
require dirname(__DIR__) . '/layouts/guest.php';
