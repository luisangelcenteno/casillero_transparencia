<?php $title = 'Nueva Solicitud'; ob_start(); ?>
<div class="container py-4">
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <?php if (old_query('error') === 'datos_incompletos'): ?>
                <div class="alert alert-danger">Debe seleccionar al menos una sede judicial y redactar el sustento.</div>
            <?php endif; ?>
            <h4 class="mb-4 text-pj-blue"><i class="bi bi-file-earmark-text-fill me-2"></i>Nueva Solicitud de Transparencia</h4>
            <form action="<?= url('/solicitudes') ?>" method="POST" enctype="multipart/form-data">
                <div class="section-header">1. Sedes Judiciales</div>
                <div class="court-scroll shadow-sm">
                    <?php foreach ($cortes as $c): ?>
                        <div class="form-check py-1 border-bottom">
                            <input class="form-check-input chk-corte" type="checkbox" name="cortes[]" value="<?= e($c['c_corte']) ?>" id="ct_<?= e($c['c_corte']) ?>">
                            <label class="form-check-label small" for="ct_<?= e($c['c_corte']) ?>"><?= e($c['x_corte']) ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="section-header">2. Datos de Contacto y Ubicacion</div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Departamento</label>
                        <select name="c_departamento" id="c_departamento" class="form-select form-select-sm" required>
                            <option value="">Seleccione...</option>
                            <?php foreach ($departamentos as $d): ?><option value="<?= e($d['c_departamento']) ?>"><?= e($d['x_departamento']) ?></option><?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4"><label class="form-label small fw-bold">Provincia</label><select name="c_provincia" id="c_provincia" class="form-select form-select-sm" required disabled></select></div>
                    <div class="col-md-4"><label class="form-label small fw-bold">Distrito</label><select name="c_distrito" id="c_distrito" class="form-select form-select-sm" required disabled></select></div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Tipo de Via</label>
                        <select name="c_tipo_via" class="form-select form-select-sm" required><?php foreach ($vias as $v): ?><option value="<?= e($v['c_tipo_via']) ?>"><?= e($v['x_tipo_via']) ?></option><?php endforeach; ?></select>
                    </div>
                    <div class="col-md-8"><label class="form-label small fw-bold">Nombre de Via</label><input type="text" name="x_nombre_via" class="form-control form-control-sm" required></div>
                    <div class="col-md-12"><label class="form-label small fw-bold">Referencia</label><input type="text" name="x_referencia" class="form-control form-control-sm"></div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Tipo de Zona</label>
                        <select name="c_tipo_zona" class="form-select form-select-sm" required><?php foreach ($zonas as $z): ?><option value="<?= e($z['c_tipo_zona']) ?>"><?= e($z['x_tipo_zona']) ?></option><?php endforeach; ?></select>
                    </div>
                    <div class="col-md-4"><label class="form-label small fw-bold">Telefono</label><input type="text" name="x_telefono" class="form-control form-control-sm" maxlength="7"></div>
                    <div class="col-md-4"><label class="form-label small fw-bold">Celular</label><input type="text" name="x_celular" class="form-control form-control-sm" maxlength="9" required></div>
                </div>

                <div class="section-header">3. Detalle de la Solicitud</div>
                <textarea name="x_sustentacion" class="form-control" rows="6" required></textarea>

                <div class="section-header">4. Documentos Anexos</div>
                <input type="file" name="anexos[]" class="form-control form-control-sm" multiple accept=".jpg,.png,.pdf,.doc,.docx,.xls,.xlsx">

                <div class="text-end mt-4">
                    <a href="<?= url('/dashboard') ?>" class="btn btn-light border me-2">Cancelar</a>
                    <button type="submit" class="btn btn-pj-blue px-5 fw-bold"><i class="bi bi-send-fill me-2"></i>Presentar Solicitud</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
ob_start();
?>
<script>
document.getElementById('c_departamento').addEventListener('change', function() {
    fetch('<?= url('/ubigeo') ?>?dep=' + this.value).then(r => r.json()).then(data => {
        const select = document.getElementById('c_provincia');
        select.innerHTML = '<option value="">Seleccione Provincia...</option>';
        data.forEach(p => select.innerHTML += `<option value="${p.c_provincia}">${p.x_provincia}</option>`);
        select.disabled = false;
        document.getElementById('c_distrito').disabled = true;
    });
});
document.getElementById('c_provincia').addEventListener('change', function() {
    fetch('<?= url('/ubigeo') ?>?prov=' + this.value).then(r => r.json()).then(data => {
        const select = document.getElementById('c_distrito');
        select.innerHTML = '<option value="">Seleccione Distrito...</option>';
        data.forEach(d => select.innerHTML += `<option value="${d.c_distrito}">${d.x_distrito}</option>`);
        select.disabled = false;
    });
});
</script>
<?php $scripts = ob_get_clean(); require dirname(__DIR__) . '/layouts/app.php'; ?>
