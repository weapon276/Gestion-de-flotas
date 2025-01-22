<?php
require '../dash.php';
require '../controlador/camiones.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Camiones</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="../assets/js/dash.js"></script>
    <script src="../assets/js/camiones.js"></script>

    <link rel="stylesheet" href="../assets/css/usuario.css">
    <link rel="stylesheet" href="../assets/css/botones.css">
   <link rel="stylesheet" href="../assets/css/diseño.css">
   <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="../assets/css/rservicios.css">
    <link rel="stylesheet" href="../assets/css/modal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="../assets/css/clientes.css">
    <link rel="stylesheet" href="../assets/css/diseño.css">
 
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
                <h1 class="title">Gestionar Camiones</h1>
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
    <div class="container">
        <div class="header">
            
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Placas</th>
                        <th>Peso</th>
                        <th>Unidad</th>
                        <th>Status</th>
                        <th>Tipo</th>
                        <th>Póliza de Seguro</th>
                        <th>GPS</th>
                        <th>Fecha de Registro</th>
                        <th>Fecha Final</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($camiones as $camion): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($camion['ID_Camion']); ?></td>
                        <td><?php echo htmlspecialchars($camion['Placas']); ?></td>
                        <td><?php echo htmlspecialchars($camion['Peso']); ?></td>
                        <td><?php echo htmlspecialchars($camion['Unidad']); ?></td>
                        <td>
                            <?php 
                            $badgeClass = 'badge-success';
                            $status = $camion['Status'];
                            if ($status == 'Ocupado') {
                                $badgeClass = 'badge-warning';
                            } elseif ($status == 'Mantenimiento') {
                                $badgeClass = 'badge-danger';
                            }
                            ?>
                            <span class="badge <?php echo $badgeClass; ?>">
                                <?php echo htmlspecialchars($status); ?>
                            </span>
                        </td>
                        <td><?php echo htmlspecialchars($camion['Tipo']); ?></td>
                        <td><?php echo htmlspecialchars($camion['Poliza_Seguro']); ?></td>
                        <td><?php echo htmlspecialchars($camion['GPS']); ?></td>
                        <td><?php echo htmlspecialchars($camion['fecha_inicio']); ?></td>
                        <td><?php echo htmlspecialchars($camion['fecha_final']); ?></td>
                        <td class="actions">
                            <form method="post" class="tooltip">
                                <input type="hidden" name="id_camion" value="<?php echo $camion['ID_Camion']; ?>">
                                <button type="submit" name="modificar" class="icon-button">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <span class="tooltiptext">Modificar</span>
                            </form>
                            <form method="post" class="tooltip">
                                <input type="hidden" name="id_camion" value="<?php echo $camion['ID_Camion']; ?>">
                                <button type="submit" name="mantenimiento" class="icon-button">
                                    <i class="fas fa-tools"></i>
                                </button>
                                <span class="tooltiptext">Mantenimiento</span>
                            </form>
                            <form method="post" class="tooltip">
                                <input type="hidden" name="id_camion" value="<?php echo $camion['ID_Camion']; ?>">
                                <input type="text" name="comentarios" placeholder="Comentarios" required>
                                <button type="submit" name="eliminar" class="icon-button">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                <span class="tooltiptext">Eliminar</span>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>