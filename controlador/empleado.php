<?php
include '../modelo/conexion.php';

function obtenerEmpleados($conn) {
    $sql = "SELECT * FROM empleado";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function cambiarEstadoEmpleado($conn, $id, $estado) {
    $sql = "UPDATE empleado SET Status=? WHERE ID_Empleado=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$estado, $id]);
}

function eliminarEmpleado($conn, $id, $comentarios) {
    $sql_log = "INSERT INTO log_bajas (ID_Empleado, Nombre, Departamento, Posicion, Fecha_Contratacion, Salario, Status, fecha_inicio, fecha_final, comentarios)
                SELECT ID_Empleado, Nombre, Departamento, Posicion, Fecha_Contratacion, Salario, Status, fecha_inicio, NOW(), ? 
                FROM empleado WHERE ID_Empleado=?";
    $stmt_log = $conn->prepare($sql_log);
    $stmt_log->execute([$comentarios, $id]);

    cambiarEstadoEmpleado($conn, $id, 'Baja');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['ausentar'])) {
        cambiarEstadoEmpleado($conn, $_POST['id_empleado'], 'Ausente');
    } elseif (isset($_POST['eliminar'])) {
        eliminarEmpleado($conn, $_POST['id_empleado'], $_POST['comentarios']);
    } elseif (isset($_POST['activar'])) {
        cambiarEstadoEmpleado($conn, $_POST['id_empleado'], 'Activo');
    }
}

$empleados = obtenerEmpleados($conn);
?>