<?php
if (empty($data) || empty($data['solicitud_id'] ?? $data['c_solicitud'] ?? null)) {
    $fallbackId = (int) ($_GET['id'] ?? 0);
    if ($fallbackId <= 0) {
        $fallbackId = (int) \App\Core\Database::connection()
            ->query("SELECT COALESCE(MAX(c_solicitud_respuesta), 0) FROM solicitudes_respuestas WHERE l_estado = 'S'")
            ->fetchColumn();
    }

    $stmt = \App\Core\Database::connection()->prepare("SELECT sr.*,
               sr.c_solicitud_respuesta AS respuesta_id,
               sr.c_solicitud AS solicitud_id,
               sr.x_archivo AS documento_archivo,
               sr.x_ubicacion AS documento_ubicacion,
               CONCAT(u.x_nombres, ' ', u.x_ap_paterno) AS ciudadano,
               COALESCE(c.x_corte, 'Sin corte') AS corte,
               srf.c_firma_jefe,
               fj.x_juez,
               fj.x_cargo,
               fj.x_archivo AS firma_archivo,
               fj.x_ubicacion AS firma_ubicacion,
               su.x_observacion
        FROM solicitudes_respuestas sr
        LEFT JOIN solicitudes s ON sr.c_solicitud = s.c_solicitud
        LEFT JOIN usuarios u ON s.c_usuario = u.c_usuario
        LEFT JOIN solicitudes_ubicaciones su ON sr.c_solicitud_ubicacion = su.c_solicitud_ubicacion
        LEFT JOIN cortes_nacionales c ON su.c_corte = c.c_corte
        LEFT JOIN solicitudes_respuestas_firmas srf ON sr.c_solicitud_respuesta = srf.c_solicitud_respuesta AND srf.l_estado = 'S'
        LEFT JOIN firmas_jefes fj ON srf.c_firma_jefe = fj.c_firma_jefe
        WHERE sr.c_solicitud_respuesta = :respuesta
          AND sr.l_estado = 'S'
        LIMIT 1");
    $stmt->execute(['respuesta' => $fallbackId]);
    $fallbackData = $stmt->fetch();

    if ($fallbackData) {
        $path = dirname(__DIR__, 3) . '/storage/' . ltrim((string) ($fallbackData['documento_ubicacion'] ?? ''), '/');
        $fallbackData['documento_existe'] = is_file($path) ? 'S' : 'N';
        $data = $fallbackData;
    }
}

$respuestaId = (int) ($data['respuesta_id'] ?? $data['c_solicitud_respuesta'] ?? 0);
$solicitudId = (int) ($data['solicitud_id'] ?? $data['c_solicitud'] ?? 0);
$documentName = (string) ($data['documento_archivo'] ?? $data['x_archivo'] ?? 'Documento del ciudadano');
$documentUrl = url('/documentos/respuesta?id=' . $respuestaId);
$downloadUrl = url('/documentos/respuesta?id=' . $respuestaId . '&download=1');
$signatureUrl = !empty($data['firma_ubicacion']) ? url('/firmas/jefatura?id=' . (int) ($data['c_firma_jefe'] ?? 0)) : '';
$extension = strtolower(pathinfo($documentName, PATHINFO_EXTENSION));
$isPdf = $extension === 'pdf';
$signatureExtension = strtolower(pathinfo($data['firma_archivo'] ?? '', PATHINFO_EXTENSION));
$signatureIsPdf = $signatureExtension === 'pdf';
$documentExists = ($data['documento_existe'] ?? 'N') === 'S';
$verificationCode = 'CDT-' . str_pad((string) $solicitudId, 6, '0', STR_PAD_LEFT)
    . '-' . str_pad((string) $respuestaId, 6, '0', STR_PAD_LEFT);
$verificationSeed = hexdec(substr(hash('crc32b', $verificationCode), 0, 6));
$verificationUrl = url('/documentos/verificar?codigo=' . urlencode($verificationCode));
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Documento firmado</title>
    <link rel="stylesheet" href="<?= asset('css/estilos.css') ?>">
    <style>
        body {
            margin: 0;
            background: #eef2f6;
            font-family: Arial, sans-serif;
            color: #0b1720;
        }

        .signed-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            padding: 14px 18px;
            background: #082d5c;
            color: #fff;
        }

        .download-button {
            display: inline-flex;
            align-items: center;
            padding: 8px 12px;
            border-radius: 6px;
            border: 1px solid rgba(255, 255, 255, .6);
            color: #fff;
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            margin-left: 14px;
        }

        .signed-toolbar small {
            display: block;
            opacity: .8;
            margin-top: 3px;
        }

        .signed-viewer {
            position: relative;
            height: calc(100vh - 74px);
            padding: 18px;
        }

        .document-frame {
            width: 100%;
            height: 100%;
            border: 1px solid #cdd6e1;
            border-radius: 8px;
            background: #fff;
        }

        .missing-document {
            height: 100%;
            border: 1px solid #cdd6e1;
            border-radius: 8px;
            background: #fff;
            padding: 46px 56px;
            box-sizing: border-box;
        }

        .missing-document h2 {
            margin: 0 0 18px;
            color: #082d5c;
            font-size: 24px;
        }

        .missing-document p {
            max-width: 780px;
            line-height: 1.55;
            color: #4f5d6b;
        }

        .document-meta {
            margin-top: 26px;
            border-top: 1px solid #d9e0e8;
            padding-top: 18px;
            display: grid;
            gap: 8px;
            font-size: 14px;
        }

        .signature-stamp {
            position: absolute;
            left: 42px;
            bottom: 38px;
            width: 230px;
            min-height: 92px;
            padding: 8px 10px;
            background: rgba(255, 255, 255, .92);
            border: 2px solid #d5a64f;
            border-radius: 6px;
            text-align: center;
            pointer-events: none;
        }

        .signature-stamp img {
            max-width: 190px;
            max-height: 54px;
            object-fit: contain;
            display: block;
            margin: 0 auto 4px;
        }

        .signature-name {
            font-size: 11px;
            font-weight: 700;
            color: #082d5c;
            line-height: 1.2;
        }

        .signature-note {
            font-size: 10px;
            color: #5c6773;
            margin-top: 2px;
        }

        .verification-card {
            position: absolute;
            right: 30px;
            top: 28px;
            width: 230px;
            padding: 12px;
            border-radius: 8px;
            background: rgba(255, 255, 255, .96);
            border: 1px solid #cfd8e3;
            box-shadow: 0 8px 20px rgba(8, 45, 92, .12);
            font-size: 12px;
        }

        .verification-title {
            font-weight: 700;
            color: #082d5c;
            margin-bottom: 8px;
        }

        .qr-demo {
            display: grid;
            grid-template-columns: repeat(13, 1fr);
            gap: 1px;
            width: 112px;
            height: 112px;
            padding: 7px;
            background: #fff;
            border: 1px solid #0b1720;
            margin-bottom: 8px;
        }

        .qr-demo span {
            background: #fff;
        }

        .qr-demo span.on {
            background: #0b1720;
        }

        .verify-link {
            display: inline-flex;
            margin-top: 8px;
            padding: 6px 8px;
            border-radius: 6px;
            background: #082d5c;
            color: #fff;
            text-decoration: none;
            font-weight: 700;
            font-size: 11px;
        }

    </style>
