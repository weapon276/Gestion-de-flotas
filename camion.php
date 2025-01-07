<?php
require 'dash.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Camiones</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/diseño.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="assets/js/dash.js"></script>
    <script src="assets/js/camion.js"></script>

    <style>
        /* Add any additional styles here */
    </style>
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
                <h1 class="title">Gestión de Camiones</h1>
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
                    <button class="btn btn-primary" onclick="showModal('addTruckModal')">Nuevo Camión</button>
                </div>
            </div>

            <div class="search-bar animate-slide-in">
                <input type="text" class="search-input" placeholder="Buscar camión..." 
                       value="<?php echo htmlspecialchars($truckData['search']); ?>" id="searchInput">
                       <button class="btn btn-primary" onclick="searchTrucks()">Buscar</button>
   
            </div>

            <div class="table-container animate-fade-in">
                <table>
                    <thead>
                        <tr>
                            <th><i class="fas fa-truck"></i> Placas</th>
                            <th><i class="fas fa-weight"></i> Peso</th>
                            <th><i class="fas fa-box"></i> Unidad</th>
                            <th><i class="fas fa-tag"></i> Tipo</th>
                            <th><i class="fas fa-file-contract"></i> Póliza de Seguro</th>
                            <th><i class="fas fa-satellite"></i> GPS</th>
                            <th><i class="fas fa-info-circle"></i> Status</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($truckData['camiones'] as $camion): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($camion['Placas']); ?></td>
                            <td><?php echo htmlspecialchars($camion['Peso']); ?></td>
                            <td><?php echo htmlspecialchars($camion['Unidad']); ?></td>
                            <td><?php echo htmlspecialchars($camion['Tipo']); ?></td>
                            <td><?php echo htmlspecialchars($camion['Poliza_Seguro']); ?></td>
                            <td><?php echo htmlspecialchars($camion['GPS']); ?></td>
                            <td><?php echo htmlspecialchars($camion['Status']); ?></td>
                            <td>
                                <button class="btn btn-warning" onclick="showModal('maintenanceTruckModal', <?php echo $camion['ID_Camion']; ?>)">
                                    <i class="fa fa-tools"></i>
                                </button>
                                <button class="btn btn-warning" onclick="showModal('suspendTruckModal', <?php echo $camion['ID_Camion']; ?>)">
                                    <i class="fa fa-pause"></i>
                                </button>
                                <button class="btn btn-danger" onclick="showModal('deactivateTruckModal', <?php echo $camion['ID_Camion']; ?>)">
                                    <i class="fa fa-trash"></i>
                                </button>
                                <button class="btn btn-secondary" onclick="showModal('editTruckModal', <?php echo $camion['ID_Camion']; ?>)">
                                    <i class="fa fa-edit"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                <div>
                    Mostrando <?php echo ($truckData['current_page'] - 1) * $truckData['per_page'] + 1; ?> a 
                    <?php echo min($truckData['current_page'] * $truckData['per_page'], $truckData['total_records']); ?> 
                    de <?php echo $truckData['total_records']; ?> registros
                </div>
                <div class="pagination-controls">
                    <?php for($i = 1; $i <= $truckData['total_pages']; $i++): ?>
                        <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($truckData['search']); ?>&sort=<?php echo $truckData['sort']; ?>&order=<?php echo $truckData['order']; ?>" 
                           class="btn <?php echo $truckData['current_page'] === $i ? 'btn-primary' : 'btn-secondary'; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal templates -->
    <div id="addTruckModal" class="modal">
        <!-- Add truck form -->
    </div>

    <div id="editTruckModal" class="modal">
        <!-- Edit truck form -->
    </div>

    <div id="maintenanceTruckModal" class="modal">
        <!-- Maintenance form -->
    </div>

    <div id="suspendTruckModal" class="modal">
        <!-- Suspend truck form -->
    </div>

    <div id="deactivateTruckModal" class="modal">
        <!-- Deactivate truck form -->
    </div>
</body>
</html>