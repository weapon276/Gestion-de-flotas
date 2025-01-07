<?php
require_once 'modelo/conexion.php';

$per_page = $_GET['per_page'] ?? 10;
$page = $_GET['page'] ?? 1;
$search = $_GET['search'] ?? '';
$sort = $_GET['sort'] ?? 'ID_Cotizacion';
$order = $_GET['order'] ?? 'DESC';

$allowed_sort_columns = ['ID_Cotizacion', 'NombreCliente', 'NombreEmpleado'];
$allowed_order = ['ASC', 'DESC'];

$sort = in_array($sort, $allowed_sort_columns) ? $sort : 'ID_Cotizacion';
$order = in_array(strtoupper($order), $allowed_order) ? strtoupper($order) : 'DESC';

$offset = ($page - 1) * $per_page;

// Consulta principal
$sql = "SELECT c.*, cl.Nombre as NombreCliente, e.Nombre as NombreEmpleado 
        FROM cotizacion c 
        LEFT JOIN cliente cl ON c.ID_Cliente = cl.ID_Cliente 
        LEFT JOIN empleado e ON c.fk_idEmpleado = e.ID_Empleado 
        WHERE cl.Nombre LIKE :search OR c.ID_Cotizacion LIKE :search
        ORDER BY $sort $order 
        LIMIT :per_page OFFSET :offset";

$stmt = $conn->prepare($sql);
$search_term = "%$search%";
$stmt->bindValue(':search', $search_term, PDO::PARAM_STR);
$stmt->bindValue(':per_page', (int)$per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total_sql = "SELECT COUNT(*) as total 
              FROM cotizacion c 
              LEFT JOIN cliente cl ON c.ID_Cliente = cl.ID_Cliente 
              WHERE cl.Nombre LIKE :search OR c.ID_Cotizacion LIKE :search";

$total_stmt = $conn->prepare($total_sql);
$total_stmt->bindValue(':search', $search_term, PDO::PARAM_STR);
$total_stmt->execute();
$total_records = $total_stmt->fetch(PDO::FETCH_ASSOC)['total'];
$total_pages = ceil($total_records / $per_page);


?>