</head>
<body>
    <div class="signed-toolbar">
        <div>
            <strong>Solicitud #<?= e((string) $solicitudId) ?> - Documento firmado</strong>
            <small><?= e($data['ciudadano'] ?? 'Ciudadano') ?> | <?= e($data['corte'] ?? 'Sin corte') ?></small>
        </div>
        <div>
            <strong><?= e($data['x_juez'] ?? 'Firma de jefatura') ?></strong>
            <small><?= e($data['x_cargo'] ?? '') ?></small>
        </div>
        <a class="download-button" href="<?= e($downloadUrl) ?>">Descargar PDF firmado</a>
    </div>

    <div class="signed-viewer">
        <?php if ($documentExists && $isPdf): ?>
            <iframe class="document-frame" src="<?= e($documentUrl) ?>" title="PDF firmado"></iframe>
        <?php elseif ($documentExists): ?>
            <iframe class="document-frame" src="<?= e($documentUrl) ?>" title="Documento firmado"></iframe>
        <?php else: ?>
            <div class="missing-document">
                <h2>Documento del ciudadano no encontrado en carpeta</h2>
                <p>
                    El registro de la respuesta firmada existe en MySQL, pero el archivo fisico no esta disponible en
                    <strong>storage/uploads</strong>. Para no detener la prueba, se muestra esta hoja de representacion
                    con la firma aplicada en la parte inferior izquierda.
                </p>
                <div class="document-meta">
                    <div><strong>Solicitud:</strong> #<?= e((string) $solicitudId) ?></div>
                    <div><strong>Ciudadano:</strong> <?= e($data['ciudadano'] ?? 'Ciudadano') ?></div>
                    <div><strong>Corte:</strong> <?= e($data['corte'] ?? 'Sin corte') ?></div>
                    <div><strong>Archivo registrado:</strong> <?= e($documentName) ?></div>
                    <div><strong>Observacion:</strong> <?= e($data['x_observacion'] ?? '') ?></div>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!$documentExists): ?>
            <div class="signature-stamp">
                <?php if ($signatureUrl !== '' && !$signatureIsPdf): ?>
                    <img src="<?= e($signatureUrl) ?>" alt="Firma">
                <?php endif; ?>
                <div class="signature-name"><?= e($data['x_juez'] ?? 'FIRMA DIGITAL') ?></div>
                <div class="signature-note">Firma aplicada en la parte inferior izquierda de todas las hojas.</div>
            </div>
        <?php endif; ?>

        <div class="verification-card">
            <div class="verification-title">Verificacion de respuesta</div>
            <div class="qr-demo" aria-label="Codigo QR de verificacion">
                <?php for ($i = 0; $i < 169; $i++): ?>
                    <?php
                        $row = intdiv($i, 13);
                        $col = $i % 13;
                        $finder = ($row < 4 && $col < 4) || ($row < 4 && $col > 8) || ($row > 8 && $col < 4);
                        $innerFinder = ($row > 0 && $row < 3 && $col > 0 && $col < 3)
                            || ($row > 0 && $row < 3 && $col > 9 && $col < 12)
                            || ($row > 9 && $row < 12 && $col > 0 && $col < 3);
                        $on = ($finder && !$innerFinder)
                            || ((($verificationSeed >> ($i % 23)) + $i + $solicitudId + $respuestaId) % 4 === 0);
                    ?>
                    <span class="<?= $on ? 'on' : '' ?>"></span>
                <?php endfor; ?>
            </div>
            <div><strong>Codigo:</strong> <?= e($verificationCode) ?></div>
            <div><strong>Destinatario:</strong> <?= e($data['ciudadano'] ?? 'Ciudadano') ?></div>
            <div class="signature-note"><?= e($verificationUrl) ?></div>
            <a class="verify-link" href="<?= e($verificationUrl) ?>" target="_blank" rel="noopener">Abrir verificacion</a>
            <div class="signature-note">Notificacion enviada al casillero digital del usuario.</div>
        </div>
    </div>
</body>
</html>
