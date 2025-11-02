<?php

namespace charlymatloc\api\actions;

use charlymatloc\core\application\ports\api\dtos\ReservOutilDTO;
use charlymatloc\core\application\ports\api\serviceinterfaces\OutilsServiceInterface;
use charlymatloc\core\application\ports\api\serviceinterfaces\ReservServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CreerReservation{

    private ReservServiceInterface $reservService;
    private OutilsServiceInterface $outilsService;

    public function __construct(ReservServiceInterface $reservService, OutilsServiceInterface $outilsService){
        $this->reservService = $reservService;
        $this->outilsService = $outilsService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response,array $args){
        try{
            $reservationDTO = $request->getAttribute('reservationDTO');
            $outilsPayload = $request->getAttribute('outils');
            $this->reservService->registerReservation($reservationDTO);
            $this->reservService->registerReservOutil($outilsPayload);
            $payload = ['success' => true, 'message' => 'Compte cree'];
            $response->getBody()->write(json_encode($payload, JSON_PRETTY_PRINT));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(201);
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
}