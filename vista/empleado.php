
<?php
require '../dash.php';
?>

<?php
require '../controlador/empleado.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Empleados</title>
    <link rel="stylesheet" href="../assets/css/empleado.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <script src="../assets/js/dash.js"></script>
    <script src="../assets/js/empleado.js"></script>
   <link rel="stylesheet" href="../assets/css/diseño.css">
   <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="../assets/css/clientes.css">
    <link rel="stylesheet" href="../assets/css/diseño.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
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
                <h1 class="title">Gestionar Empleados</h1>
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
                        <th>Nombre</th>
                        <th>Departamento</th>
                        <th>Posición</th>
                        <th>Fecha de Contratación</th>
                        <th>Salario</th>
                        <th>Status</th>
                        <th>Fecha de Registro</th>
                        <th>Fecha Final</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($empleados as $empleado): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($empleado['ID_Empleado']); ?></td>
                        <td><?php echo htmlspecialchars($empleado['Nombre']); ?></td>
                        <td><?php echo htmlspecialchars($empleado['Departamento']); ?></td>
                        <td><?php echo htmlspecialchars($empleado['Posicion']); ?></td>
                        <td><?php echo htmlspecialchars($empleado['Fecha_Contratacion']); ?></td>
                        <td><?php echo htmlspecialchars($empleado['Salario']); ?></td>
                        <td>
                            <?php 
                            $badgeClass = 'badge-success';
                            if ($empleado['Status'] == 'Ausente') {
                                $badgeClass = 'badge-warning';
                            } elseif ($empleado['Status'] == 'Baja') {
                                $badgeClass = 'badge-danger';
                            }
                            ?>
                            <span class="badge <?php echo $badgeClass; ?>">
                                <?php echo htmlspecialchars($empleado['Status']); ?>
                            </span>
                        </td>
                        <td><?php echo htmlspecialchars($empleado['fecha_inicio']); ?></td>
                        <td><?php echo htmlspecialchars($empleado['fecha_final']); ?></td>
                        <td class="actions">
                            <form method="post" class="form-inline tooltip">
                                <input type="hidden" name="id_empleado" value="<?php echo $empleado['ID_Empleado']; ?>">
                                <button type="submit" name="activar" class="icon-button2" title="Activar">
                                    <i class="fas fa-check-circle"></i>
                                </button>
                                <span class="tooltiptext">Activar</span>
                            </form>
                            <form method="post" class="form-inline tooltip">
                                <input type="hidden" name="id_empleado" value="<?php echo $empleado['ID_Empleado']; ?>">
                                <button type="submit" name="ausentar" class="icon-button2" title="Ausentar">
                                    <i class="fas fa-user-clock"></i>
                                </button>
                                <span class="tooltiptext">Ausentar</span>
                            </form>
                            <form method="post" class="form-inline tooltip">
                            <button type="submit" name="eliminar" class="icon-button2" title="Eliminar">
                                <input type="hidden" name="id_empleado" value="<?php echo $empleado['ID_Empleado']; ?>">
                                <input type="text" name="comentarios" placeholder="Comentarios" required>
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