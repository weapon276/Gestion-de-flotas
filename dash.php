<?php
session_start();
require 'modelo/conexion.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
}

$user_type_id = $_SESSION['userType'];
$username = $_SESSION['username'];
$usuario_id = $_SESSION['userId'];

// Obtener el nombre y la imagen del empleado
$query = "SELECT Nombre, ApellidoP, Imagen FROM empleado WHERE fk_idUsuario = :usuario_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
$stmt->execute();
$empleado = $stmt->fetch(PDO::FETCH_ASSOC);
$nombreEmpleado = $empleado['Nombre'];
$apellidoEmpleado = $empleado['ApellidoP'];
$imagenEmpleado = $empleado['Imagen'];

// Obtener el nombre del tipo de usuario
$query = "SELECT NombreTypeUser FROM typeuser WHERE id_TypeUser = :user_type_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':user_type_id', $user_type_id, PDO::PARAM_INT);
$stmt->execute();
$user_type = $stmt->fetch(PDO::FETCH_ASSOC)['NombreTypeUser'];

// Función para verificar acceso
function verificarAcceso($user_type, $paginasPermitidas) {
    $paginaActual = basename($_SERVER['PHP_SELF']);
    if (!in_array($paginaActual, $paginasPermitidas)) {
        echo "<script>
            alert('No tienes acceso a esta página.');
            setTimeout(function() {
                window.location.href = '../index.php';
            }, 3000);
        </script>";
        exit();
    }
}

// Definir páginas permitidas por tipo de usuario
$paginasPermitidas = [
    'Admin' => ['inicioa.php', 'gestionar_usuarios.php', 'gestionar_empleado.php', 'gestionar_camiones.php'],
    'Administrador' => ['inicioa.php', 'gestionar_usuarios.php', 'seguros.php', 'camion.php', 'gestionar_empleado.php', 'gestionar_camiones.php'],
    'Contabilidad' => ['gestionar_cotizacion.php', 'clientes.php', 'servicios.php', 'seguro.php', 'dolly.php', 'infoc.php', 'seguros.php', 'cotizacion.php', 'cotizaciont.php', 'rutas.php', 'camion.php', 'alta_cliente.php', 'facturas.php', 'gestionar_facturas.php', 'remolque.php', 'index.php', 'viaje.php', 'cliente.php', 'gestion_camiones.php'],
    'Recursos Humanos' => ['index.php', 'inicio.php', 'seguros.php', 'gestionar_empleados.php', 'registrar_empleado.php'],
    'Operador' => ['index.php', 'viaje.php'],
    'Cliente' => ['cliente_viajes.php', 'consultar_facturas.php'],
    'Prospecto' => ['cliente_viajes.php', 'consultar_facturas.php']
];

// Verificar si el usuario tiene acceso a la página actual
verificarAcceso($user_type, $paginasPermitidas[$user_type] ?? ['../index.php']);

