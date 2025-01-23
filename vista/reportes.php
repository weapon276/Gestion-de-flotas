
<?php
require '../dash.php';
require '../controlador/reportes.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Reportes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
    <link rel="stylesheet" href="../assets/css/reporte.css">
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
                <h1>Generar Reportes</h1>
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
    
        <form method="post">
            <div class="form-group">
                <label for="tipo_reporte">Tipo de Reporte</label>
                <select id="tipo_reporte" name="tipo_reporte" required>
                    <option value="cliente">Clientes</option>
                    <option value="viaje">Viajes</option>
                    <option value="operador">Operadores</option>
                    <option value="camion">Camiones</option>
                    <option value="usuarios">Usuarios</option>
                    <option value="factura">Facturas</option>
                    <option value="liquidacion">Liquidaciones</option>
                    <option value="log_movimientos">Log de Movimientos</option>
                    <option value="historial">Historial Completo</option>
                </select>
            </div>
            <div class="form-group">
                <label for="formato">Formato</label>
                <select id="formato" name="formato" required>
                    <option value="xml">XML</option>
                    <option value="pdf">PDF</option>
                </select>
            </div>
            <div class="form-group">
                <label for="fecha_inicio">Fecha de Inicio</label>
                <input type="date" id="fecha_inicio" name="fecha_inicio" required>
            </div>
            <div class="form-group">
                <label for="fecha_fin">Fecha de Fin</label>
                <input type="date" id="fecha_fin" name="fecha_fin" required>
            </div>
            <button type="submit" class="btn">
                <i class="fas fa-file-export"></i> Generar Reporte
            </button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('fecha_fin').value = today;
            
            const oneMonthAgo = new Date();
            oneMonthAgo.setMonth(oneMonthAgo.getMonth() - 1);
            document.getElementById('fecha_inicio').value = oneMonthAgo.toISOString().split('T')[0];
        });
    </script>
</body>
</html>

