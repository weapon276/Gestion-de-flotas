
<?php
require 'controlador/remolque.php';
?>
<?php
require 'dash.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Remolques</title>
    <script src="assets/js/dash.js"></script>
   <link rel="stylesheet" href="assets/css/diseño.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/clientes.css">
    <link rel="stylesheet" href="assets/css/servicios.css">
    <link rel="stylesheet" href="assets/css/modal.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
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
                <h1 class="title">Detalles del Cliente</h1>
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
        <div class="header animate-fade-in">
            <h1 class="title">Remolque</h1>
            <div class="header-actions">
                 <button class="btn btn-secondary">Filtros</button>
                <a href="" class="btn btn-primary">Nuevo</a>
            </div>
        </div>

        <div class="search-bar animate-slide-in">
            <input type="text" class="search-input" placeholder="Buscar..." onkeyup="searchClients()">
        </div>
        <div class="table-container animate-slide-in">

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th data-sort="placas">Placas</th>
                        <th data-sort="tipo_remolque">Tipo</th>
                        <th data-sort="marca">Marca</th>
                        <th data-sort="modelo">Modelo</th>
                        <th data-sort="año">Año</th>
                        <th data-sort="PesoR">Peso</th>
                        <th data-sort="capacidad_carga">Capacidad de Carga</th>
                        <th data-sort="estado">Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
    <?php if (!empty($result)) : ?>
        <?php foreach ($result as $row) : ?>
            <tr>
                <td><?php echo htmlspecialchars($row['placas']); ?></td>
                <td><?php echo htmlspecialchars($row['tipo_remolque']); ?></td>
                <td><?php echo htmlspecialchars($row['marca']); ?></td>
                <td><?php echo htmlspecialchars($row['modelo']); ?></td>
                <td><?php echo htmlspecialchars($row['año']); ?></td>
                <td><?php echo htmlspecialchars($row['PesoR']); ?></td>
                <td><?php echo htmlspecialchars($row['capacidad_carga']); ?></td>
                <td>
                    <span class="status-badge <?php echo strtolower(str_replace(' ', '-', $row['estado'])); ?>">
                        <?php echo htmlspecialchars($row['estado']); ?>
                    </span>
                </td>
                <td>
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalModificarRemolque" data-id="<?php echo $row['id_remolque']; ?>">
                        <i class="fa fa-edit"></i> 
                    </button>
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalSuspenderRemolque" data-id="<?php echo $row['id_remolque']; ?>">
                        <i class="fa fa-pause"></i>
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalDarDeBajaRemolque" data-id="<?php echo $row['id_remolque']; ?>">
                        <i class="fa fa-trash"></i> 
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else : ?>
        <tr>
            <td colspan="11">No se encontraron resultados.</td>
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
    </div>

    <script>
        // Búsqueda en tiempo real
        const searchInput = document.querySelector('.search-input');
        let searchTimeout;
        
        searchInput.addEventListener('input', (e) => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                window.location.href = `?search=${e.target.value}&sort=<?php echo $sort; ?>&order=<?php echo $order; ?>`;
            }, 500);
        });

        // Ordenamiento por columnas
        document.querySelectorAll('th[data-sort]').forEach(th => {
            th.addEventListener('click', () => {
                const sortBy = th.dataset.sort;
                const currentOrder = new URLSearchParams(window.location.search).get('order') || 'DESC';
                const newOrder = currentOrder === 'ASC' ? 'DESC' : 'ASC';
                window.location.href = `?sort=${sortBy}&order=${newOrder}&search=<?php echo urlencode($search); ?>`;
            });
        });
    </script>
</body>
</html>