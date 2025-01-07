<?php
require 'dash.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Cliente</title>
    
    <script src="assets/js/dash.js"></script>
   
   <link rel="stylesheet" href="assets/css/diseño.css">
   <link rel="stylesheet" href="assets/css/dashboard.css">
    <link rel="stylesheet" href="assets/css/infoc.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
    <div class="containerc">
        <aside class="sidebarc">
            <div class="balance-section">
                <div class="balance-labelc">
                    <span>Saldos</span>
                    <span class="status-badge">vigente</span>
                </div>
                <div class="balance-amount">
                    $ 1,466.25 <span class="currency">MXN</span>
                </div>
                <p class="balance-note">
                    Los saldos son por moneda de cada una de las ventas abiertas sin liquidar.
                </p>
            </div>

            <div class="credit-info">
                <h3 style="margin-bottom: 12px;">Tipo de crédito</h3>
                <div style="font-size: 14px; color: var(--text-secondary);">
                    <div>Limitado $ 1,000.00 MXN</div>
                    <div>Disponible $ 266.87 MXN</div>
                    <div>Utilizado $ 733.13 MXN</div>
                </div>
            </div>

            <div class="counters-grid">
                <div class="counter-item">
                    <div class="counter-value">3</div>
                    <div class="counter-label">Ventas</div>
                </div>
                <div class="counter-item">
                    <div class="counter-value">0</div>
                    <div class="counter-label">CFDIs</div>
                </div>
                <div class="counter-item">
                    <div class="counter-value">0</div>
                    <div class="counter-label">Cotizaciones</div>
                </div>
            </div>
        </aside>
        <main class="main-contentc">
            <div class="tabs">
                <div class="tab active">Datos</div>
                <div class="tab">Resumen</div>
            </div>

            <div class="tab-content">
                <section class="section">
                    <div class="section-header">
                        <h2 class="section-title">RFCs</h2>
                        <div>
                            <button class="btn btn-secondary">Relacionar</button>
                            <button class="btn btn-primary">Nuevo</button>
                        </div>
                    </div>

                    <div class="search-bar">
                        <input type="text" class="search-input" placeholder="Buscar...">
                    </div>

                    <div class="table-containerc">
                        <table>
                            <thead>
                                <tr>
                                    <th>Razón social</th>
                                    <th>RFC</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="3">
                                        <div class="empty-state">
                                            Ningún dato disponible en esta tabla
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="pagination">
                            <span>Mostrando registros del 0 al 0 de un total de 0 registros</span>
                            <div>
                                <button class="btn btn-secondary">Recargar</button>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>
</body>
</html>