<?php
include '../modelo/conexion.php';

function obtenerOperadores($conn) {
    $sql = "SELECT * FROM operador";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function eliminarOperador($conn, $id, $comentarios) {
    $sql_log = "INSERT INTO log_operadores_bajas (ID_Operador, Nombre, Licencia, Vigencia_Licencia, CURP, Seguro_Social, fecha_inicio, fecha_final, comentarios)
                SELECT ID_Operador, Nombre, Licencia, Vigencia_Licencia, CURP, Seguro_Social, fecha_inicio, NOW(), ? 
                FROM operador WHERE ID_Operador=?";
    $stmt_log = $conn->prepare($sql_log);
    $stmt_log->execute([$comentarios, $id]);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['eliminar'])) {
        eliminarOperador($conn, $_POST['id_operador'], $_POST['comentarios']);
    }
}

$operadores = obtenerOperadores($conn);
?>