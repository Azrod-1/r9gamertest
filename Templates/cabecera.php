<!DOCTYPE html>
<html lang="em">
<head>
    <meta charset="Utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>R9Gamer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" integrity="sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK" crossorigin="anonymous"></script>
</head>
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

<body style="background-color: #000; color: #fff;">
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="logo.jpg" alt="MiTiend" style="height: 50px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#my-nav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="my-nav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="mostrarCarrito.php">Carrito(<?php echo(empty($_SESSION['CARRITO'])) ? 0 : count($_SESSION['CARRITO']); ?>)</a>
                    </li>
                </ul>

                <!-- BUSCADOR -->
                <form class="d-flex ms-auto me-3" action="buscar.php" method="get">
                    <input class="form-control me-2" type="search" name="buscar" placeholder="Buscar producto" aria-label="Buscar">
                    <button class="btn btn-outline-success" type="submit">Buscar</button>
                </form>

                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link social-icon" href="https://web.facebook.com/profile.php?id=61564369989097" target="_blank">
                            <i class="fab fa-facebook-f fa-lg text-black"></i>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link social-icon" href="https://www.instagram.com/r9_gamer_oficial/" target="_blank">
                            <i class="fab fa-instagram fa-lg text-black"></i>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link social-icon" href="https://wa.me/51972132682" target="_blank">
                            <i class="fab fa-whatsapp fa-lg text-black"></i>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link social-icon" href="https://www.tiktok.com/@r9_gamer" target="_blank">
                            <i class="fab fa-tiktok fa-lg text-black"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <form class="d-flex" action="buscar.php" method="GET">
    <input class="form-control me-2" type="search" name="buscar" placeholder="Buscar productos..." aria-label="Buscar">
    <select class="form-select me-2" name="orden">
        <option value="">Ordenar por...</option>
        <option value="az">Nombre (A-Z)</option>
        <option value="za">Nombre (Z-A)</option>
        <option value="precio_asc">Precio (menor a mayor)</option>
        <option value="precio_desc">Precio (mayor a menor)</option>
    </select>
    <button class="btn btn-outline-success" type="submit">Buscar</button>
</form>


    <!-- Carrusel -->
    <br/>
    <br/>
    <div id="carouselExample" class="carousel slide mb-4" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="Imagenes/banner.jpg" class="d-block w-100" alt="Slide 1" style="height: 400px;">
            </div>
            <div class="carousel-item">
                <img src="Imagenes/CarruIma.jpg" class="d-block w-100" alt="Slide 2" style="height: 400px;">
            </div>
            <div class="carousel-item">
                <img src="Imagenes/CarruIma2.png" class="d-block w-100" alt="Slide 3" style="height: 400px;">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>

    <div class="container">