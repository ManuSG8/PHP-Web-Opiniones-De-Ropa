<?php
    session_start();

    if(!isset($_SESSION['marcadecontrol'])){
        session_regenerate_id(true);
        $_SESSION['marcadecontrol']= true;
    }

    require('config/connection.php');
    require('functions/queries.php');
    require('functions/functions.php');

    if(isset($_SESSION['usuario'])){
        if($_SESSION['rol'] != 'administrador' && $_SESSION['rol'] != 'moderador') {
            header('Location: mostra.php');
        }
    } else {
        header('Location: login.php');
    }

    if(isset($_POST['confirmarEngadir'])) {  
        $imaxe=subirImagen($_FILES['imaxeCrear']);
        engadirProducto(htmlentities($_POST['nomeProductoCrear']), htmlentities($_POST['descripcionCrear']), htmlentities($_POST['familiaCrear']), $imaxe);
    }

    if(isset($_POST['confirmarActualizar'])) {
        if(!empty($_FILES['imaxeNova']['name'])) {

            $imaxe=subirImagen($_FILES['imaxeNova']);
            
        } else {

            $imaxe = htmlentities($_POST['imaxeAntiga']);
        }

        actualizarProducto(htmlentities($_POST['nomeProductoActualizar']), htmlentities($_POST['descripcionActualizar']), htmlentities($_POST['familiaActualizar']), $imaxe, htmlentities($_POST['idProducto']));
    }

    if(isset($_POST['confirmarEliminar'])) {  
        $seleccionados = $_POST['check'];
        foreach($seleccionados as $borrar) {
            eliminarProducto($borrar);
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD"
        crossorigin="anonymous"
    />
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="styles/navbar.css">
    <link rel="stylesheet" href="styles/estilosXestionarProductos.css" />
    <title>Xestionar Productos</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="nav">
        <div class="container-fluid">
            <a href="mostra.php">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6" id="home">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z" />
                </svg>
            </a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a href="mostra.php" class="nav-link">
                            <span>Ver Productos</span>
                        </a>
                    </li>
                    <?php
                    if($_SESSION['rol'] == 'moderador' || $_SESSION['rol'] == 'administrador') {
                        echo "<li class='nav-item'>
                            <a href='xestionarProductos.php' class='nav-link'>
                                <span>Xestionar Productos</span>
                            </a>
                        </li>
                        <li class='nav-item'>
                            <a href='xestionarComentarios.php' class='nav-link'>
                                <span>Xestionar Comentarios</span>
                            </a>
                        </li>";

                        if($_SESSION['rol'] == 'administrador') {
                            echo "<li class='nav-item'>
                                    <a href='xestionarUsuarios.php' class='nav-link'>
                                        <span>Xestionar Usuarios</span>
                                    </a>
                                </li>";
                        }
                    }
                    ?>
                </ul>
            </div>
            <a href="pecharSesion.php">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6" id="logout">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                </svg>	  
            </a>
        </div>
    </nav>

    <h1 class="h1">Xestionar Productos</h1>

    <div class="contenedor">
        <form action="xestionarProductos.php" method="POST" class="formOpciones">
            <div class="opcion">
                <input type="submit" name="engadir" value="Engadir Producto" class="btn btn-success">
                <input type="submit" name="actualizar" value="Actualizar Producto" class="btn btn-info">
                <input type="submit" name="eliminar" value="Eliminar Producto" class="btn btn-danger">
            </div>
        </form>
        <?php
        
            if(isset($_POST['engadir'])) {
        ?>
            <div class="engadir">
                <form action="xestionarProductos.php" method="POST" enctype="multipart/form-data" class="formEngadir">
                    <div class="form-floating mb-3">
                        <input type="text" name="nomeProductoCrear" id="nome" class="form-control" placeholder="Nome do Producto" required>
                        <label for="nome" class="input-group">Nome do Producto</label>
                    </div>

                    <div class="form-floating mb-3">
                        <textarea name="descripcionCrear" id="descripcion" cols="30" rows="10" class="form-control" placeholder="Descripción" tyle="height: 100px" required></textarea>
                        <label for="descripcion" class="input-group">Descripción</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" name="familiaCrear" id="familia" class="form-control" placeholder="Familia" required>
                        <label for="familia" class="input-group">Familia</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="file" name="imaxeCrear" class="form-control" placeholder="Imaxe" required>
                        <label for="imaxe" class="input-group">Imaxe</label>
                    </div>

                    <input type="submit" name="confirmarEngadir" value="Engadir" class="btn btn-primary">
                </form>
            </div>
        <?php        
            }

            if(isset($_POST['actualizar'])) {
        ?>

            <div class="actualizar">
                <form action="xestionarProductos.php" method="POST" enctype="multipart/form-data" class="formSeleccionarActualizar">
                    <div class="form-floating mb-3">
                        <select name="productos" id="productos" class="form-control">
                             <option value="0">-</option>
                            <?php
                                foreach(obterProductos() as $row) {
                                    echo "<option value='".$row['idProducto']."'>".$row['nome']."</option>";
                                }
                            ?>
                        </select>
                        <label for="productos" class="input-group">Seleccionar Producto</label>
                    </div>

                    <input type="submit" name="seleccionarActualizar" value="Seleccionar" class="btn btn-secondary">
                </form>
            </div>

        <?php 
            }

            if(isset($_POST['seleccionarActualizar'])) {
                foreach(obterProductosPorId($_POST['productos']) as $row) {
                    echo "<div class='engadir'>
                        <form action='xestionarProductos.php' method='POST' enctype='multipart/form-data' class='formEngadir'>
                            <input type='text' name='idProducto' value='".$row['idProducto']."' hidden>

                            <div class='form-floating mb-3'>
                                <input type='text' name='nomeProductoActualizar' id='nome' class='form-control' value='".$row['nome']."' placeholder='Nome do Producto'>
                                <label for='nome' class='input-group'>Nome do Producto</label>
                            </div>

                            <div class='form-floating mb-3'>
                                <textarea name='descripcionActualizar' id='descripcion' cols='30' rows='10' class='form-control' placeholder='Descripción' tyle='height: 100px'>".$row['descripcion']."</textarea>
                                <label for='descripcion' class='input-group'>Descripción</label>
                            </div>

                            <div class='form-floating mb-3'>
                                <input type='text' name='familiaActualizar' id='familia' class='form-control' value='".$row['familia']."' placeholder='Familia'>
                                <label for='familia' class='input-group'>Familia</label>
                            </div>

                            <div class='form-floating mb-3'>
                                <input type='file' name='imaxeNova' class='form-control' placeholder='Imaxe'>
                                <label for='imaxe' class='input-group'>Imaxe</label>
                            </div>

                            <input type='text' name='imaxeAntiga' value='".$row['imaxe']."' hidden>
                            <input type='submit' name='confirmarActualizar' value='Actualizar' class='btn btn-primary'>
                        </form>
                    </div>";
                }
            }

            if(isset($_POST['eliminar'])) {
            
        ?>

            <div class="eliminar">
                <form action="xestionarProductos.php" method="POST">
                    <div class="group">
                        <input type="submit" name="confirmarEliminar" value="Eliminar" class="btn btn-danger">
                    </div>
                    <table class="table">
                        <tr><th>Producto</th><th>Nome do Producto</th><th>Descripción</th><th>Familia</th><th>Seleccionar</th></tr>
                            <?php
                            
                                foreach(obterProductos() as $row) {
                                    echo "<tr><td><img src='imaxes/".$row['imaxe']."'></td><td>".$row['nome']."</td><td>".$row['descripcion']."</td><td>".$row['familia']."</td><td><input type='checkbox' name='check[]' value='".$row['idProducto']."'></td></tr>";
                                }
                            
                            ?>
                    </table>
                </form>
            </div>

        <?php 
            }
        ?>
    </div>
    
</body>
</html>