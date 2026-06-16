<?php
$title = 'Recuperar Acceso';
$mensaje = '';
$clase = 'alert-danger';

if (old_query('error') === 'email_no_encontrado') {
    $mensaje = 'El correo ingresado no se encuentra registrado en el sistema.';
} elseif (old_query('msg') === 'correo_enviado') {
    $mensaje = 'Se generaron las instrucciones de recuperacion para su correo.';
    $clase = 'alert-success';
}

ob_start();
?>
<div class="container">
    <div class="row justify-content-center align-items-center vh-100">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-pj-blue text-center py-4 rounded-top-4">
                    <img src="<?= asset('img/poderjudicial.png') ?>" alt="Logo PJ" width="60">
                    <h5 class="text-white mt-3 mb-0">Recuperar Acceso</h5>
                </div>
                <div class="card-body p-4">
                    <?php if ($mensaje): ?><div class="alert <?= $clase ?>"><?= e($mensaje) ?></div><?php endif; ?>
                    <form action="<?= url('/recuperar') ?>" method="POST">
                        <label class="form-label fw-bold small text-secondary">Correo Electronico</label>
                        <input type="email" name="correo" class="form-control mb-4" required>
                        <button type="submit" class="btn btn-pj-blue w-100 py-2 fw-bold">ENVIAR INSTRUCCIONES</button>
                        <div class="mt-4 text-center"><a href="<?= url('/login') ?>" class="text-decoration-none small text-pj-blue fw-bold">Volver al inicio de sesion</a></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); require dirname(__DIR__) . '/layouts/guest.php'; ?>
