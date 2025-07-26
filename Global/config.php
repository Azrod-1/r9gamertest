<?php
define("kEY","R9Gamer");
define("COD", "AES-128-ECB");

define("SERVIDOR", "localhost:3307");
define("BD", "tienda");
define("USUARIO", "root");
define("PASSWORD", "");

$config = [
    'KEY'      => 'R9Gamer',
    'COD'      => 'AES-128-ECB',
    'SERVIDOR' => 'localhost',
    'BD'       => 'tienda',
    'USUARIO'  => 'root',
    'PASSWORD' => ''
];
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
