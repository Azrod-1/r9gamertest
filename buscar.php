<?php
include 'global/config.php';
include 'global/conexion.php';
include 'carrito.php';

$terminoBusqueda = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';
$ordenSeleccionado = isset($_GET['orden']) ? $_GET['orden'] : '';

if ($terminoBusqueda === "") {
    header("Location: index.php");
    exit;
}

include 'Templates/cabecera.php';

// Definir orden SQL
switch ($ordenSeleccionado) {
    case 'az':
        $ordenSQL = " ORDER BY Nombre ASC";
        break;
    case 'za':
        $ordenSQL = " ORDER BY Nombre DESC";
        break;
    case 'precio_asc':
        $ordenSQL = " ORDER BY Precio ASC";
        break;
    case 'precio_desc':
        $ordenSQL = " ORDER BY Precio DESC";
        break;
    default:
        $ordenSQL = "";
        break;
}

// Tablas a consultar
$tablas = [
    'tblproducto',
    'tblacclaps',
    'tbllaps',
    'tblmonitores',
    'tbltarggra'
];

$listaProductos = [];

foreach ($tablas as $tabla) {
    $sql = "SELECT * FROM `$tabla`
            WHERE Nombre COLLATE utf8mb4_general_ci LIKE :termino
            $ordenSQL";

    $stmt = $pdo->prepare($sql);
    $like = "%" . $terminoBusqueda . "%";
    $stmt->bindParam(':termino', $like, PDO::PARAM_STR);
    $stmt->execute();

    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $listaProductos = array_merge($listaProductos, $resultados);
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

<div class="container mt-5 pt-5">
    <h3 class="mb-4 text-center">
        Resultados para:
        <span class="text-success"><?php echo htmlspecialchars($terminoBusqueda); ?></span>
    </h3>

    <div class="mb-4">
        <form class="row g-2 justify-content-center" action="buscar.php" method="get">
            <input type="hidden" name="buscar" value="<?php echo htmlspecialchars($terminoBusqueda); ?>">
            <div class="col-auto">
                <select class="form-select" name="orden">
                    <option value="">Ordenar por...</option>
                    <option value="az" <?php if($ordenSeleccionado=="az") echo "selected"; ?>>Nombre (A-Z)</option>
                    <option value="za" <?php if($ordenSeleccionado=="za") echo "selected"; ?>>Nombre (Z-A)</option>
                    <option value="precio_asc" <?php if($ordenSeleccionado=="precio_asc") echo "selected"; ?>>Precio (menor a mayor)</option>
                    <option value="precio_desc" <?php if($ordenSeleccionado=="precio_desc") echo "selected"; ?>>Precio (mayor a menor)</option>
                </select>
            </div>
            <div class="col-auto">
                <button class="btn btn-primary" type="submit">Aplicar</button>
            </div>
        </form>
    </div>
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

    <?php if (empty($listaProductos)) { ?>
        <div class="alert alert-warning text-center">
            No se encontraron productos para tu búsqueda.
        </div>
    <?php } else { ?>
        <div class="row">
            <?php foreach ($listaProductos as $producto) { ?>
                <div class="col-3">
                    <div class="card mb-4">
                        <img
                            title="<?php echo htmlspecialchars($producto['Nombre']); ?>"
                            alt="<?php echo htmlspecialchars($producto['Nombre']); ?>"
                            class="card-img-top"
                            style="height: 200px; object-fit: contain;"
                            src="<?php echo htmlspecialchars($producto['Imagen']); ?>"
                            data-bs-toggle="popover"
                            data-bs-trigger="hover"
                            data-bs-content="<?php echo htmlspecialchars($producto['Descripcion']); ?>"
                        >
                        <div class="card-body text-center">
                            <span class="fw-bold"><?php echo htmlspecialchars($producto['Nombre']); ?></span>
                            <h5 class="card-title text-success">S/.<?php echo htmlspecialchars($producto['Precio']); ?></h5>
                            <p class="card-text">- Precio incluye I.G.V.<br>- Precio sujeto a cambios</p>

                            <form action="" method="post">
                                <input type="hidden" name="id" value="<?php echo openssl_encrypt($producto['ID'], COD, kEY); ?>">
                                <input type="hidden" name="nombre" value="<?php echo openssl_encrypt($producto['Nombre'], COD, kEY); ?>">
                                <input type="hidden" name="precio" value="<?php echo openssl_encrypt($producto['Precio'], COD, kEY); ?>">
                                <input type="hidden" name="cantidad" value="<?php echo openssl_encrypt(1, COD, kEY); ?>">

                                <button class="btn btn-primary" name="btnAccion" value="Agregar" type="submit">
                                    Agregar al carrito
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>

<script>
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
      return new bootstrap.Popover(popoverTriggerEl)
    })
</script>

<?php
include 'Templates/pie.php';
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
