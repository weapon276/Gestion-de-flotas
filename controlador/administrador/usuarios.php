<?php
include '../modelo/conexion.php';



// Database functions
function obtenerUsuariosActivos($conn) {
    $sql = "SELECT u.*, t.NombreTypeUser 
            FROM usuarios u 
            LEFT JOIN typeuser t ON u.fk_typeuser = t.id_TypeUser 
            WHERE u.bStatus = 'Activo'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function obtenerUsuariosNoActivos($conn) {
    $sql = "SELECT u.*, t.NombreTypeUser 
            FROM usuarios u 
            LEFT JOIN typeuser t ON u.fk_typeuser = t.id_TypeUser 
            WHERE u.bStatus IN ('Suspendido', 'Baja')";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function obtenerTiposUsuarios($conn) {
    $sql = "SELECT id_TypeUser, NombreTypeUser FROM typeuser";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accion'])) {
        $id_usuario = $_POST['id_usuario'];
        $accion = $_POST['accion'];
        $nuevo_estado = $accion === 'suspender' ? 'Suspendido' : 
                      ($accion === 'eliminar' ? 'Baja' : 
                      ($accion === 'reactivar' ? 'Activo' : $accion));

        $sql = "UPDATE usuarios SET bStatus = :nuevo_estado, FechaUp = NOW() WHERE id = :id_usuario";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nuevo_estado', $nuevo_estado);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();

        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    if (isset($_POST['modificar_usuario'])) {
        $id_usuario = $_POST['id_usuario'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $user_type = $_POST['user_type'];

        $sql = "UPDATE usuarios SET username = :username, vCorreo = :email, fk_typeuser = :user_type, FechaUp = NOW() WHERE id = :id_usuario";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':user_type', $user_type);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();

        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    if (isset($_POST['agregar_usuario'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $user_type = $_POST['user_type'];

        $sql = "INSERT INTO usuarios (username, vCorreo, password, fk_typeuser, bStatus, FechaUp) 
                VALUES (:username, :email, :password, :user_type, 'Activo', NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':user_type', $user_type);
        $stmt->execute();

        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

$usuarios_activos = obtenerUsuariosActivos($conn);
$usuarios_no_activos = obtenerUsuariosNoActivos($conn);
$tipos_usuarios = obtenerTiposUsuarios($conn);
?>