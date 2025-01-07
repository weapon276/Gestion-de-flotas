
<?php
require 'controlador/cotizaciont.php';
?>
<?php
require 'dash.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Cotizaciones</title>
    <link rel="stylesheet" href="assets/css/cotizaciont.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/dash.js"></script>
    <script src="assets/js/cotizaciont.js"></script>
    <link rel="stylesheet" href="assets/css/diseño.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="assets/css/rservicios.css">

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
                <h1 class="title">Listado de cotizaciones</h1>
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
        <div class="header">
            <div class="actions">
                <button class="btn btn-secondary">Filtros</button>
                <a href="cotizacion.php" class="btn btn-primary">Nueva</a>
            </div>
        </div>

        <div class="search-bar">
            <input type="text" class="search-input" placeholder="Buscar...">
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th data-sort="id">ID</th>
                        <th data-sort="cliente">Cliente</th>
                        <th data-sort="fecha">Fecha y hora</th>
                        <th data-sort="vigencia">Vigencia</th>
                        <th>Emitido por</th>
                        <th data-sort="monto">Total</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                
    <?php if ($result): ?>
        <?php foreach ($result as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['ID_Cotizacion']) ?></td>
                <td><?= htmlspecialchars($row['NombreCliente']) ?></td>
                <td><?= htmlspecialchars($row['Fecha']) ?></td>
                <td><?= htmlspecialchars($row['Vigencia']) ?></td>
                <td><?= htmlspecialchars($row['NombreEmpleado']) ?></td>
                <td><?= htmlspecialchars($row['Monto']) ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="7">No se encontraron registros.</td>
        </tr>
    <?php endif; ?>

                </tbody>
            </table>
        </div>

        <div class="pagination">
            <div class="records-per-page">
                Mostrar
                <select>
                    <option>10</option>
                    <option>25</option>
                    <option>50</option>
                    <option>100</option>
                </select>
                registros
            </div>
            <div class="pagination-info">
                Mostrando 1 a 10 de 255 registros
            </div>
            <div class="pagination-controls">
                <button class="page-btn">«</button>
                <button class="page-btn">‹</button>
                <button class="page-btn active">1</button>
                <button class="page-btn">2</button>
                <button class="page-btn">3</button>
                <button class="page-btn">›</button>
                <button class="page-btn">»</button>
            </div>
        </div>
    </div>
</body>
</html>