<?php
include '../modelo/conexion.php';

function obtenerClientes($conn) {
    $sql = "SELECT * FROM cliente";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function cambiarEstadoCliente($conn, $id, $estado) {
    $sql = "UPDATE cliente SET Status=? WHERE ID_Cliente=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$estado, $id]);
}

function eliminarCliente($conn, $id, $comentarios) {
    $sql_log = "INSERT INTO log_clientes_bajas (ID_Cliente, Nombre, Direccion, Tipo, Linea_Credito, Pago_Contado, Status, fecha_inicio, fecha_final, comentarios)
                SELECT ID_Cliente, Nombre, Direccion, Tipo, Linea_Credito, Pago_Contado, Status, fecha_inicio, NOW(), ? 
                FROM cliente WHERE ID_Cliente=?";
    $stmt_log = $conn->prepare($sql_log);
    $stmt_log->execute([$comentarios, $id]);

    cambiarEstadoCliente($conn, $id, 'Baja');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['suspender'])) {
        cambiarEstadoCliente($conn, $_POST['id_cliente'], 'Suspendido');
    } elseif (isset($_POST['eliminar'])) {
        eliminarCliente($conn, $_POST['id_cliente'], $_POST['comentarios']);
    }
}

$clientes = obtenerClientes($conn);
?>