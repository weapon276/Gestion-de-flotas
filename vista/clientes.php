<?php
require '../dash.php';
require '../controlador/clientes.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Clientes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="../assets/js/dash.js"></script>
    <script src="../assets/js/clientes.js"></script>

    <link rel="stylesheet" href="../assets/css/usuario.css">
    <link rel="stylesheet" href="../assets/css/botones.css">
   <link rel="stylesheet" href="../assets/css/diseño.css">
   <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="../assets/css/rservicios.css">
    <link rel="stylesheet" href="../assets/css/modal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="../assets/css/clientes.css">
    <link rel="stylesheet" href="../assets/css/diseño.css">
   
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
                <h1 class="title">Gestionar Clientes</h1>
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
                        <th>Dirección</th>
                        <th>Tipo</th>
                        <th>Línea de Crédito</th>
                        <th>Pago Contado</th>
                        <th>Status</th>
                        <th>Fecha de Registro</th>
                        <th>Fecha Final</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clientes as $cliente): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($cliente['ID_Cliente']); ?></td>
                        <td><?php echo htmlspecialchars($cliente['Nombre']); ?></td>
                        <td><?php echo htmlspecialchars($cliente['Direccion']); ?></td>
                        <td><?php echo htmlspecialchars($cliente['Tipo']); ?></td>
                        <td><?php echo htmlspecialchars($cliente['Linea_Credito']); ?></td>
                        <td><?php echo $cliente['Pago_Contado'] ? 'Sí' : 'No'; ?></td>
                        <td>
                            <?php 
                            if ($cliente['Status'] == 'Activo') {
                                echo '<span class="badge badge-success">Activo</span>';
                            } elseif ($cliente['Status'] == 'Suspendido') {
                                echo '<span class="badge badge-warning">Suspendido</span>';
                            } else {
                                echo '<span class="badge badge-danger">Baja</span>';
                            }
                            ?>
                        </td>
                        <td><?php echo htmlspecialchars($cliente['fecha_inicio']); ?></td>
                        <td><?php echo htmlspecialchars($cliente['fecha_final']); ?></td>
                        <td class="actions">
    <form method="post" class="tooltip">
        <input type="hidden" name="id_cliente" value="<?php echo $cliente['ID_Cliente']; ?>">
        <button type="button" class="icon-button" onclick="showModal('modalModificarCliente', <?php echo $cliente['ID_Cliente']; ?>)">
            <i class="fas fa-edit"></i>
        </button>
        <span class="tooltiptext">Modificar</span>
    </form>
    <form method="post" class="tooltip">
        <input type="hidden" name="id_cliente" value="<?php echo $cliente['ID_Cliente']; ?>">
        <button type="submit" name="suspender" class="icon-button">
            <i class="fas fa-pause"></i>
        </button>
        <span class="tooltiptext">Suspender</span>
    </form>
    <form method="post" class="tooltip">
        <input type="hidden" name="id_cliente" value="<?php echo $cliente['ID_Cliente']; ?>">
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

