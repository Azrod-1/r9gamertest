<?php

$servidor = "mysql:host=" . SERVIDOR . ";dbname=" . BD;

try {
    $pdo = new PDO(
        $servidor,
        USUARIO,
        PASSWORD,
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
    );
} catch (PDOException $e) {
    //echo "Error de conexión: " . $e->getMessage();
    exit;
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
