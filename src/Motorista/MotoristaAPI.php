<?php 

namespace CoopertalseAPI\Motorista;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Interfaces\RouteCollectorProxyInterface;

class MotoristaAPI {

    public function __invoke(RouteCollectorProxyInterface $oGroup) {
        $oGroup->post("/", [ self::class, "salvar" ]);
    
        $oGroup->group("/{_id}", function(RouteCollectorProxyInterface $oGroup) {
            $oGroup->get("", [ self::class, "consultarPorId" ]);
            $oGroup->post("/atualizar", [ self::class, "atualizar" ]);
        });
    }

    public static function salvar(Request $oRequest, Response $oResponse): Response {
        $oMotorista = Motorista::createFromRequest($oRequest);
        $oMotorista->cadastrar();
        return $oResponse;
    }

    public static function consultarPorId(Request $oRequest, Response $oResponse, array $args): Response {
        return $oResponse;
    }

    public static function atualizar(Request $oRequest, Response $oResponse, array $args): Response {
        return $oResponse;
    }
}
