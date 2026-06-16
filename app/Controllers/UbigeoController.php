<?php

namespace App\Controllers;

use App\Models\Catalog;

class UbigeoController
{
    public function index(): void
    {
        header('Content-Type: application/json');

        if (isset($_GET['dep'])) {
            echo json_encode(Catalog::provincias($_GET['dep']));
            return;
        }

        if (isset($_GET['prov'])) {
            echo json_encode(Catalog::distritos($_GET['prov']));
            return;
        }

        echo json_encode([]);
    }
}
