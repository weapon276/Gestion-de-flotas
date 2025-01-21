<?php
include '../modelo/conexion.php';
include '../index.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['userType'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['userId'];

function obtenerCamiones($conn) {
    $sql = "SELECT * FROM camion";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function cambiarEstadoCamion($conn, $id, $estado) {
    $sql = "UPDATE camion SET Status=? WHERE ID_Camion=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$estado, $id]);
}

function eliminarCamion($conn, $id, $comentarios) {
    $sql_log = "INSERT INTO log_camiones_bajas (ID_Camion, Placas, Peso, Unidad, Status, Tipo, Poliza_Seguro, GPS, fecha_inicio, fecha_final, comentarios)
                SELECT ID_Camion, Placas, Peso, Unidad, Status, Tipo, Poliza_Seguro, GPS, fecha_inicio, NOW(), ? 
                FROM camion WHERE ID_Camion=?";
    $stmt_log = $conn->prepare($sql_log);
    $stmt_log->execute([$comentarios, $id]);

    cambiarEstadoCamion($conn, $id, 'Mantenimiento');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['mantenimiento'])) {
        cambiarEstadoCamion($conn, $_POST['id_camion'], 'Mantenimiento');
    } elseif (isset($_POST['eliminar'])) {
        eliminarCamion($conn, $_POST['id_camion'], $_POST['comentarios']);
    }
}

$camiones = obtenerCamiones($conn);
?>

<?php
// El código PHP permanece sin cambios
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Camiones</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #0095ff;
            --error-color: #ff4d4f;
            --success-color: #52c41a;
            --warning-color: #faad14;
            --text-color: #1a1a1a;
            --text-secondary: #666;
            --bg-color: #f5f7f9;
            --bg-secondary: #ffffff;
            --border-color: #eee;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .title {
            font-size: 2rem;
            color: var(--text-color);
        }

        .table-container {
            background: var(--bg-secondary);
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        th {
            background-color: var(--bg-color);
            font-weight: 600;
            color: var(--text-secondary);
        }

        tr:hover {
            background-color: var(--bg-color);
            transition: background-color 0.3s ease;
        }

        .badge {
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .badge-success {
            background-color: var(--success-color);
            color: white;
        }

        .badge-warning {
            background-color: var(--warning-color);
            color: white;
        }

        .badge-danger {
            background-color: var(--error-color);
            color: white;
        }

        .actions {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .icon-button {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            padding: 0.25rem;
            color: var(--text-color);
            transition: color 0.3s ease;
        }

        .icon-button:hover {
            color: var(--primary-color);
        }

        .tooltip {
            position: relative;
            display: inline-block;
        }

        .tooltip .tooltiptext {
            visibility: hidden;
            width: 120px;
            background-color: #555;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -60px;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .tooltip:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
        }

        input[type="text"] {
            padding: 0.5rem;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-size: 0.875rem;
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .actions {
                flex-wrap: wrap;
            }

            .tooltip {
                flex-basis: 100%;
                margin-bottom: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="title">Gestionar Camiones</h1>
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

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (this.querySelector('[name="eliminar"]')) {
                        if (!confirm('¿Estás seguro de que quieres eliminar este camión?')) {
                            e.preventDefault();
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>