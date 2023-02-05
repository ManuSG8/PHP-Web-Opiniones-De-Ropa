<?php
    require('config/connection.php');
    require('functions/queries.php');
    require('functions/functions.php');

    session_start();

    if(isset($_POST['login'])) {

        if(!isset($_POST['contrasinal'])) {
            header('Location: login.php');
        }

        $consulta = "SELECT contrasinal, rol, nome FROM usuarios WHERE nome=:nomeTecleado";
        $stmt =  $GLOBALS['connection']->prepare($consulta);

        try {
            $stmt->execute(array('nomeTecleado' => $_POST['nomeUsuario']));
        } catch (PDOException $ex) {
            $pdo = null;
            die("Erro recuperando os datos da BD: " . $ex->getMessage());
        }
        $fila=$stmt->fetch();
        if($stmt->rowCount() == 1) {
            $contrasinalBD=$fila[0];
        }
        
        $passTecleado=$_POST['contrasinal'];

        if ($stmt->rowCount() == 0 || !password_verify($passTecleado,$contrasinalBD)) {
            header('Location: login.php');
        } else {
            $_SESSION['rol'] = $fila[1];
            $_SESSION['usuario'] = $fila[2];
            if(!isset($_SESSION['marcadecontrol'])){
                session_regenerate_id(true);
                $_SESSION['marcadecontrol']= true;
            }
        }

        $stmt = null;
        $pdo = null;  

        actualizarLogin($_POST['nomeUsuario']);

        $idioma = $_POST['idioma'];
        if(!isset($_COOKIE['idioma'])) {
            setcookie('idioma', $idioma, time() + 300);
            header('Location: mostra.php');
        }
    }


    if(!isset($_SESSION['usuario'])){
        header('Location: login.php');
    }

    if(isset($_POST['engadirComentario'])) {
        insertarComentario(htmlentities($_POST['usuario']), htmlentities($_POST['producto']), htmlentities($_POST['comentario']), htmlentities($_POST['valoracion']));
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
    <link rel="stylesheet" href="styles/estilosMostra.css" />
    <title>Mostra</title>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="nav">
        <div class="container-fluid">
            <a href="#">
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

                <?php
                    if(isset($_COOKIE['idioma'])) {
                        saudo($_COOKIE['idioma']);
                    } else {
                        echo '';
                    }
                ?>
            </div>
            <a href="pecharSesion.php">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6" id="logout">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                </svg>	  
            </a>
        </div>
    </nav>

<div class="contenedor">
    
    <?php

        foreach (obterProductos() as $row) {
            $valoracion = obterValoracions($row['idProducto']);
            echo "<div class='card' style='width: 18rem;'>
            <span class='badge bg-success etiqueta'>".$row['familia']."</span>
            <span class='badge bg-info valoracion'>".$valoracion[0]." / 5
                <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='w-6 h-6'>
                <path stroke-linecap='round' stroke-linejoin='round' d='M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z'/>
                </svg>
                    ( ".$valoracion[1]." opiniones )
            </span>
            <img src='imaxes/".$row['imaxe']."' class='card-img-top' alt='...'>
            <div class='card-body'>
                <h5 class='card-title'>".$row['nome']."</h5>
                <p class='card-text'>".$row['descripcion']."</p>
            </div>
            <ul class='list-group list-group-flush'>";
                
                foreach(obterComentariosModerados($row['idProducto']) as $coment) {
                    if(empty($coment)) {
                        echo "<li class='list-group-item'>Sin comentarios</li>";
                    } else {
                        echo "<li class='list-group-item'><b>".$coment['usuario']."</b><br>".$coment['comentario']."</li>";
                    }
                }
            
            echo "</ul>
            <div class='card-body etiqueta'>";

            $coment = estadoComentarios($_SESSION['usuario'], $row['idProducto']);
            if($coment == 'moderacion') {
                echo "<span class='badge bg-warning comentado'>En moderación</span>";
            } else if($coment == 'comentado') {
                echo "<span class='badge bg-success comentado'>Comentado</span>";

            } else if($coment == 'sinComentar'){
                echo "<form action='engadeComentario.php' method='POST'>
                        <input type='text' name='id' value='".$row['idProducto']."' hidden>
                        <input type='text' name='imaxe' value='".$row['imaxe']."' hidden>
                        <input type='submit' name='comentar' value='Comentar' class='btn btn-primary'>
                    </form>";
            }
        
            echo "</div>
        </div>";
        }

    ?>
        
    </div>
</body>
</html>