<?php
include 'global/config.php';
include 'carrito.php';
include 'Templates/cabecera.php';
?>

<br>
<h3>Lista del carrito</h3>
<?php if (!empty($_SESSION['CARRITO'])) { ?>
    
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

<table class="table table-light table-bordered">
    <tbody>
        <tr>
            <th width="40%">Descripción</th>
            <th width="15%" class="text-center">Cantidad</th>
            <th width="20%" class="text-center">Precio</th>
            <th width="20%" class="text-center">Total</th>
            <th width="5%">--</th>
        </tr>
        <?php $total = 0; ?>
        <?php foreach ($_SESSION['CARRITO'] as $indice => $producto) { ?>
        <tr>
            <td width="40%"><?php echo $producto['NOMBRE'] ?></td>
            <td width="15%" class="text-center">
                <div class="d-flex justify-content-center align-items-center">
                    <!-- Botón Disminuir -->
                    <form action="" method="post" style="margin: 0 5px;">
                        <input type="hidden" name="id" value="<?php echo openssl_encrypt($producto['ID'], COD, kEY); ?>">
                        <button class="btn btn-outline-secondary btn-sm" name="btnAccion" value="Decrementar" type="submit">−</button>
                    </form>

                    <span class="mx-2"><?php echo $producto['CANTIDAD']; ?></span>

                    <!-- Botón Aumentar -->
                    <form action="" method="post" style="margin: 0 5px;">
                        <input type="hidden" name="id" value="<?php echo openssl_encrypt($producto['ID'], COD, kEY); ?>">
                        <button class="btn btn-outline-secondary btn-sm" name="btnAccion" value="Incrementar" type="submit">+</button>
                    </form>
                </div>
            </td>
            <td width="20%" class="text-center">S/. <?php echo number_format($producto['PRECIO'], 2) ?></td>
            <td width="20%" class="text-center">S/. <?php echo number_format($producto['PRECIO'] * $producto['CANTIDAD'], 2); ?></td>
            <td width="5%">
                <form action="" method="post">
                    <input type="hidden" name="id" value="<?php echo openssl_encrypt($producto['ID'], COD, kEY); ?>">
                    <button class="btn btn-danger" type="submit" name="btnAccion" value="Eliminar">Eliminar</button>
                </form>
            </td>
        </tr>
        <?php $total = $total + ($producto['PRECIO'] * $producto['CANTIDAD']); ?>
        <?php } ?>
        <tr>
            <td colspan="3" align="right"><h3>Subtotal</h3></td>
            <td align="right"><h3>S/. <span id="subtotal"><?php echo number_format($total, 2); ?></span></h3></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="3" align="right"><h3>Delivery</h3></td>
            <td align="right"><h3>S/. <span id="deliveryCosto">0.00</span></h3></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="3" align="right"><h3>Total</h3></td>
            <td align="right"><h3>S/. <span id="totalConDelivery"><?php echo number_format($total, 2); ?></span></h3></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="5">
                <form action="pagar.php" method="post" enctype="multipart/form-data">
                    <div class="alert alert-success">

                        <div class="form-group">
                            <label for="metodo_pago">Método de pago</label>
                            <select id="metodo_pago" name="MetodoPago" class="form-control" required>
                                <option value="">Selecciona uno</option>
                                <option value="Yape">Yape</option>
                                <option value="Contra Entrega">Contra Entrega</option>
                            </select>
                        </div>

                        <div class="form-group" id="qrYapeContainer" style="display:none;">
                            <label>Escanea este QR para pagar con Yape:</label><br>
                            <img src="uploads/QR.jpeg" alt="QR Yape" style="max-width: 300px; margin-bottom:10px;">
                            <p class="text-muted">Luego de escanear y pagar, sube tu comprobante.</p>
                        </div>

                        <div class="form-group" id="comprobanteContainer" style="display:none;">
                            <label for="comprobante">Subir Comprobante (Yape)</label>
                            <input type="file" name="ComprobantePago" id="comprobante" class="form-control" accept="image/*,application/pdf">
                        </div>

                        <div class="form-group">
                            <label for="tipo_entrega">Tipo de entrega</label>
                            <select id="tipo_entrega" name="TipoEntrega" class="form-control" required>
                                <option value="">Selecciona una opción</option>
                                <option value="Tienda">Recojo en Tienda</option>
                                <option value="Delivery">Delivery (+ S/.10.00)</option>
                            </select>
                        </div>

                        <div class="form-group" id="direccionGroup" style="display:none;">
                            <label for="direccion">Dirección de entrega</label>
                            <input type="text" name="Direccion" id="direccion" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="nombre">Nombre completo</label>
                            <input type="text" name="NombreCliente" id="nombre" class="form-control" required pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]{3,}" title="Ingrese solo letras y espacios (mínimo 3 caracteres)">
                        </div>

                        <div class="form-group">
                            <label for="telefono">Celular</label>
                            <input type="tel" name="Telefono" id="telefono" class="form-control" required pattern="[0-9]{9}" maxlength="9" title="Debe ingresar exactamente 9 dígitos numéricos">
                        </div>

                        <div class="form-group">
                            <label for="email">Correo de contacto</label>
                            <input id="email" name="email" class="form-control" type="email" placeholder="Por favor escribe tu correo" required>
                        </div>

                        <small class="form-text text-muted">
                            Los productos se enviarán a esta dirección si seleccionas delivery.
                        </small>
                    </div>

                    <button class="btn btn-primary btn-lg btn-block" type="submit" name="btnAccion" value="proceder">
                        Proceder a pagar >>
                    </button>
                </form>
            </td>
        </tr>
    </tbody>
</table>

<script>
document.getElementById('metodo_pago').addEventListener('change', function () {
    const qrContainer = document.getElementById('qrYapeContainer');
    const comprobanteContainer = document.getElementById('comprobanteContainer');

    if (this.value === 'Yape') {
        qrContainer.style.display = 'block';
        comprobanteContainer.style.display = 'block';
    } else {
        qrContainer.style.display = 'none';
        comprobanteContainer.style.display = 'none';
    }
});

document.getElementById('tipo_entrega').addEventListener('change', function () {
    const direccionGroup = document.getElementById('direccionGroup');
    const direccionInput = document.getElementById('direccion');
    const deliveryCosto = document.getElementById('deliveryCosto');
    const totalConDelivery = document.getElementById('totalConDelivery');
    const subtotal = parseFloat(document.getElementById('subtotal').textContent.replace(",", ""));

    if (this.value === 'Delivery') {
        direccionGroup.style.display = 'block';
        direccionInput.required = true;
        deliveryCosto.textContent = "10.00";
        totalConDelivery.textContent = (subtotal + 10).toFixed(2);
    } else {
        direccionGroup.style.display = 'none';
        direccionInput.required = false;
        direccionInput.value = "";
        deliveryCosto.textContent = "0.00";
        totalConDelivery.textContent = subtotal.toFixed(2);
    }
});
</script>

<?php } else { ?>
    <div class="alert alert-success">
        No hay productos en el carrito...
    </div>
<?php } ?>

<?php include 'Templates/pie.php'; ?>
