<?php

    function obterProductos()
    {
        $sql = 'SELECT * FROM productos';
        $pdoStatement = $GLOBALS['connection']->prepare($sql);
        $pdoStatement->execute();
        
        $result = $pdoStatement -> fetchAll();
        return $result;
    }

    function obterProductosPorId($id)
    {
        $sql = 'SELECT * FROM productos WHERE idProducto = ?';
        $pdoStatement = $GLOBALS['connection']->prepare($sql);
        $pdoStatement->bindParam(1, $id);
        $pdoStatement->execute();
        
        $result = $pdoStatement -> fetchAll();
        return $result;
    }

    function obterComentariosModerados($id) 
    {
        $sql = 'SELECT * FROM comentarios WHERE idProducto = ? AND moderado LIKE "si"';
        $pdoStatement = $GLOBALS['connection']->prepare($sql);
        $pdoStatement->bindParam(1, $id);
        $pdoStatement->execute();

        $result = $pdoStatement -> fetchAll();
        $count = count($result);

        if($count > 0){
            return $result;
        } else {
            return array([]);
        }  
    }

    function obterComentariosNonModerados() 
    {
        $sql = 'SELECT p.imaxe as imaxe, p.nome as nome, u.nome as usuario, c.comentario as comentario FROM productos p, usuarios u, comentarios c 
        WHERE c.usuario = u.nome AND c.idProducto = p.idProducto AND c.moderado LIKE "non"';
        $pdoStatement = $GLOBALS['connection']->prepare($sql);
        $pdoStatement->execute();

        $result = $pdoStatement -> fetchAll();
        return $result;
        
    }

    function estadoComentarios($usuario, $producto) 
    {
        $sql = 'SELECT * FROM comentarios WHERE usuario LIKE ? AND idProducto = ?';
        $pdoStatement = $GLOBALS['connection']->prepare($sql);
        $pdoStatement->bindParam(1, $usuario);
        $pdoStatement->bindParam(2, $producto);
        $pdoStatement->execute();

        $result = $pdoStatement -> fetchAll();
        $count = count($result); 

        if($count > 0){
            foreach($result as $row){
                if($row['moderado'] == 'si') {
                    return 'comentado';
                } else {
                    return 'moderacion';
                }
            }
        } else {
            return 'sinComentar';
        }     
        
    }
    
    function obterValoracions($id) 
    {
        $sql = 'SELECT AVG(valoracion) as media, COUNT(*) as total FROM comentarios WHERE idProducto = ? AND moderado LIKE "si" GROUP BY idProducto';
        $pdoStatement = $GLOBALS['connection']->prepare($sql);
        $pdoStatement->bindParam(1, $id);
        $pdoStatement->execute();
        
        $result = $pdoStatement -> fetchAll();
        $count = count($result); 

        if($count > 0){
            foreach($result as $row){        
                return [number_format($row['media'], 1), $row['total']];
            }
        } else {
            return [0, 0];
        }
    }

    function obterUsuarios()
    {
        $sql = 'SELECT * FROM usuarios WHERE rol LIKE "usuario"';
        $pdoStatement = $GLOBALS['connection']->prepare($sql);
        $pdoStatement->execute();
        
        $result = $pdoStatement -> fetchAll();
        return $result;
    }

?>