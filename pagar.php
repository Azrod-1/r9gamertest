<?php
include 'global/config.php';
include 'global/conexion.php';
include 'carrito.php';
include 'Templates/cabecera.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btnAccion']) && $_POST['btnAccion'] == 'proceder') {

    // VALIDAR CAMPOS
    $errores = [];

    // Método de pago
    $metodoPago = $_POST['MetodoPago'] ?? '';
    if (!in_array($metodoPago, ['Yape', 'Contra Entrega'])) {
        $errores[] = "Método de pago no válido.";
    }

    // Tipo de entrega
    $tipoEntrega = $_POST['TipoEntrega'] ?? '';
    if (!in_array($tipoEntrega, ['Delivery', 'Recojo en Tienda'])) {
        $errores[] = "Debe seleccionar el tipo de entrega.";
    }

    // Nombre cliente
    $nombreCliente = trim($_POST['NombreCliente'] ?? '');
    if (!preg_match('/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]{3,}$/', $nombreCliente)) {
        $errores[] = "Nombre inválido. Debe contener solo letras y espacios (mínimo 3 caracteres).";
    }

    // Dirección (solo obligatoria si es delivery)
    $direccion = trim($_POST['Direccion'] ?? '');
    if ($tipoEntrega == 'Delivery' && empty($direccion)) {
        $errores[] = "La dirección es obligatoria para Delivery.";
    }

    // Teléfono
    $telefono = trim($_POST['Telefono'] ?? '');
    if (!preg_match('/^[0-9]{9}$/', $telefono)) {
        $errores[] = "El teléfono debe tener exactamente 9 dígitos.";
    }

    // Comprobante (solo obligatorio si Yape)
    if ($metodoPago === 'Yape') {
        if (!isset($_FILES['ComprobantePago']) || $_FILES['ComprobantePago']['error'] != 0) {
            $errores[] = "Debe subir un comprobante de pago para Yape.";
        }
    }

    if (!empty($errores)) {
        foreach ($errores as $e) {
            echo "<div class='alert alert-danger'>$e</div>";
        }
        exit;
    }

    // Subir comprobante si corresponde
    $rutaComprobante = "";
    if ($metodoPago === 'Yape') {
        if (!is_dir('uploads')) {
            mkdir('uploads', 0777, true);
        }

        $nombreArchivo = uniqid() . "_" . basename($_FILES["ComprobantePago"]["name"]);
        $rutaDestino = "uploads/" . $nombreArchivo;

        if (move_uploaded_file($_FILES["ComprobantePago"]["tmp_name"], $rutaDestino)) {
            $rutaComprobante = $rutaDestino;
        } else {
            echo "<div class='alert alert-danger'>Error subiendo el comprobante.</div>";
            exit;
        }
    }

    // Calcular total
    $total = 0;
    foreach ($_SESSION['CARRITO'] as $producto) {
        $total += $producto['PRECIO'] * $producto['CANTIDAD'];
    }

    // Sumar movilidad si es delivery
    $movilidad = 0;
    if ($tipoEntrega == 'Delivery') {
        $movilidad = 10.00;
        $total += $movilidad;
    }

    // Guardar venta en la base de datos
    $SID = session_id();
    $correo = $_POST['email'];

    $sentencia = $pdo->prepare("
        INSERT INTO tblventa 
        (CalveTransaccion, Fecha, Correo, Total, Status, MetodoPago, NombreCliente, Direccion, Telefono, ComprobantePago, TipoEntrega, CostoMovilidad)
        VALUES (:CalveTransaccion, NOW(), :Correo, :Total, 'pendiente', :MetodoPago, :NombreCliente, :Direccion, :Telefono, :ComprobantePago, :TipoEntrega, :CostoMovilidad)
    ");
    $sentencia->bindParam(":CalveTransaccion", $SID);
    $sentencia->bindParam(":Correo", $correo);
    $sentencia->bindParam(":Total", $total);
    $sentencia->bindParam(":MetodoPago", $metodoPago);
    $sentencia->bindParam(":NombreCliente", $nombreCliente);
    $sentencia->bindParam(":Direccion", $direccion);
    $sentencia->bindParam(":Telefono", $telefono);
    $sentencia->bindParam(":ComprobantePago", $rutaComprobante);
    $sentencia->bindParam(":TipoEntrega", $tipoEntrega);
    $sentencia->bindParam(":CostoMovilidad", $movilidad);

    $sentencia->execute();

    $idVenta = $pdo->lastInsertId();

    foreach ($_SESSION['CARRITO'] as $producto) {
        $stmt = $pdo->prepare("
            INSERT INTO tbldetalleventas 
            (IDVENTA, IDPRODUCTO, PRECIOUNITARIO, CANTIDAD, DESCARGADO)
            VALUES (:IDVENTA, :IDPRODUCTO, :PRECIOUNITARIO, :CANTIDAD, '0')
        ");
        $stmt->bindParam(":IDVENTA", $idVenta);
        $stmt->bindParam(":IDPRODUCTO", $producto['ID']);
        $stmt->bindParam(":PRECIOUNITARIO", $producto['PRECIO']);
        $stmt->bindParam(":CANTIDAD", $producto['CANTIDAD']);
        $stmt->execute();
    }

    // Construir detalle de productos
    $detalleProductos = "";
    foreach ($_SESSION['CARRITO'] as $producto) {
        $subtotal = $producto['PRECIO'] * $producto['CANTIDAD'];
        $detalleProductos .= "- " . $producto['NOMBRE'] . " (" 
                           . $producto['CANTIDAD'] . " x S/. " 
                           . number_format($producto['PRECIO'], 2) . ") = S/. "
                           . number_format($subtotal, 2) . "\n";
    }

    // Construir mensaje para WhatsApp
    $mensajeWA = "¡Nueva orden!\n";
    $mensajeWA .= "Cliente: $nombreCliente\n";
    $mensajeWA .= "Teléfono: $telefono\n";
    $mensajeWA .= "Correo: $correo\n";
    $mensajeWA .= "Método de Pago: $metodoPago\n";
    $mensajeWA .= "Tipo de Entrega: $tipoEntrega\n";
    $mensajeWA .= "Dirección: $direccion\n";
    if ($movilidad > 0) {
        $mensajeWA .= "Movilidad: S/. " . number_format($movilidad, 2) . "\n";
    }
    $mensajeWA .= "Productos:\n" . $detalleProductos;
    $mensajeWA .= "Total: S/. " . number_format($total, 2);

    $telefonoTienda = "51979621028";
    $urlWA = "https://wa.me/$telefonoTienda?text=" . urlencode($mensajeWA);

    echo "<h3>¡Compra registrada correctamente!</h3>";
    echo "<h4>Total pagado: S/. " . number_format($total, 2) . "</h4>";

    echo "<h4>Detalle de productos:</h4>";
    echo "<pre>$detalleProductos</pre>";

    echo "<div class='alert alert-success'>";
    echo "✅ <strong>Compra registrada correctamente.</strong><br>";
    echo "Total a pagar: S/. " . number_format($total, 2) . "<br>";
    echo "<a href='$urlWA' target='_blank' class='btn btn-success mt-2'>Enviar datos por WhatsApp</a>";
    echo "</div>";

    unset($_SESSION['CARRITO']);
}
?>
<script>
// Bloquear clic derecho
document.addEventListener('contextmenu', e => e.preventDefault());

// Bloquear teclas comunes de inspección
document.addEventListener('keydown', function(e) {
    if (
        e.key === "F12" ||
        (e.ctrlKey && e.shiftKey && e.key === "I") || // Ctrl+Shift+I
        (e.ctrlKey && e.shiftKey && e.key === "J") || // Ctrl+Shift+J
        (e.ctrlKey && e.key === "U") ||              // Ctrl+U
        (e.ctrlKey && e.shiftKey && e.key === "C")   // Ctrl+Shift+C
    ) {
        e.preventDefault();
    }
});
</script>
