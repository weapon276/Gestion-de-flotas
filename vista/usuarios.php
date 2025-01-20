<?php
require '../controlador/administrador/usuarios.php';
?>
<?php
require '../dash.php';
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../assets/js/dash.js"></script>
    <link rel="stylesheet" href="../assets/css/usuario.css">
   <link rel="stylesheet" href="../assets/css/diseño.css">
   <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="../assets/css/usuario.css">
    <link rel="stylesheet" href="../assets/css/rservicios.css">
    <link rel="stylesheet" href="../assets/css/modal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/clientes.css">
    <link rel="stylesheet" href="../assets/css/diseño.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <title>Gestión de Usuarios</title>
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
                <h1 class="title">Gestión de Usuarios</h1>
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
           
            <button class="btn btn-primary" onclick="showModal('modalAgregarUsuario')">
                <i class="fas fa-plus"></i> Agregar Usuario
            </button>
            <button class="btn btn-secondary" onclick="showModal('modalUsuariosInactivos')">
                <i class="fas fa-user-slash"></i> Ver Usuarios Inactivos
            </button>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Email</th>
                        <th>Tipo de Usuario</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios_activos as $usuario): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($usuario['username']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['vCorreo']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['NombreTypeUser']); ?></td>
                        <td>
                            <span class="status-badge status-active">Activo</span>
                        </td>
                        <td class="actions">
                            <button class="btn btn-warning" onclick="showModal('modalSuspenderUsuario', <?php echo $usuario['id']; ?>)">
                                <i class="fas fa-pause"></i>
                            </button>
                            <button class="btn btn-danger" onclick="showModal('modalEliminarUsuario', <?php echo $usuario['id']; ?>)">
                                <i class="fas fa-trash"></i>
                            </button>
                            <button class="btn btn-primary" onclick="showModal('modalModificarUsuario', <?php echo $usuario['id']; ?>, '<?php echo $usuario['username']; ?>', '<?php echo $usuario['vCorreo']; ?>', <?php echo $usuario['fk_typeuser']; ?>)">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

       <!-- New modal for inactive users -->
<div id="modalUsuariosInactivos" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Usuarios Inactivos</h2>
            <button class="btn btn-close" onclick="closeModal('modalUsuariosInactivos')">&times;</button>
        </div>
        <div class="modal-body">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Email</th>
                            <th>Tipo de Usuario</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios_no_activos as $usuario): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($usuario['username']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['vCorreo']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['NombreTypeUser']); ?></td>
                            <td>
                                <span class="status-badge <?php echo $usuario['bStatus'] === 'Suspendido' ? 'status-suspended' : 'status-inactive'; ?>">
                                    <?php echo htmlspecialchars($usuario['bStatus']); ?>
                                </span>
                                
                            </td>
                            
                            <td>
                                <button class="btn btn-success" onclick="reactivarUsuario(<?php echo $usuario['id']; ?>)">
                                    <i class="fas fa-undo"></i> Reactivar
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Modal Agregar Usuario -->
<div class="modal fade" id="modalAgregarUsuario" tabindex="-1" aria-labelledby="modalAgregarUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAgregarUsuarioLabel">Agregar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="usuarios.php">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="username" class="form-label">Usuario</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="user_type" class="form-label">Tipo de Usuario</label>
                        <select class="form-select" id="user_type" name="user_type" required>
                            <option value="Administrador">Administrador</option>
                            <option value="Contabilidad">Contabilidad</option>
                            <option value="Recursos Humanos">Recursos Humanos</option>
                            <option value="Operador">Operador</option>
                            <option value="Cliente">Cliente</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" name="agregar_usuario">Agregar Usuario</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Suspender Usuario -->
<div class="modal fade" id="modalSuspenderUsuario" tabindex="-1" aria-labelledby="modalSuspenderUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalSuspenderUsuarioLabel">Suspender Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="usuarios.php">
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas suspender a este usuario?</p>
                    <input type="hidden" id="suspender_id_usuario" name="id_usuario">
                    <input type="hidden" name="accion" value="suspender">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning">Suspender</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Eliminar Usuario -->
<div class="modal fade" id="modalEliminarUsuario" tabindex="-1" aria-labelledby="modalEliminarUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEliminarUsuarioLabel">Eliminar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="usuarios.php">
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar a este usuario?</p>
                    <input type="hidden" id="eliminar_id_usuario" name="id_usuario">
                    <input type="hidden" name="accion" value="eliminar">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Modificar Usuario -->
