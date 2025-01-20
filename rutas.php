<?php
require 'controlador/rutas.php';
?>
<?php
require 'dash.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotizaciones y Viajes en Curso</title>
    <script src="assets/js/dash.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="assets/css/clientes.css">
    <link rel="stylesheet" href="assets/css/servicios.css">
    <link rel="stylesheet" href="assets/css/modal.css">
    <link rel="stylesheet" href="assets/css/diseño.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
   <link rel="stylesheet" href="assets/css/dashboard.css">
   <link rel="stylesheet" href="assets/css/clientes.css">
   <link rel="stylesheet" href="assets/css/diseño.css">
    <style>
   
    </style>
</head>
<body>
       <!-- Informacion del dashboard -->
 <aside class="sidebar" id="sidebar">
        <div class="logo">
            <img src="assets/img/1.png" alt="Logo">
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
                <h1 class="title"><i class="fas fa-truck"></i> Cotizaciones y Viajes en Curso</h1>
                </div>
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
                       <!-- Fin -->
    <main class="main-content">
        <div class="header">
        <h1 class="title"></h1>
        </div>

        <div class="search-bar">
            <input type="text" class="search-input" placeholder="Buscar..." onkeyup="searchQuotations()">
        </div>

        <div class="table-container">
        <table>
    <thead>
    <tr>
                        <th><i class="fas fa-hashtag"></i> ID Viaje</th>
                        <th><i class="fas fa-truck"></i> Camión</th>
                        <th><i class="fas fa-user"></i> Operador</th>
                        <th><i class="fas fa-building"></i> Cliente</th>
                        <th><i class="fas fa-route"></i> Ruta</th>
                        <th><i class="fas fa-file-invoice-dollar"></i> Cotización</th>
                        <th><i class="fas fa-calendar-alt"></i> Fecha Despacho</th>
                        <th><i class="fas fa-calendar-check"></i> Fecha Llegada</th>
                        <th><i class="fas fa-file-alt"></i> Pedimentos</th>
                        <th><i class="fas fa-box"></i> Contenedores</th>
                        <th><i class="fas fa-weight"></i> Toneladas</th>
                        <th><i class="fas fa-money-bill-wave"></i> Gastos</th>
                        <th><i class="fas fa-info-circle"></i> Status</th>
                        <th><i class="fas fa-cogs"></i> Acciones</th>
                    </tr>
    </thead>
    <tbody>
        <?php if (count($rows) > 0): ?>
            <?php foreach ($rows as $row): ?>
                <tr>
    <td><?= htmlspecialchars($row["ID_Viaje"]) ?></td>
    <td><?= htmlspecialchars($row["NombreCamion"]) ?></td>
    <td><?= htmlspecialchars($row["NombreOperador"]) ?></td>
    <td><?= htmlspecialchars($row["NombreCliente"]) ?></td>
    <td><?= htmlspecialchars($row["NombreRuta"]) ?></td>
    <td><?= htmlspecialchars($row["NumeroCotizacion"]) ?></td>
    <td><?= htmlspecialchars($row["Fecha_Despacho"]) ?></td>
    <td><?= htmlspecialchars($row["Fecha_Llegada"]) ?></td>
    <td><?= htmlspecialchars($row["Pedimentos"]) ?></td>
    <td><?= htmlspecialchars($row["Contenedores"]) ?></td>
    <td><?= htmlspecialchars($row["Toneladas"]) ?></td>
    <td>$<?= number_format(htmlspecialchars($row["Gastos"]), 2) ?></td>
    <td><span class='status-badge status-<?= strtolower(str_replace(' ', '-', $row["Status"])) ?>'>
                            <?= htmlspecialchars($row["Status"]) ?>
                        </span>
                 
                    <td>
                        <div class='action-buttons'>
                            <button class='action-btn' onclick='editQuotation(<?= $row["ID_Viaje"] ?>)'>
                                <i class='fas fa-edit'></i>
                            </button>
                            <button class='action-btn' onclick='deleteQuotation(<?= $row["ID_Viaje"] ?>)'>
                                <i class='fas fa-trash-alt'></i>
                            </button>
                        </div>
                    </td>
                    </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="14">No se encontraron registros</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
        </div>
    </main>
</body>
</html>