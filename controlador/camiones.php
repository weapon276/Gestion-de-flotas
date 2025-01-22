<?php
include '../modelo/conexion.php';



function obtenerCamiones($conn) {
    $sql = "SELECT * FROM camion";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function cambiarEstadoCamion($conn, $id, $estado) {
    $sql = "UPDATE camion SET Status=? WHERE ID_Camion=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$estado, $id]);
}

function eliminarCamion($conn, $id, $comentarios) {
    $sql_log = "INSERT INTO log_camiones_bajas (ID_Camion, Placas, Peso, Unidad, Status, Tipo, Poliza_Seguro, GPS, fecha_inicio, fecha_final, comentarios)
                SELECT ID_Camion, Placas, Peso, Unidad, Status, Tipo, Poliza_Seguro, GPS, fecha_inicio, NOW(), ? 
                FROM camion WHERE ID_Camion=?";
    $stmt_log = $conn->prepare($sql_log);
    $stmt_log->execute([$comentarios, $id]);

    cambiarEstadoCamion($conn, $id, 'Mantenimiento');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['mantenimiento'])) {
        cambiarEstadoCamion($conn, $_POST['id_camion'], 'Mantenimiento');
    } elseif (isset($_POST['eliminar'])) {
        eliminarCamion($conn, $_POST['id_camion'], $_POST['comentarios']);
    }
}

$camiones = obtenerCamiones($conn);
?>