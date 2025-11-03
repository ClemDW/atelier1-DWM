<?php

namespace charlymatloc\api\middlewares;

use charlymatloc\core\application\ports\api\dtos\ReservationDTO;
use charlymatloc\core\application\ports\api\dtos\ReservOutilDTO;
use charlymatloc\core\application\ports\api\serviceinterfaces\OutilsServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Ramsey\Uuid\Uuid;

class CreerReservationMiddleware implements MiddlewareInterface
{
    private OutilsServiceInterface $outilsService;

    public function __construct(OutilsServiceInterface $outils)
    {
        $this->outilsService = $outils;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $recup = $request->getParsedBody();
        $outils = $recup['outils'];
        $id_reservation = Uuid::uuid4();
        $outilsDtos = [];
        foreach ($outils as $outil) {
            if (!$this->outilsService->checkAssezOutils($outil['id_outil'], $outil['quantite'])) {
                $response = new \Slim\Psr7\Response();
                $response->getBody()->write(json_encode(['message' => 'Quantité d\'outil insuffisante pour l\'outil id : ' . $outil['id_outil']]));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
            }
            $outilsDisponibles = $this->outilsService->getOutilsDisponibles($outil['id_outil']);
            for ($i = 0; $i < $outil['quantite']; $i++) {
                $id_outil = $outilsDisponibles[$i]->getIdOutil();
                $outilsDtos[] = new ReservOutilDTO($id_reservation, $id_outil, $outil['date_debut'], $outil['date_fin']);
            }
        }
        $attributs = $request->getAttributes();
        if(!isset($attributs['user'])){
            $response = new \Slim\Psr7\Response();
            $response->getBody()->write('Utilisateur non authentifié');
            return $response->withStatus(401);
        }
        $user = $request->getAttribute('user');
        if($user == null){
            $response = new \Slim\Psr7\Response();
            $response->getBody()->write('Utilisateur non authentifié');
            return $response->withStatus(401);
        }
        $date_creation = date('Y-m-d H:i:s');
        $id_user = $user->id;
        $prix_total = $recup['prix_total'];
        $status = 'Validé';
        $reservationDTO = new ReservationDTO($id_reservation, $id_user, $date_creation, $status, $prix_total);
        $request = $request->withAttribute('reservationDTO', $reservationDTO);
        $request = $request->withAttribute('outils', $outilsDtos);
        return $handler->handle($request);
    }
}