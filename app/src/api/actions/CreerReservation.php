<?php

namespace charlymatloc\api\actions;

use charlymatloc\core\application\ports\api\dtos\ReservOutilDTO;
use charlymatloc\core\application\ports\api\serviceinterfaces\OutilsServiceInterface;
use charlymatloc\core\application\ports\api\serviceinterfaces\ReservServiceInterface;
use Psr\Http\Message\ServerRequestInterface;

class CreerReservation{

    private ReservServiceInterface $reservService;
    private OutilsServiceInterface $outilsService;

    public function __construct(ReservServiceInterface $reservService, OutilsServiceInterface $outilsService){
        $this->reservService = $reservService;
        $this->outilsService = $outilsService;
    }

    public function __invoke(ServerRequestInterface $request, array $args){
        try{
            $outillagesPayload = $request->getAttribute('outils');
            foreach ( $outillagesPayload as $outillage){
                if($this->outilsService->checkAssezOutils($outillage['id_outillage'], $outillage['quantite'])){

                }
            }

        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
}