<?php

session_start();


$mensaje = "";


if (isset($_POST['btnAccion'])) {
    switch ($_POST['btnAccion']) {
        case 'Agregar':
            if (isset($_POST['id'])) {
                $id_encriptado = $_POST['id'];
                $ID = openssl_decrypt($id_encriptado, $config['COD'], $config['KEY']);

                if ($ID === false || !is_numeric($ID)) {
                    $mensaje .= "Upss... ID incorrecto.<br/>";
                    break;
                }
            } else {
                $mensaje = "No se recibió ningún ID.<br/>";
                break;
            }

            if (isset($_POST['nombre'])) {
                $nombre_encrypted = $_POST['nombre'];
                $NOMBRE = openssl_decrypt($nombre_encrypted, $config['COD'], $config['KEY']);

                if ($NOMBRE === false || $NOMBRE === "") {
                    $mensaje .= "Upps.. algo pasa con el nombre.<br/>";
                    break;
                }
            } else {
                $mensaje .= "No se recibió el nombre.<br/>";
                break;
            }

            if (isset($_POST['cantidad'])) {
                $cantidad_encrypted = $_POST['cantidad'];
                $CANTIDAD = openssl_decrypt($cantidad_encrypted, $config['COD'], $config['KEY']);

                if ($CANTIDAD === false || !is_numeric($CANTIDAD)) {
                    $mensaje .= "Upps.. algo pasa con la cantidad.<br/>";
                    break;
                }
            } else {
                $mensaje .= "No se recibió la cantidad.<br/>";
                break;
            }

            if (isset($_POST['precio'])) {
                $precio_encrypted = $_POST['precio'];
                $PRECIO = openssl_decrypt($precio_encrypted, $config['COD'], $config['KEY']);

                if ($PRECIO === false || !is_numeric($PRECIO)) {
                    $mensaje .= "Upps.. algo pasa con el precio.<br/>";
                    break;
                }
            } else {
                $mensaje .= "No se recibió el precio.<br/>";
                break;
            }

            if (!isset($_SESSION['CARRITO'])) {
                $_SESSION['CARRITO'] = array();
            }

            $idProductos = array_column($_SESSION['CARRITO'], 'ID');

            if (in_array($ID, $idProductos)) {
                echo "<script>alert('El producto ya ha sido seleccionado...');</script>";
            } else {
                $producto = array(
                    'ID' => $ID,
                    'NOMBRE' => $NOMBRE,
                    'CANTIDAD' => $CANTIDAD,
                    'PRECIO' => $PRECIO
                );

                $_SESSION['CARRITO'][] = $producto;
                $mensaje = "Producto agregado al carrito.<br/>";
            }
            break;

        case "Eliminar":
            if (isset($_POST['id'])) {
                $id_encriptado = $_POST['id'];
                $ID = openssl_decrypt($id_encriptado, $config['COD'], $config['KEY']);
                if ($ID !== false) {
                    foreach ($_SESSION['CARRITO'] as $indice => $producto) {
                        if ($producto['ID'] == $ID) {
                            unset($_SESSION['CARRITO'][$indice]);
                            $_SESSION['CARRITO'] = array_values($_SESSION['CARRITO']);
                            echo "<script>alert('Producto eliminado correctamente');</script>";
                            break;
                        }
                    }
                } else {
                    $mensaje .= "Upss... ID incorrecto<br/>";
                }
            }
            break;

        case 'Incrementar':
            if (isset($_POST['id'])) {
                $ID = openssl_decrypt($_POST['id'], $config['COD'], $config['KEY']);
                foreach ($_SESSION['CARRITO'] as &$producto) {
                    if ($producto['ID'] == $ID) {
                        $producto['CANTIDAD']++;
                        break;
                    }
                }
                unset($producto);
            }
            break;

        case 'Decrementar':
            if (isset($_POST['id'])) {
                $ID = openssl_decrypt($_POST['id'], $config['COD'], $config['KEY']);
                foreach ($_SESSION['CARRITO'] as &$producto) {
                    if ($producto['ID'] == $ID && $producto['CANTIDAD'] > 1) {
                        $producto['CANTIDAD']--;
                        break;
                    }
                }
                unset($producto);
            }
            break;
    }
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