<div class="modal fade" id="modalModificarUsuario" tabindex="-1" aria-labelledby="modalModificarUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalModificarUsuarioLabel">Modificar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="gestionar_usuarios.php">
                <div class="modal-body">
                    <input type="hidden" id="modificar_id_usuario" name="id_usuario">
                    <div class="mb-3">
                        <label for="modificar_username" class="form-label">Usuario</label>
                        <input type="text" class="form-control" id="modificar_username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="modificar_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="modificar_email" name="email" required>
                    </div>
                    <div class="mb-3">
    <label for="user_type" class="form-label">Tipo de Usuario</label>
    <select class="form-select" id="user_type" name="user_type" required>
        <?php
        // Obtener los tipos de usuario desde la base de datos
        $tiposUsuarios = obtenerTiposUsuarios($conn);
        foreach ($tiposUsuarios as $tipo) {
            echo "<option value=\"{$tipo['id_TypeUser']}\">{$tipo['NombreTypeUser']}</option>";
        }
        ?>
    </select>
</div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" name="modificar_usuario">Modificar Usuario</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <script src="https://kit.fontawesome.com/your-code.js"></script>
    <script>
        function showModal(modalId, userId = null, username = '', email = '', userType = '') {
            const modal = document.getElementById(modalId);
            modal.classList.add('active');

            if (userId) {
                const form = modal.querySelector('form');
                if (form) {
                    form.querySelector('[name="id_usuario"]').value = userId;
                    if (modalId === 'modalModificarUsuario') {
                        form.querySelector('[name="username"]').value = username;
                        form.querySelector('[name="email"]').value = email;
                        form.querySelector('[name="user_type"]').value = userType;
                    }
                }
            }
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('active');
        }

        function reactivarUsuario(userId) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.innerHTML = `
                <input type="hidden" name="id_usuario" value="${userId}">
                <input type="hidden" name="accion" value="reactivar">
            `;
            document.body.appendChild(form);
            form.submit();
        }

        // Cerrar modales al hacer clic fuera de ellos
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.classList.remove('active');
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
    var modalSuspenderUsuario = document.getElementById('modalSuspenderUsuario');
    modalSuspenderUsuario.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var input = modalSuspenderUsuario.querySelector('#suspender_id_usuario');
        input.value = id;
    });

    var modalEliminarUsuario = document.getElementById('modalEliminarUsuario');
    modalEliminarUsuario.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var input = modalEliminarUsuario.querySelector('#eliminar_id_usuario');
        input.value = id;
    });

    var modalModificarUsuario = document.getElementById('modalModificarUsuario');
    modalModificarUsuario.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var username = button.getAttribute('data-username');
        var email = button.getAttribute('data-email');
        var userType = button.getAttribute('data-user_type');

        var inputId = modalModificarUsuario.querySelector('#modificar_id_usuario');
        var inputUsername = modalModificarUsuario.querySelector('#modificar_username');
        var inputEmail = modalModificarUsuario.querySelector('#modificar_email');
        var inputUserType = modalModificarUsuario.querySelector('#modificar_user_type');

        inputId.value = id;
        inputUsername.value = username;
        inputEmail.value = email;
        inputUserType.value = userType;
    });
});
    </script>
    <script>
    // Existing JavaScript functions (unchanged)

    function showModal(modalId, userId = null, username = '', email = '', userType = '') {
        const modal = document.getElementById(modalId);
        modal.classList.add('active');

        if (userId) {
            const form = modal.querySelector('form');
            if (form) {
                form.querySelector('[name="id_usuario"]').value = userId;
                if (modalId === 'modalModificarUsuario') {
                    form.querySelector('[name="username"]').value = username;
                    form.querySelector('[name="email"]').value = email;
                    form.querySelector('[name="user_type"]').value = userType;
                }
            }
        }
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.remove('active');
    }

    function reactivarUsuario(userId) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.innerHTML = `
            <input type="hidden" name="id_usuario" value="${userId}">
            <input type="hidden" name="accion" value="reactivar">
        `;
        document.body.appendChild(form);
        form.submit();
    }

    // Close modals when clicking outside
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.classList.remove('active');
        }
    });
</script>
</body>
</html>