
<?php
require 'dash.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Seguros</title>
    <script src="assets/js/seguro.js"></script>
    <link rel="stylesheet" href="assets/css/camion.css">
    <link rel="stylesheet" href="assets/css/servicios.css">
    <link rel="stylesheet" href="assets/css/rservicios.css">
    <link rel="stylesheet" href="assets/css/dolly.css">
    <link rel="stylesheet" href="assets/css/modal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <script src="assets/js/dash.js"></script>
   <link rel="stylesheet" href="assets/css/diseño.css">
   <link rel="stylesheet" href="assets/css/dashboard.css">
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
                <h1 class="title">Listado de Seguros</h1>
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
    <div class="table-container">
        <div class="header">
            <h1 class="title">Listado de Seguros</h1>
            <div class="actions">
                <button id="btnNuevoSeguro" class="btn btn-primary">Agregar Seguro</button>
            </div>
        </div>

        <div class="search-bar">
            <input type="text" class="search-input" placeholder="Buscar por empresa aseguradora o póliza..." id="searchInput">
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th data-sort="fk_id_camion"><i class="fas fa-truck"></i> ID Camión</th>
                        <th data-sort="empresa_aseguradora">Empresa Aseguradora</th>
                        <th data-sort="vigencia">Vigencia</th>
                        <th data-sort="status_seguro">Estado</th>
                        <th data-sort="tipo_pago">Tipo de Pago</th>
                        <th data-sort="polizaAr">Póliza</th>
                        <th data-sort="fecha_creacion">Fecha de Creación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="segurosTableBody">
                    <!-- Los datos de seguros se insertarán aquí dinámicamente -->
                </tbody>
            </table>
        </div>

        <div class="pagination">
            <div id="paginationInfo"></div>
            <div class="pagination-controls" id="paginationControls"></div>
        </div>
    </div>

    <!-- Modal para Nuevo/Editar Seguro -->
    <div id="modalSeguro" class="modal">
        <div class="modal-content animate-fade-in">
            <span class="close">&times;</span>
            <h2 id="modalTitle">Agregar Nuevo Seguro</h2>
            <form id="formSeguro">
                <input type="hidden" id="seguroId" name="id_seguro">
                <div class="form-group">
                    <label for="fk_id_camion">ID Camión:</label>
                    <input type="number" id="fk_id_camion" name="fk_id_camion" required>
                </div>
                <div class="form-group">
                    <label for="empresa_aseguradora">Empresa Aseguradora:</label>
                    <input type="text" id="empresa_aseguradora" name="empresa_aseguradora" required>
                </div>
                <div class="form-group">
                    <label for="vigencia">Vigencia:</label>
                    <input type="date" id="vigencia" name="vigencia" required>
                </div>
                <div class="form-group">
                    <label for="status_seguro">Estado del Seguro:</label>
                    <select id="status_seguro" name="status_seguro" required>
                        <option value="Activo">Activo</option>
                        <option value="Vencido">Vencido</option>
                        <option value="Falta de pago">Falta de pago</option>
                        <option value="Cancelado">Cancelado</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tipo_pago">Tipo de Pago:</label>
                    <select id="tipo_pago" name="tipo_pago" required>
                        <option value="Mensual">Mensual</option>
                        <option value="Trimestral">Trimestral</option>
                        <option value="Anual">Anual</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="polizaAr">Póliza:</label>
                    <input type="text" id="polizaAr" name="polizaAr">
                </div>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
        </div>
    </div>
</body>
</html>