// Función para generar el menú
function generarMenu($user_type) {
    $menu = "<ul class='nav nav-pills flex-column mb-auto'>";
    switch ($user_type) {
        case 'Admin':
            $menu .= "<li class='nav-item'><a href='inicioa.php' class='nav-link'>🏠 Inicio</a></li>";
            break;
        case 'Administrador':
            $menu .= "<li class='nav-item'><a href='inicioa.php' class='nav-link'>🏠 Inicio</a></li>";
            $menu .= "<li class='nav-item'><a href='../controlador/gestionar_usuarios.php' class='nav-link'>👥 Usuarios</a></li>";
            $menu .= "<li class='nav-item'><a href='../controlador/gestionar_empleado.php' class='nav-link'>👔 Gestionar Empleados</a></li>";
            $menu .= "<li class='nav-item'><a href='../controlador/gestionar_camiones.php' class='nav-link'>🚚 Gestionar camiones</a></li>";
            $menu .= "<li class='nav-item'><a href='../controlador/gestionar_operadores.php' class='nav-link'>🧑‍✈️ Gestionar operadores</a></li>";
            $menu .= "<li class='nav-item'><a href='../controlador/gestionar_clientes.php' class='nav-link'>🤝 Gestionar clientes</a></li>";
            $menu .= "<li class='nav-item'><a href='../controlador/gestionar_viajes.php' class='nav-link'>🗺️ Gestionar viajes</a></li>";
            $menu .= "<li class='nav-item'><a href='../controlador/generar_reportes.php' class='nav-link'>📊 Generar reportes</a></li>";
            break;
        case 'Contabilidad':
            $menu .= generarSubmenu('Clientes', [
                ['../modelo/viaje.php', 'fas fa-file-invoice-dollar', 'Inicio'],
                ['cliente.php', 'fas fa-file-invoice', 'Clientes'],
                ['../controlador/alta_cliente.php', 'fas fa-user-plus', 'Registrar Cliente'],
                ['controlador/rutas.php', 'fas fa-map-marked-alt', 'Rutas']
            ]);
            $menu .= generarSubmenu('Cotizaciones', [
                ['gestionar_cotizacion.php', 'fas fa-calculator', 'Cotizaciones'],
                ['modelo/cotizacion.php', 'fas fa-file-alt', 'Nueva Cotización']
            ]);
            $menu .= generarSubmenu('Facturas', [
                ['../controlador/gestionar_facturas.php', 'fas fa-file-invoice', 'Facturas'],
                ['vista/facturas.php', 'fas fa-receipt', 'Nueva Factura']
            ]);
            $menu .= generarSubmenu('Camiones', [
                ['../vista/gestion_camiones.php', 'fas fa-truck', 'Camiones'],
                ['../modelo/remolque.php', 'fas fa-truck-moving', 'Remolques'],
                ['../modelo/seguro.php', 'fas fa-truck-moving', 'Seguro']
            ]);
            break;
        case 'Recursos Humanos':
            $menu .= "<li class='nav-item'><a href='inicio.php' class='nav-link'>🏠 Inicio</a></li>";
            $menu .= "<li class='nav-item'><a href='../controlador/gestionar_empleados.php' class='nav-link'>👥 Gestionar empleados</a></li>";
            $menu .= "<li class='nav-item'><a href='../controlador/registrar_empleado.php' class='nav-link'>➕ Registrar Empleado</a></li>";
            break;
        case 'Operador':
            $menu .= "<li class='nav-item'><a href='viaje.php' class='nav-link'>🚚 Gestionar viajes</a></li>";
            break;
        case 'Cliente':
        case 'Prospecto':
            $menu .= "<li class='nav-item'><a href='../vista/cliente_viajes.php' class='nav-link'>🔍 Consultar viajes</a></li>";
            $menu .= "<li class='nav-item'><a href='consultar_facturas.php' class='nav-link'>📄 Consultar facturas</a></li>";
            break;
    }
    $menu .= "</ul>";
    return $menu;
}

function generarSubmenu($titulo, $items) {
    $submenu = "
    <div class='nav-item'>
        <span class='nav-icon'><i class='fas fa-file-invoice-dollar'></i></span>
        <span class='nav-text'>$titulo</span>
        <span class='nav-arrow'>▸</span>
    </div>
    <div class='submenu'>";
    foreach ($items as $item) {
        $submenu .= "<a href='{$item[0]}' class='submenu-item'><i class='{$item[1]}'></i> {$item[2]}</a>";
    }
    $submenu .= "</div>";
    return $submenu;
}
// Truck management logic
function gestionarCamiones($conn) {
    $per_page = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 10;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $sort = isset($_GET['sort']) ? $_GET['sort'] : 'ID_Camion';
    $order = isset($_GET['order']) && strtoupper($_GET['order']) === 'ASC' ? 'ASC' : 'DESC';
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    $offset = ($page - 1) * $per_page;

    // Fetch trucks
    $sql = "SELECT c.*, e.Nombre as NombreEmpleado 
            FROM camion c 
            LEFT JOIN empleado e ON c.Fk_id_Emplado = e.ID_Empleado
            WHERE c.Placas LIKE :search OR c.Tipo LIKE :search
            ORDER BY $sort $order
            LIMIT :per_page OFFSET :offset";

    $stmt = $conn->prepare($sql);
    $search_term = "%$search%";
    $stmt->bindValue(':search', $search_term, PDO::PARAM_STR);
    $stmt->bindValue(':per_page', $per_page, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $camiones = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get total count for pagination
    $total_sql = "SELECT COUNT(*) as total 
                  FROM camion 
                  WHERE Placas LIKE :search OR Tipo LIKE :search";
    $total_stmt = $conn->prepare($total_sql);
    $total_stmt->bindValue(':search', $search_term, PDO::PARAM_STR);
    $total_stmt->execute();
    $total_records = $total_stmt->fetch(PDO::FETCH_ASSOC)['total'];
    $total_pages = ceil($total_records / $per_page);

    return [
        'camiones' => $camiones,
        'total_pages' => $total_pages,
        'current_page' => $page,
        'per_page' => $per_page,
        'total_records' => $total_records,
        'sort' => $sort,
        'order' => $order,
        'search' => $search
    ];
}
$truckData = gestionarCamiones($conn);

?>