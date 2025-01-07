<?php

?>
<?php
require 'dash.php';
require 'dollyc.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Dolly</title>


    <link rel="stylesheet" href="assets/css/dolly.css">
    <link rel="stylesheet" href="assets/css/modal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/clientes.css">
    <link rel="stylesheet" href="assets/css/servicios.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <link rel="stylesheet" href="assets/css/diseño.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="assets/js/dash.js"></script>
    <script src="assets/js/dolly.js"></script>

</head>
<body>
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
                    <button class="btn btn-primary" onclick="showModal('addTruckModal')">Nuevo Dolly</button>
                </div>
            </div>

            <div class="search-bar animate-slide-in">
                <input type="text" class="search-input" placeholder="Buscar Dolly..." 
                       value="<?php echo htmlspecialchars($truckData['search']); ?>" id="searchInput">
                <button class="btn btn-primary" onclick="searchTrucks()">Buscar</button>
            </div>

            <div class="table-container animate-fade-in">
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th><i class="fas fa-truck"></i> Placas</th>
                        <th data-sort="Marca">Marca</th>
                        <th data-sort="Modelo">Modelo</th>
                        <th data-sort="Año">Año</th>
                        <th data-sort="PesoDolly">Peso</th>
                        <th data-sort="Capacidad_Carga">Capacidad de Carga</th>
                        <th data-sort="Dimensiones">Dimensiones</th>
                        <th data-sort="estado">Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($result)) : ?>
                        <?php foreach ($result as $row) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['Placas']); ?></td>
                                <td><?php echo htmlspecialchars($row['Marca']); ?></td>
                                <td><?php echo htmlspecialchars($row['Modelo']); ?></td>
                                <td><?php echo htmlspecialchars($row['Año']); ?></td>
                                <td><?php echo htmlspecialchars($row['PesoDolly']); ?></td>
                                <td><?php echo htmlspecialchars($row['Capacidad_Carga']); ?></td>
                                <td><?php echo htmlspecialchars($row['Dimensiones']); ?></td>
                                <td>
                                    <span class="status-badge <?php echo strtolower(str_replace(' ', '-', $row['estado'])); ?>">
                                        <?php echo htmlspecialchars($row['estado']); ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="action-btn edit-btn" data-id="<?php echo $row['ID_Dolly']; ?>">✏️</button>
                                    <button class="action-btn change-state-btn" data-id="<?php echo $row['ID_Dolly']; ?>">📋</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="9">No se encontraron resultados.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="pagination">
            <div>
                Mostrando <?php echo $offset + 1; ?> a 
                <?php echo min($offset + $per_page, $total_records); ?> 
                de <?php echo $total_records; ?> registros
            </div>
            <div class="pagination-controls">
                <?php for($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&sort=<?php echo $sort; ?>&order=<?php echo $order; ?>" 
                       class="btn <?php echo $page === $i ? 'btn-primary' : 'btn-secondary'; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>
            </div>
        </div>
    </div>    </div>

    <!-- Modal para Nuevo Dolly -->
    <div id="modalNuevoDolly" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Agregar Nuevo Dolly</h2>
            <form id="formNuevoDolly">
                <div class="form-group">
                    <label for="nuevaMarca">Marca:</label>
                    <input type="text" id="nuevaMarca" name="Marca" required>
                </div>
                <div class="form-group">
                    <label for="nuevoModelo">Modelo:</label>
                    <input type="text" id="nuevoModelo" name="Modelo" required>
                </div>
                <div class="form-group">
                    <label for="nuevoAño">Año:</label>
                    <input type="number" id="nuevoAño" name="Año" required>
                </div>
                <div class="form-group">
                    <label for="nuevasPlacas">Placas:</label>
                    <input type="text" id="nuevasPlacas" name="Placas" required>
                </div>
                <div class="form-group">
                    <label for="nuevoPesoDolly">Peso:</label>
                    <input type="number" id="nuevoPesoDolly" name="PesoDolly" step="0.000001" required>
                </div>
                <div class="form-group">
                    <label for="nuevaCapacidadCarga">Capacidad de Carga:</label>
                    <input type="number" id="nuevaCapacidadCarga" name="Capacidad_Carga" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="nuevasDimensiones">Dimensiones:</label>
                    <input type="text" id="nuevasDimensiones" name="Dimensiones" required>
                </div>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
        </div>
        
    </div>

    
    <!-- Modal para Cambiar Estado -->
    <div id="modalCambiarEstado" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Cambiar Estado del Dolly</h2>
            <form id="formCambiarEstado">
                <input type="hidden" id="dollyId" name="ID_Dolly">
                <div class="form-group">
                    <label for="nuevoEstado">Nuevo Estado:</label>
                    <select id="nuevoEstado" name="estado" required>
                        <option value="en servicio">En servicio</option>
                        <option value="suspendido">Suspendido</option>
                        <option value="matenimiento">Mantenimiento</option>
                        <option value="dado de baja">Dado de baja</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </form>
        </div>
        
    </div>
</body>
</html>