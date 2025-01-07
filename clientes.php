<?php
include 'modelo/conexion.php';



function obtenerClientes($conn) {
    $sql = "SELECT c.*, 
                   (SELECT SUM(monto) FROM factura WHERE ID_Cliente = c.ID_Cliente) AS Factura,
                   (SELECT estado FROM servicios WHERE ID_Cliente = c.ID_Cliente LIMIT 1) AS Estatus_Servicios,
                   (c.Linea_Credito - COALESCE(SUM(f.monto), 0)) AS Saldo_Linea_Credito
            FROM cliente c
            LEFT JOIN factura f ON c.ID_Cliente = f.fk_id_Cliente
            GROUP BY c.ID_Cliente";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function obtenerFacturasCliente($conn, $id_cliente) {
    $sql = "SELECT ID_Factura, Fecha, Monto, Estado_Pago, Total FROM factura WHERE fk_id_Cliente = :id_cliente";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_cliente', $id_cliente);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$clientes = obtenerClientes($conn);

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id_factura'])) {
    $id_factura = $_GET['id_factura'];
    $sql = "SELECT * FROM factura WHERE ID_Factura = :id_factura";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_factura', $id_factura);
    $stmt->execute();
    $factura = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($factura);
    exit;
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_factura']) && isset($_POST['usuario_id'])) {
    $id_factura = $_POST['id_factura'];
    $usuario_id = $_POST['usuario_id'];
    $sql = "INSERT INTO log_movimientos (id_usuario, accion, detalle, fecha) VALUES (:id_usuario, 'Descarga de PDF', :detalle, NOW())";
    $stmt = $conn->prepare($sql);
    $detalle = 'Descargó el PDF de la factura ID ' . $id_factura;
    $stmt->bindParam(':id_usuario', $usuario_id);
    $stmt->bindParam(':detalle', $detalle);
    $stmt->execute();
    echo 'Registro de descarga exitoso.';
    exit;
}
?>
<?php
include 'dash.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Clientes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/clientes.css">
    <link rel="stylesheet" href="assets/css/servicios.css">
    <link rel="stylesheet" href="assets/css/modal.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/diseño.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <script src="assets/js/clientes.js"></script>
    <script src="assets/js/dash.js"></script>


