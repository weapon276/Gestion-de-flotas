<?php
include 'modelo/conexion.php';

// Fetch data from the database
$sql = "SELECT v.*, c.Unidad AS NombreCamion, o.Nombre AS NombreOperador, cl.Nombre AS NombreCliente, r.Nombrer AS NombreRuta, co.ID_Cotizacion AS NumeroCotizacion
        FROM viaje v
        LEFT JOIN camion c ON v.ID_Camion = c.ID_Camion
        LEFT JOIN operador o ON v.ID_Operador = o.ID_Operador
        LEFT JOIN cliente cl ON v.ID_Cliente = cl.ID_Cliente
        LEFT JOIN rutas r ON v.Fk_IdRutas = r.ID_Ruta
        LEFT JOIN cotizacion co ON v.Fk_IdCotizacion = co.ID_Cotizacion
        ORDER BY v.fecha_inicio DESC";

try {
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    // Obtener resultados como un array asociativo
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error en la consulta: " . $e->getMessage());
}

?>