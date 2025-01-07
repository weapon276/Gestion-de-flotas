<?php
session_start();
require 'modelo/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $nPass = $_POST['nPass'];

    try {
        // Consulta para obtener el usuario y tipo de usuario
        $stmt = $conn->prepare("SELECT id, fk_typeuser, username, nPass FROM usuarios WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si el usuario existe y si la contraseña es correcta
        if ($user && password_verify($nPass, $user['nPass'])) {
            // Verificar si ya hay una sesión activa
            $stmt_session = $conn->prepare("SELECT session_id FROM sesion WHERE user_id = :userId");
            $stmt_session->bindParam(':userId', $user['id']);
            $stmt_session->execute();
            $active_session = $stmt_session->fetch(PDO::FETCH_ASSOC);

            if ($active_session) {
                $error = "Ya tienes una sesión activa. Cierra la sesión en el otro dispositivo antes de iniciar una nueva.";
            } else {
               

                // Establecer las variables de sesión
                $_SESSION['userId'] = $user['id'];
                $_SESSION['username'] = $user['vCorreo'];
                $_SESSION['userType'] = $user['fk_typeuser'];

                // Redirigir al dashboard según el tipo de usuario
                if ($user['fk_typeuser'] == 4) {
                    header("Location: index.php");
                } elseif ($user['fk_typeuser'] == 3) {
                    header("Location: index.php");
                } else {
                    header("Location: index.php");
                }
                exit();
            }
        } else {
            $error = "Correo o contraseña incorrectos";
        }
    } catch (PDOException $e) {
        $error = "Error en la base de datos: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(rgba(90, 90, 90, 0.9), rgba(50, 50, 50, 0.5)), 
                        url('img/andug.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Arial', sans-serif;
            color: #f4c0b2;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .btn-primary {
            background-color: #285de2;
            border: none;
        }

        .btn-primary:hover {
            background-color: #e03c12;
        }

        .form-label {
            color: #285de2;
        }

        .psw a {
            color: #e03c12;
        }

        .psw a:hover {
            color: #ee7755;
        }
    </style>
        <style>
        :root {
            --primary-color: #0095ff;
            --error-color: #ff4d4f;
            --text-color: #1a1a1a;
            --text-secondary: #666;
            --bg-color: #f5f7f9;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        body {
            background: var(--bg-color);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 2rem;
        }

        .login-card {
            background: var(--white);
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header h1 {
            color: var(--text-color);
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--text-color);
            font-size: 0.875rem;
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #eee;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 149, 255, 0.1);
        }

        .form-group .error {
            color: var(--error-color);
            font-size: 0.75rem;
            margin-top: 0.25rem;
            display: none;
        }

        .form-group.error input {
            border-color: var(--error-color);
        }

        .form-group.error .error {
            display: block;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 2.5rem;
            cursor: pointer;
            color: var(--text-secondary);
        }

        .submit-btn {
            width: 100%;
            padding: 0.75rem;
            background: var(--primary-color);
            color: var(--white);
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #0077cc;
        }

        .submit-btn:active {
            transform: scale(0.98);
        }

        .links {
            text-align: center;
            margin-top: 1.5rem;
        }

        .links a {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.875rem;
            transition: color 0.3s ease;
        }

        .links a:hover {
            color: #0077cc;
        }

        .divider {
            margin: 1rem 0;
            border-top: 1px solid #eee;
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            animation: slideIn 0.3s ease-out;
        }

        .alert-danger {
            background-color: #fff2f0;
            border: 1px solid #ffccc7;
            color: var(--error-color);
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
<div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="card p-4 shadow-lg w-100" style="max-width: 400px;">
            <h2 class="text-center mb-4">Iniciar Sesión</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <form method="POST" action="login.php">
                <div class="mb-3">
                    <label for="username" class="form-label">Correo Electrónico</label>
                    <input type="texto" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="nPass" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="nPass" name="nPass" required>
                </div>
                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-primary w-100">Ingresar</button>
                </div>
                <div class="text-center">
                    <span class="psw">¿No tienes cuenta? <a href="registro.php">Registrarte</a></span>
                </div>
                <div class="text-center">
                    <span class="psw">Regresar al <a href="index.php">Inicio</a></span>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