</head>
<body>
<aside class="sidebar" id="sidebar">
        <div class="logo">
            <img src="assets/img/andug.jpg" alt="Logo">
            <span class="logo-text"></span>
        </div>

        <div class="welcome-message">
            Bienvenido(A), <?php echo htmlspecialchars($nombreEmpleado); ?>
        </div>

        <nav class="nav-section">
            <div class="nav-title"><p>Area: <?php echo htmlspecialchars($user_type); ?></p></div>
            <?php echo generarMenu($user_type); ?>
        </nav>
    </aside>

    <main class="main-content">
        <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
            <div class="top-bar">
                <div class="top-actions">
                <h1 class="title">Gestión de Clientes</h1>
                    <div class="notifications-dropdown">
                        <button class="btn btn-secondary" onclick="toggleNotifications()">
                            <span>🔔</span>
                        </button>
                        <div class="notifications-panel" id="notificationsPanel">
                            <div class="user-menu-item">No tienes mensajes sin leer</div>
                            <div class="user-menu-item">Ver todas</div>
                        </div>
                    </div>

                    <div class="user-menu">
                        <button class="btn btn-secondary" onclick="toggleUserMenu()">
                            <span>👤</span>
                            <span><?php echo htmlspecialchars($nombreEmpleado . ' ' . $apellidoEmpleado); ?></span>
                        </button>
                        <div class="user-dropdown" id="userDropdown">
                            <div class="user-menu-item" onclick="toggleDarkMode()">Dark mode</div>
                            <div class="user-menu-item" onclick="logout()">Cerrar sesión</div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <div class="dashboard-content">
            <div class="header animate-fade-in">

                <div class="header-actions">
                    <button class="btn btn-secondary">Filtros</button>
                    <button class="btn btn-primary" onclick="showModal('addTruckModal')">Nuevo Cliente</button>
                </div>
            </div>

            <div class="search-bar animate-slide-in">
                <input type="text" class="search-input" placeholder="Buscar cliente..." 
                       value="<?php echo htmlspecialchars($truckData['search']); ?>" id="searchInput">
                <button class="btn btn-primary" onclick="searchTrucks()">Buscar</button>
            </div>

            <div class="table-container animate-fade-in">
            <table>
                <thead>
                    <tr>
                        <th>ID Cliente</th>
                        <th>Nombre</th>
                        <th>Dirección</th>
                        <th>Tipo</th>
                        <th>Línea de Crédito</th>
                        <th>Pago Contado</th>
                        <th>Status</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clientes as $cliente): 
                        $estado_class = 'status-activo';
                        if ($cliente['Status'] == 'Suspendido') {
                            $estado_class = 'status-suspendido';
                        } elseif ($cliente['Status'] == 'Baja') {
                            $estado_class = 'status-baja';
                        }
                    ?>
                    <tr>
                        <td><?php echo $cliente['ID_Cliente']; ?></td>
                        <td><?php echo htmlspecialchars($cliente['Nombre']); ?></td>
                        <td><?php echo htmlspecialchars($cliente['Direccion']); ?></td>
                        <td><?php echo htmlspecialchars($cliente['Tipo']); ?></td>
                        <td><?php echo $cliente['Linea_Credito']; ?></td>
                        <td><?php echo $cliente['Pago_Contado'] ? 'Sí' : 'No'; ?></td>
                        <td><span class="status-badge <?php echo $estado_class; ?>"><?php echo $cliente['Status']; ?></span></td>
                        <td>
                            <div class="action-buttons">
                                <button class="action-btn" onclick="openModal(<?php echo htmlspecialchars(json_encode($cliente)); ?>)">✏️</button>
                                <button class="action-btn" onclick="deleteClient(<?php echo $cliente['ID_Cliente']; ?>)">🗑️</button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="pagination">
            <span class="page-info">Mostrando 1 a 10 de <?php echo count($clientes); ?> registros</span>
            <div class="page-controls">
                <button class="page-btn" onclick="changePage('prev')">Anterior</button>
                <button class="page-btn">1</button>
                <button class="page-btn">2</button>
                <button class="page-btn">3</button>
                <button class="page-btn" onclick="changePage('next')">Siguiente</button>
            </div>
        </div>
    </main>
    <div id="clienteModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-content" id="modalTitle">Editando al cliente</h2>
                <button class="close-button" onclick="closeModal()">×</button>
            </div>
            <div class="modal-body">
                <form id="clienteForm">
                    <input type="hidden" id="ID_Cliente" name="ID_Cliente">
                    <div class="form-section">
                        <div class="form-group">
                            <label class="form-label">
                                Nombre
                                <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control" id="Nombre" name="Nombre" required>
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label">
                                Dirección
                                <span class="required">*</span>
                            </label>
                            <textarea class="form-control" id="Direccion" name="Direccion" required></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                Tipo
                                <span class="required">*</span>
                            </label>
                            <div class="select-wrapper">
                                <select class="form-control" id="Tipo" name="Tipo" required>
                                    <option value="Fisica">Física</option>
                                    <option value="Moral">Moral</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                Tipo de crédito
                                <span class="required">*</span>
                            </label>
                            <div class="select-wrapper">
                                <select class="form-control" id="TipoCredito" name="TipoCredito" required>
                                    <option value="Limitado">Limitado</option>
                                    <option value="Ilimitado">Ilimitado</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group" id="lineaCreditoGroup">
                            <label class="form-label">Línea de crédito</label>
                            <input type="number" class="form-control" id="Linea_Credito" name="Linea_Credito" step="0.01">
                        </div>
                        <div class="form-group" id="diasCreditoGroup">
                            <label class="form-label">Días de crédito</label>
                            <input type="number" class="form-control" id="Dias_Credito" name="Dias_Credito">
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                Pago al contado
                                <span class="required">*</span>
                            </label>
                            <div class="select-wrapper">
                                <select class="form-control" id="Pago_Contado" name="Pago_Contado" required>
                                    <option value="1">Sí</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                Status
                                <span class="required">*</span>
                            </label>
                            <div class="select-wrapper">
                                <select class="form-control" id="Status" name="Status" required>
                                    <option value="Activo">Activo</option>
                                    <option value="Suspendido">Suspendido</option>
                                    <option value="Baja">Baja</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group full-width">
                            <label class="form-label">Motivo de baja</label>
                            <textarea class="form-control" id="Motivo_Baja" name="Motivo_Baja"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Foto/Logo</label>
                            <input type="file" class="form-control" id="Foto_Logo" name="Foto_Logo" accept="image/*">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" id="Email" name="Email">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeModal()">Cerrar</button>
                <button class="btn btn-primary" onclick="saveClient()">Guardar</button>
            </div>
        </div>
    </div>     
</body>
</html>