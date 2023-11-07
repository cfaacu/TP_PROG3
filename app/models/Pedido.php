<?php

class Pedido
{
    public $id;
    public $codigo;
    public $estado;
    public $tiempoEstimado;
    public $nombreCliente;
    public $importe;
    public $idMesa;
    public $idUsuario;
    public $pathFoto;
    public $fechaAlta;
    public $fechaBaja;

    public function crearPedido()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO pedidos (codigo,estado,tiempoEstimado,nombreCliente,importe,idMesa,idUsuario,pathFoto,fechaAlta) VALUES (:codigo,:estado,:tiempoEstimado,:nombreCliente,:importe,:idMesa,:idUsuario,:pathFoto,:fechaAlta)");
        $consulta->bindValue(':codigo', $this->codigo, PDO::PARAM_STR);
        $consulta->bindValue(':estado', $this->estado);
        $consulta->bindValue(':nombreCliente', $this->nombreCliente);
        $consulta->bindValue(':importe', $this->importe);
        $consulta->bindValue(':idMesa', $this->idMesa);
        $consulta->bindValue(':idUsuario', $this->idUsuario);
        $consulta->bindValue(':pathFoto', $this->pathFoto);
        $consulta->bindValue(':fechaAlta', $this->fechaAlta);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM pedidos");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Pedido');
    }

    public static function obtenerPedido($idPedido)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM pedidos WHERE id = :id");
        $consulta->bindValue(':id', $idPedido);
        $consulta->execute();

        return $consulta->fetchObject('Pedido');
    }

    public static function modificarPedido($id,$estado,$nombreCliente,$importe,$idMesa,$idUsuario,$pathFoto)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE pedidos SET estado = :estado , nombreCliente = :nombreCliente, importe = :importe, idMesa = :idMesa, idUsuario = :idUsuario, pathFoto = :pathFoto WHERE id = :id");
        $consulta->bindValue(':estado', $estado);
        $consulta->bindValue(':nombreCliente', $nombreCliente);
        $consulta->bindValue(':importe', $importe);
        $consulta->bindValue(':idMesa', $idMesa);
        $consulta->bindValue(':idUsuario', $idUsuario);
        $consulta->bindValue(':pathFoto', $pathFoto);
        $consulta->bindValue(':id', $id);
        $consulta->execute();
    }

    public static function borrarPedido($idPedido)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE pedidos SET estado = :estado, fechaBaja = :fechaBaja WHERE id = :id");
        $fecha = new DateTime(date("d-m-Y"));
        $consulta->bindValue(':id', $idPedido, PDO::PARAM_INT);
        $consulta->bindValue(':estado', "cancelado");
        $consulta->bindValue(':fechaBaja', date_format($fecha, 'Y-m-d H:i:s'));
        $consulta->execute();
    }
}