<?php
include '../modelo/conexion.php';
require('../assets/fpdf/fpdf.php');

function obtenerDatos($conn, $tabla, $fechaInicio, $fechaFin) {
    $sql = "SELECT * FROM $tabla";
    if ($tabla == 'log_movimientos') {
        $sql .= " WHERE fecha BETWEEN :fechaInicio AND :fechaFin";
    }
    $stmt = $conn->prepare($sql);
    if ($tabla == 'log_movimientos') {
        $stmt->bindParam(':fechaInicio', $fechaInicio);
        $stmt->bindParam(':fechaFin', $fechaFin);
    }
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function generarXML($datos, $nombreArchivo) {
    $dom = new DOMDocument('1.0', 'utf-8');
    $root = $dom->createElement('data');
    foreach ($datos as $fila) {
        $item = $dom->createElement('item');
        foreach ($fila as $clave => $valor) {
            $element = $dom->createElement($clave, htmlspecialchars($valor));
            $item->appendChild($element);
        }
        $root->appendChild($item);
    }
    $dom->appendChild($root);
    $dom->save($nombreArchivo);
}

function generarPDF($datos, $nombreArchivo, $titulo) {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, $titulo, 0, 1, 'C');

    $pdf->SetFont('Arial', 'B', 10);
    foreach (array_keys($datos[0]) as $columna) {
        $pdf->Cell(40, 10, $columna, 1);
    }
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 10);
    foreach ($datos as $fila) {
        foreach ($fila as $valor) {
            $pdf->Cell(40, 10, $valor, 1);
        }
        $pdf->Ln();
    }
    $pdf->Output('F', $nombreArchivo);
}

function obtenerHistorial($conn, $fechaInicio, $fechaFin) {
    $tablas = ['cliente', 'viaje', 'operador', 'camion', 'usuarios', 'factura', 'liquidacion', 'log_movimientos'];
    $historial = [];
    foreach ($tablas as $tabla) {
        $historial[$tabla] = obtenerDatos($conn, $tabla, $fechaInicio, $fechaFin);
    }
    return $historial;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tipo_reporte = $_POST['tipo_reporte'];
    $formato = $_POST['formato'];
    $fechaInicio = $_POST['fecha_inicio'] . ' 00:00:00';
    $fechaFin = $_POST['fecha_fin'] . ' 23:59:59';

    if ($tipo_reporte == 'historial') {
        $datos = obtenerHistorial($conn, $fechaInicio, $fechaFin);
    } else {
        $datos = obtenerDatos($conn, $tipo_reporte, $fechaInicio, $fechaFin);
    }

    $timestamp = date('Ymd_His');
    if ($formato == 'xml') {
        $nombreArchivo = "reporte_{$tipo_reporte}_{$timestamp}.xml";
        generarXML($datos, $nombreArchivo);
    } elseif ($formato == 'pdf') {
        $nombreArchivo = "reporte_{$tipo_reporte}_{$timestamp}.pdf";
        generarPDF($datos, $nombreArchivo, "Reporte de " . ucfirst($tipo_reporte));
    }

    header("Content-Disposition: attachment; filename=$nombreArchivo");
    header("Content-Type: application/octet-stream");
    readfile($nombreArchivo);
    unlink($nombreArchivo);
    exit();
}
?>