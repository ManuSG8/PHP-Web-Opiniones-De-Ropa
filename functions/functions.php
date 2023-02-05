<?php

    function alerta_green($mensaje)
    {
        echo "<div class='alert alert-success alert-dismissible fade show shadow' role='alert' style='z-index: 1; position: absolute; top: 5%; left: calc(50% - 195.5px);'>
                    <strong>Correcto!</strong> $mensaje
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
    }

    function alerta_red($mensaje)
    {
        echo "<div class='alert alert-danger alert-dismissible fade show shadow' role='alert' style='z-index: 1; position: absolute; top: 5%; left: calc(50% - 195.5px);'>
                    <strong>Erro!</strong> $mensaje
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
    }

    function saudo($eleccion)
    {
        $idiomas = ['Benvido a DressDebate', 'Bienvenido a DressDebate', 'Welcome to DressDebate', 'Benvenuto a DressDebate', 'Willkommen zu DressDebate'];

        echo "<h1 class='h1'>".$idiomas[$eleccion]."</h1>";
    }

    function subirImagen($imagen)
    {
        $tmp_name = $imagen['tmp_name'];
        if (is_uploaded_file($tmp_name)) {
            $img_file = $imagen['name'];
            $img_type = $imagen['type'];
            
            if ((strpos($img_type, "jpeg") || strpos($img_type, "jpg")) || strpos($img_type, "png"))
            {
            
                if (move_uploaded_file($tmp_name, "imaxes/". $img_file)) {
                    echo ""; 
                }

            }
        }

        return $imagen['name'];
    }

    function actualizarLogin($usuario)
    {
        try {
            $actual = date('Y-m-d H:i:s');

            $sql = 'UPDATE usuarios SET data = ? WHERE nome LIKE ?';
            $pdoStatement = $GLOBALS['connection']->prepare($sql);
            $pdoStatement->bindParam(1, $actual);
            $pdoStatement->bindParam(2, $usuario);

            $pdoStatement->execute();

        } catch (PDOException $e) {
            alerta_red('Error' . $e->getMessage());
        }
    }

    function engadirUsuario($data)
    {
        try {
            $nomeUsuario = $data['nomeUsuario'];
            $contrasinal = password_hash($data['contrasinal'], PASSWORD_DEFAULT);
            $nomeCompleto = $data['nomeCompleto'];
            $email = $data['email'];
            $data = "1970/01/01 00:00:00";
            $rol = 'usuario';

            $sql = 'INSERT INTO usuarios (nome, contrasinal, nomeCompleto, email, data, rol) VALUES (?,?,?,?,?,?)';
            $pdoStatement = $GLOBALS['connection']->prepare($sql);
            $pdoStatement->bindParam(1, $nomeUsuario);
            $pdoStatement->bindParam(2, $contrasinal);
            $pdoStatement->bindParam(3, $nomeCompleto);
            $pdoStatement->bindParam(4, $email);
            $pdoStatement->bindParam(5, $data);
            $pdoStatement->bindParam(6, $rol);

            $pdoStatement->execute();

            alerta_green('Usuario engadido correctamente');
        } catch (PDOException $e) {
            alerta_red('Error' . $e->getMessage());
        }
    }

    function insertarComentario($usuario, $producto, $comentario, $valoracion)
    {
        try {
            $dataCreacion = date('Y-m-d H:i:s');
            $moderado = "non";

            $sql = 'INSERT INTO comentarios (usuario, idProducto, comentario, valoracion, dataCreacion, moderado) VALUES (?,?,?,?,?,?)';
            $pdoStatement = $GLOBALS['connection']->prepare($sql);
            $pdoStatement->bindParam(1, $usuario);
            $pdoStatement->bindParam(2, $producto);
            $pdoStatement->bindParam(3, $comentario);
            $pdoStatement->bindParam(4, $valoracion);
            $pdoStatement->bindParam(5, $dataCreacion);
            $pdoStatement->bindParam(6, $moderado);

            $pdoStatement->execute();

            alerta_green('Comentario engadido correctamente');
        } catch (PDOException $e) {
            alerta_red('Error' . $e->getMessage());
        }
    }

    function engadirProducto($nome, $descripcion, $familia, $imaxe)
    {
        try {
            $sql = 'INSERT INTO productos (nome, descripcion, familia, imaxe) VALUES (?,?,?,?)';
            $pdoStatement = $GLOBALS['connection']->prepare($sql);
            $pdoStatement->bindParam(1, $nome);
            $pdoStatement->bindParam(2, $descripcion);
            $pdoStatement->bindParam(3, $familia);
            $pdoStatement->bindParam(4, $imaxe);
            $pdoStatement->execute();

            alerta_green('Producto engadido correctamente');
        } catch (PDOException $e) {
            alerta_red('Error' . $e->getMessage());
        }
    }

    function asignarModerador($usuario) 
    {
        try {

            $sql = 'UPDATE usuarios SET rol = "moderador" WHERE nome LIKE ?';
            $pdoStatement = $GLOBALS['connection']->prepare($sql);
            $pdoStatement->bindParam(1, $usuario);

            $pdoStatement->execute();

            alerta_green('Usuario modificado correctamente');
        } catch (PDOException $e) {
            alerta_red('Error' . $e->getMessage());
        }
    }

    function validarComentario($coment) 
    {
        try {
            $agora = date('Y-m-d H:i:s');

            $sql = 'UPDATE comentarios SET moderado = "si", dataModeracion = ? WHERE comentario LIKE ?';
            $pdoStatement = $GLOBALS['connection']->prepare($sql);
            $pdoStatement->bindParam(1, $agora);
            $pdoStatement->bindParam(2, $coment);

            $pdoStatement->execute();
            alerta_green('Comentario/s validado/s correctamente');
        } catch (PDOException $e) {
            alerta_red('Error' . $e->getMessage());
        }
    }

    function eliminarComentario($coment) 
    {
        try {
            $sql = 'DELETE FROM comentarios WHERE comentario LIKE ?';
            $pdoStatement = $GLOBALS['connection']->prepare($sql);
            $pdoStatement->bindParam(1, $coment);

            $pdoStatement->execute();
            alerta_green('Comentario/s eliminado/s correctamente');
        } catch (PDOException $e) {
            alerta_red('Error' . $e->getMessage());
        }
    }

    function actualizarProducto($nome, $descripcion, $familia, $imaxe, $idProducto)
    {
        try {
            $sql = 'UPDATE productos SET nome = ?, descripcion = ?, familia = ?, imaxe = ? WHERE idProducto = ?';
            $pdoStatement = $GLOBALS['connection']->prepare($sql);
            $pdoStatement->bindParam(1, $nome);
            $pdoStatement->bindParam(2, $descripcion);
            $pdoStatement->bindParam(3, $familia);
            $pdoStatement->bindParam(4, $imaxe);
            $pdoStatement->bindParam(5, $idProducto);

            $pdoStatement->execute();
            alerta_green('Producto actualizado correctamente');
        } catch (PDOException $e) {
            alerta_red('Error' . $e->getMessage());
        }
    }

    function eliminarProducto($producto) 
    {
        try {
            $sql = 'DELETE FROM productos WHERE idProducto = ?';
            $pdoStatement = $GLOBALS['connection']->prepare($sql);
            $pdoStatement->bindParam(1, $producto);

            $pdoStatement->execute();
            alerta_green('Producto/s eliminado/s correctamente');
        } catch (PDOException $e) {
            alerta_red('Error' . $e->getMessage());
        }
    }

?>