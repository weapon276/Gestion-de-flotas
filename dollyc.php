<?php
require_once 'modelo/conexion.php';

// Configuración de paginación y ordenamiento
$per_page = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'ID_Dolly';
$order = isset($_GET['order']) ? $_GET['order'] : 'DESC';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Calcular offset para la paginación
$offset = ($page - 1) * $per_page;

// Consulta SQL base con parámetros posicionales
$sql = "SELECT * FROM dolly 
        WHERE Placas LIKE ? OR Marca LIKE ? OR Modelo LIKE ?
        ORDER BY $sort $order
        LIMIT ? OFFSET ?";

// Preparar y ejecutar la consulta
$stmt = $conn->prepare($sql);
$search_term = "%$search%";
$stmt->bindValue(1, $search_term, PDO::PARAM_STR); // Primer marcador
$stmt->bindValue(2, $search_term, PDO::PARAM_STR); // Segundo marcador
$stmt->bindValue(3, $search_term, PDO::PARAM_STR); // Tercer marcador
$stmt->bindValue(4, (int)$per_page, PDO::PARAM_INT); // Cuarto marcador
$stmt->bindValue(5, (int)$offset, PDO::PARAM_INT); // Quinto marcador
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener total de registros para la paginación
$total_sql = "SELECT COUNT(*) as total FROM dolly WHERE Placas LIKE ? OR Marca LIKE ? OR Modelo LIKE ?";
$total_stmt = $conn->prepare($total_sql);
$total_stmt->bindValue(1, $search_term, PDO::PARAM_STR);
$total_stmt->bindValue(2, $search_term, PDO::PARAM_STR);
$total_stmt->bindValue(3, $search_term, PDO::PARAM_STR);
$total_stmt->execute();
$total_records = $total_stmt->fetch(PDO::FETCH_ASSOC)['total'];
$total_pages = ceil($total_records / $per_page);
?>