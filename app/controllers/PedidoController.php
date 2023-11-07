<?php
require_once './models/Pedido.php';
require_once './interfaces/IApiUsable.php';

class PedidoController extends Pedido implements IApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $codigo = $parametros['codigo'];
        $estado = $parametros['estado'];
        $nombreCliente = $parametros['nombreCliente'];
        $importe = $parametros['importe'];
        $idMesa = $parametros['idMesa'];
        $idUsuario = $parametros['idUsuario'];
        $pathFoto = $parametros['pathFoto'];
        $fechaAlta = $parametros['fechaAlta'];

        $ped = new Pedido();
        $ped->codigo = $codigo;
        $ped->estado = $estado;
        $ped->nombreCliente = $nombreCliente;
        $ped->importe = $importe;
        $ped->idMesa = $idMesa;
        $ped->idUsuario = $idUsuario;
        $ped->pathFoto = $pathFoto;
        $ped->fechaAlta = $fechaAlta;
        $ped->crearProducto();

        $payload = json_encode(array("mensaje" => "Pedido creado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args)
    {
        $idPedido = $args['id'];
        $pedido = Pedido::obtenerProducto($idPedido);
        $payload = json_encode($pedido);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = Pedido::obtenerTodos();
        $payload = json_encode(array("listaPedidos" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
    
    public function ModificarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $id = $parametros['id'];
        $estado = $parametros['estado'];
        $nombreCliente = $parametros['nombreCliente'];
        $importe = $parametros['importe'];
        $idMesa = $parametros['idMesa'];
        $idUsuario = $parametros['idUsuario'];
        $pathFoto = $parametros['pathFoto'];

        Pedido::modificarPedido($id,$estado,$nombreCliente,$importe,$idMesa,$idUsuario,$pathFoto);

        $payload = json_encode(array("mensaje" => "Pedido modificado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $pedidoId = $parametros['id'];
        Pedido::borrarPedido($pedidoId);

        $payload = json_encode(array("mensaje" => "Pedido borrado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
}
