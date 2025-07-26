<?php
include 'global/config.php';
include 'global/conexion.php';
include 'carrito.php';
include 'Templates/cabecera.php'

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


        <br>
        <?php if($mensaje!="") ?>
        <div class="alert alert-success">
            <?php echo ($mensaje); ?>
        </div>
        <?php  ?>
        <br/>

        <a class="navbar-brand" class="section-title mb-4"><h2 class="product-title">LAPTOPS</h2></a>
        <!-- CARRUSEL DE accesorios -->
        <div id="carouselLaptops" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                 <?php
                 // Traer todos los productos
                 $sentencia = $pdo->prepare("SELECT * FROM `tbllaps`");
                  $sentencia->execute();
                  $listaProductos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
                  // Dividir en bloques de 4 productos
                  $chunks = array_chunk($listaProductos, 4);
                  $slideIndex = 0;
                  
                  foreach ($chunks as $grupoProductos) {
                    $activo = ($slideIndex === 0) ? "active" : "";
                    echo '<div class="carousel-item '.$activo.'">';
                    echo '<div class="row">';
                    
                    foreach ($grupoProductos as $producto) {
                        ?>
                        <div class="col-3">
                            <div class="card mb-4">
                                <img title="<?php echo htmlspecialchars($producto['Nombre']); ?>"
                                alt="<?php echo htmlspecialchars($producto['Nombre']); ?>"
                                class="card-img-top"
                                style="height: 200px; object-fit: contain;"
                                src="<?php echo htmlspecialchars($producto['Imagen']); ?>"
                                data-bs-toggle="popover"
                                data-bs-trigger="hover"
                                data-bs-content="<?php echo htmlspecialchars($producto['Descripcion']); ?>"
                                height="317px"

                                >
                                <div class="card-body text-center">
                                    <span class="fw-bold"><?php echo htmlspecialchars($producto['Nombre']); ?></span>
                                    <h5 class="card-title text-success">S/.<?php echo htmlspecialchars($producto['Precio']); ?></h5>
                                    <p class="card-text">- Precio incluye I.G.V. <br>- Precio sujeto a cambios</p>

                                    <form action="" method="post">
                                        <input type="hidden" name="id" id="is" value="<?php echo openssl_encrypt($producto['ID'],COD, kEY); ?>">
                                        <input type="hidden" name="nombre" id="nombre" value="<?php echo openssl_encrypt($producto['Nombre'],COD, kEY); ?>">
                                        <input type="hidden" name="precio" id="precio" value="<?php echo openssl_encrypt($producto['Precio'],COD, kEY); ?>">
                                        <input type="hidden" name="cantidad" id="cantidad" value="<?php echo openssl_encrypt(1,COD, kEY); ?>">

                                    <button class="btn btn-primary" name="btnAccion" value="Agregar" type="submit">Agregar al carrito</button>

                                    </form>

                                    
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                        
                        echo '</div>'; // cierre row
                        echo '</div>'; // cierre carousel-item
                        $slideIndex++;
                    }
                    ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselLaptops" data-bs-slide="prev"
                    style="left: -60px; width: 5%;">
                    <span class="carousel-control-prev-icon" style="width: 50px; height: 50px;"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselLaptops" data-bs-slide="next"
                 style="right: -60px; width: 5%;">
                <span class="carousel-control-next-icon" style="width: 50px; height: 50px;"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
          <!-- FIN DEL CARRUSEL -->



        <a class="navbar-brand" class="section-title mb-4"><h2 class="product-title">ACCESORIOS</h2></a>
        <!-- CARRUSEL DE accesorios -->
        <div id="carouselAccesorios" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                 <?php
                 // Traer todos los productos
                 $sentencia = $pdo->prepare("SELECT * FROM `tblproducto`");
                  $sentencia->execute();
                  $listaProductos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
                  // Dividir en bloques de 4 productos
                  $chunks = array_chunk($listaProductos, 4);
                  $slideIndex = 0;
                  
                  foreach ($chunks as $grupoProductos) {
                    $activo = ($slideIndex === 0) ? "active" : "";
                    echo '<div class="carousel-item '.$activo.'">';
                    echo '<div class="row">';
                    
                    foreach ($grupoProductos as $producto) {
                        ?>
                        <div class="col-3">
                            <div class="card mb-4">
                                <img title="<?php echo htmlspecialchars($producto['Nombre']); ?>"
                                alt="<?php echo htmlspecialchars($producto['Nombre']); ?>"
                                class="card-img-top"
                                style="height: 200px; object-fit: contain;"
                                src="<?php echo htmlspecialchars($producto['Imagen']); ?>"
                                data-bs-toggle="popover"
                                data-bs-trigger="hover"
                                data-bs-content="<?php echo htmlspecialchars($producto['Descripcion']); ?>"
                                height="317px"

                                >
                                <div class="card-body text-center">
                                    <span class="fw-bold"><?php echo htmlspecialchars($producto['Nombre']); ?></span>
                                    <h5 class="card-title text-success">S/.<?php echo htmlspecialchars($producto['Precio']); ?></h5>
                                    <p class="card-text">- Precio incluye I.G.V. <br>- Precio sujeto a cambios</p>

                                    <form action="" method="post">
                                        <input type="hidden" name="id" id="is" value="<?php echo openssl_encrypt($producto['ID'],COD, kEY); ?>">
                                        <input type="hidden" name="nombre" id="nombre" value="<?php echo openssl_encrypt($producto['Nombre'],COD, kEY); ?>">
                                        <input type="hidden" name="precio" id="precio" value="<?php echo openssl_encrypt($producto['Precio'],COD, kEY); ?>">
                                        <input type="hidden" name="cantidad" id="cantidad" value="<?php echo openssl_encrypt(1,COD, kEY); ?>">

                                    <button class="btn btn-primary" name="btnAccion" value="Agregar" type="submit">Agregar al carrito</button>

                                    </form>

                                    
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                        
                        echo '</div>'; // cierre row
                        echo '</div>'; // cierre carousel-item
                        $slideIndex++;
                    }
                    ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselAccesorios" data-bs-slide="prev"
                    style="left: -60px; width: 5%;">
                    <span class="carousel-control-prev-icon" style="width: 50px; height: 50px;"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselAccesorios" data-bs-slide="next"
                 style="right: -60px; width: 5%;">
                <span class="carousel-control-next-icon" style="width: 50px; height: 50px;"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
          <!-- FIN DEL CARRUSEL -->



           <br/><br/><br/>
                  <a class="navbar-brand" class="section-title mb-4"><h2 class="product-title">ACCESORIOS PARA LAPTOPS</h2></a>
                  
                  <!-- CARRUSEL DE accesorios -->
                   <div id="carouselAccesoriosLaptop" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                 <?php
                 // Traer todos los productos
                 $sentencia = $pdo->prepare("SELECT * FROM `tblacclaps`");
                  $sentencia->execute();
                  $listaProductos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
                  // Dividir en bloques de 4 productos
                  $chunks = array_chunk($listaProductos, 4);
                  $slideIndex = 0;
                  
                  foreach ($chunks as $grupoProductos) {
                    $activo = ($slideIndex === 0) ? "active" : "";
                    echo '<div class="carousel-item '.$activo.'">';
                    echo '<div class="row">';
                    
                    foreach ($grupoProductos as $producto) {
                        ?>
                        <div class="col-3">
                            <div class="card mb-4">
                                <img title="<?php echo htmlspecialchars($producto['Nombre']); ?>"
                                alt="<?php echo htmlspecialchars($producto['Nombre']); ?>"
                                class="card-img-top"
                                style="height: 200px; object-fit: contain;"
                                src="<?php echo htmlspecialchars($producto['Imagen']); ?>"
                                data-bs-toggle="popover"
                                data-bs-trigger="hover"
                                data-bs-content="<?php echo htmlspecialchars($producto['Descripcion']); ?>"
                                height="317px"

                                >
                                <div class="card-body text-center">
                                    <span class="fw-bold"><?php echo htmlspecialchars($producto['Nombre']); ?></span>
                                    <h5 class="card-title text-success">S/.<?php echo htmlspecialchars($producto['Precio']); ?></h5>
                                    <p class="card-text">- Precio incluye I.G.V. <br>- Precio sujeto a cambios</p>

                                    <form action="" method="post">
                                        <input type="hidden" name="id" id="is" value="<?php echo openssl_encrypt($producto['ID'],COD, kEY); ?>">
                                        <input type="hidden" name="nombre" id="nombre" value="<?php echo openssl_encrypt($producto['Nombre'],COD, kEY); ?>">
                                        <input type="hidden" name="precio" id="precio" value="<?php echo openssl_encrypt($producto['Precio'],COD, kEY); ?>">
                                        <input type="hidden" name="cantidad" id="cantidad" value="<?php echo openssl_encrypt(1,COD, kEY); ?>">

                                    <button class="btn btn-primary" name="btnAccion" value="Agregar" type="submit">Agregar al carrito</button>

                                    </form>

                                    
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                        
                        echo '</div>'; // cierre row
                        echo '</div>'; // cierre carousel-item
                        $slideIndex++;
                    }
                    ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselAccesoriosLaptop" data-bs-slide="prev"
                    style="left: -60px; width: 5%;">
                    <span class="carousel-control-prev-icon" style="width: 50px; height: 50px;"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselAccesoriosLaptop" data-bs-slide="next"
                 style="right: -60px; width: 5%;">
                <span class="carousel-control-next-icon" style="width: 50px; height: 50px;"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
          <!-- FIN DEL CARRUSEL -->


          <a class="navbar-brand" class="section-title mb-4"><h2 class="product-title">MONITORES</h2></a>
        <!-- CARRUSEL DE accesorios -->
        <div id="carouselMonitores" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                 <?php
                 // Traer todos los productos
                 $sentencia = $pdo->prepare("SELECT * FROM `tblmonitores`");
                  $sentencia->execute();
                  $listaProductos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
                  // Dividir en bloques de 4 productos
                  $chunks = array_chunk($listaProductos, 4);
                  $slideIndex = 0;
                  
                  foreach ($chunks as $grupoProductos) {
                    $activo = ($slideIndex === 0) ? "active" : "";
                    echo '<div class="carousel-item '.$activo.'">';
                    echo '<div class="row">';
                    
                    foreach ($grupoProductos as $producto) {
                        ?>
                        <div class="col-3">
                            <div class="card mb-4">
                                <img title="<?php echo htmlspecialchars($producto['Nombre']); ?>"
                                alt="<?php echo htmlspecialchars($producto['Nombre']); ?>"
                                class="card-img-top"
                                style="height: 200px; object-fit: contain;"
                                src="<?php echo htmlspecialchars($producto['Imagen']); ?>"
                                data-bs-toggle="popover"
                                data-bs-trigger="hover"
                                data-bs-content="<?php echo htmlspecialchars($producto['Descripcion']); ?>"
                                height="317px"

                                >
                                <div class="card-body text-center">
                                    <span class="fw-bold"><?php echo htmlspecialchars($producto['Nombre']); ?></span>
                                    <h5 class="card-title text-success">S/.<?php echo htmlspecialchars($producto['Precio']); ?></h5>
                                    <p class="card-text">- Precio incluye I.G.V. <br>- Precio sujeto a cambios</p>

                                    <form action="" method="post">
                                        <input type="hidden" name="id" id="is" value="<?php echo openssl_encrypt($producto['ID'],COD, kEY); ?>">
                                        <input type="hidden" name="nombre" id="nombre" value="<?php echo openssl_encrypt($producto['Nombre'],COD, kEY); ?>">
                                        <input type="hidden" name="precio" id="precio" value="<?php echo openssl_encrypt($producto['Precio'],COD, kEY); ?>">
                                        <input type="hidden" name="cantidad" id="cantidad" value="<?php echo openssl_encrypt(1,COD, kEY); ?>">

                                    <button class="btn btn-primary" name="btnAccion" value="Agregar" type="submit">Agregar al carrito</button>

                                    </form>

                                    
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                        
                        echo '</div>'; // cierre row
                        echo '</div>'; // cierre carousel-item
                        $slideIndex++;
                    }
                    ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselMonitores" data-bs-slide="prev"
                    style="left: -60px; width: 5%;">
                    <span class="carousel-control-prev-icon" style="width: 50px; height: 50px;"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselMonitores" data-bs-slide="next"
                 style="right: -60px; width: 5%;">
                <span class="carousel-control-next-icon" style="width: 50px; height: 50px;"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
          <!-- FIN DEL CARRUSEL -->



          <a class="navbar-brand" class="section-title mb-4"><h2 class="product-title">TARJETAS GRAFICAS</h2></a>
        <!-- CARRUSEL DE accesorios -->
        <div id="carouseltargra" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                 <?php
                 // Traer todos los productos
                 $sentencia = $pdo->prepare("SELECT * FROM `tbltarggra`");
                  $sentencia->execute();
                  $listaProductos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
                  // Dividir en bloques de 4 productos
                  $chunks = array_chunk($listaProductos, 4);
                  $slideIndex = 0;
                  
                  foreach ($chunks as $grupoProductos) {
                    $activo = ($slideIndex === 0) ? "active" : "";
                    echo '<div class="carousel-item '.$activo.'">';
                    echo '<div class="row">';
                    
                    foreach ($grupoProductos as $producto) {
                        ?>
                        <div class="col-3">
                            <div class="card mb-4">
                                <img title="<?php echo htmlspecialchars($producto['Nombre']); ?>"
                                alt="<?php echo htmlspecialchars($producto['Nombre']); ?>"
                                class="card-img-top"
                                style="height: 200px; object-fit: contain;"
                                src="<?php echo htmlspecialchars($producto['Imagen']); ?>"
                                data-bs-toggle="popover"
                                data-bs-trigger="hover"
                                data-bs-content="<?php echo htmlspecialchars($producto['Descripcion']); ?>"
                                height="317px"

                                >
                                <div class="card-body text-center">
                                    <span class="fw-bold"><?php echo htmlspecialchars($producto['Nombre']); ?></span>
                                    <h5 class="card-title text-success">S/.<?php echo htmlspecialchars($producto['Precio']); ?></h5>
                                    <p class="card-text">- Precio incluye I.G.V. <br>- Precio sujeto a cambios</p>

                                    <form action="" method="post">
                                        <input type="hidden" name="id" id="is" value="<?php echo openssl_encrypt($producto['ID'],COD, kEY); ?>">
                                        <input type="hidden" name="nombre" id="nombre" value="<?php echo openssl_encrypt($producto['Nombre'],COD, kEY); ?>">
                                        <input type="hidden" name="precio" id="precio" value="<?php echo openssl_encrypt($producto['Precio'],COD, kEY); ?>">
                                        <input type="hidden" name="cantidad" id="cantidad" value="<?php echo openssl_encrypt(1,COD, kEY); ?>">

                                    <button class="btn btn-primary" name="btnAccion" value="Agregar" type="submit">Agregar al carrito</button>

                                    </form>

                                    
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                        
                        echo '</div>'; // cierre row
                        echo '</div>'; // cierre carousel-item
                        $slideIndex++;
                    }
                    ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouseltargra" data-bs-slide="prev"
                    style="left: -60px; width: 5%;">
                    <span class="carousel-control-prev-icon" style="width: 50px; height: 50px;"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouseltargra" data-bs-slide="next"
                 style="right: -60px; width: 5%;">
                <span class="carousel-control-next-icon" style="width: 50px; height: 50px;"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
          <!-- FIN DEL CARRUSEL -->


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