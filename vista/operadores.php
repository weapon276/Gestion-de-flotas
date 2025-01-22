<?php
require '../dash.php';
require '../controlador/operadores.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Operadores</title>
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
                <h1 class="title">Gestionar Operadores</h1>
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
                        <th>Licencia</th>
                        <th>Vigencia de Licencia</th>
                        <th>CURP</th>
                        <th>Seguro Social</th>
                        <th>Fecha de Registro</th>
                        <th>Fecha Final</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($operadores as $operador): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($operador['ID_Operador']); ?></td>
                        <td><?php echo htmlspecialchars($operador['Nombre']); ?></td>
                        <td><?php echo htmlspecialchars($operador['Licencia']); ?></td>
                        <td><?php echo htmlspecialchars($operador['Vigencia_Licencia']); ?></td>
                        <td><?php echo htmlspecialchars($operador['CURP']); ?></td>
                        <td><?php echo htmlspecialchars($operador['Seguro_Social']); ?></td>
                        <td><?php echo htmlspecialchars($operador['fecha_inicio']); ?></td>
                        <td><?php echo htmlspecialchars($operador['fecha_final']); ?></td>
                        <td class="actions">
                            <div class="tooltip">
                                <button class="icon-button" onclick="showModal('modalModificarOperador', <?php echo $operador['ID_Operador']; ?>)" title="Modificar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <span class="tooltiptext">Modificar</span>
                            </div>
                            <div class="tooltip">
                                <form method="post" class="d-inline">
                                    <input type="hidden" name="id_operador" value="<?php echo $operador['ID_Operador']; ?>">
                                    <input type="text" name="comentarios" placeholder="Comentarios" required>
                                    <button type="submit" name="eliminar" class="icon-button" title="Eliminar">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                                <span class="tooltiptext">Eliminar</span>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function showModal(modalId, operadorId) {
            // Implement modal functionality here
            console.log(`Showing modal ${modalId} for operador ${operadorId}`);
        }

        document.addEventListener('DOMContentLoaded', (event) => {
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (this.querySelector('[name="eliminar"]')) {
                        if (!confirm('¿Estás seguro de que quieres eliminar este operador?')) {
                            e.preventDefault();
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>