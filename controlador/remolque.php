<?php
require_once 'modelo/conexion.php';

// Configuración de paginación y ordenamiento
$per_page = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'id_remolque';
$order = isset($_GET['order']) && strtoupper($_GET['order']) === 'ASC' ? 'ASC' : 'DESC';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Calcular offset para la paginación
$offset = ($page - 1) * $per_page;

// Consulta SQL base
$sql = "SELECT * FROM remolque 
        WHERE placas LIKE :search OR tipo_remolque LIKE :search OR subtipo_remolque LIKE :search
        ORDER BY $sort $order
        LIMIT :per_page OFFSET :offset";

// Preparar y ejecutar la consulta
$search_term = "%$search%";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':search', $search_term, PDO::PARAM_STR);
$stmt->bindValue(':per_page', (int)$per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener total de registros para la paginación
$total_sql = "SELECT COUNT(*) as total 
              FROM remolque 
              WHERE placas LIKE :search OR tipo_remolque LIKE :search OR subtipo_remolque LIKE :search";

$total_stmt = $conn->prepare($total_sql);
$total_stmt->bindValue(':search', $search_term, PDO::PARAM_STR);
$total_stmt->execute();
$total_records = $total_stmt->fetch(PDO::FETCH_ASSOC)['total'];
$total_pages = ceil($total_records / $per_page);
?>