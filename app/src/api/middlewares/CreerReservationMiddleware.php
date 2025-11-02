<?php

namespace charlymatloc\api\middlewares;

use charlymatloc\core\application\ports\api\dtos\ReservationDTO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Ramsey\Uuid\Uuid;

class CreerReservationMiddleware implements MiddlewareInterface
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $recup = $request->getParsedBody();
        $credentials = $request->getAttribute('credentials');
        $date_creation = $recup['date_creation'];
        $id_user = $credentials['id_user'];
        $prix_total = 0;
        $outils = [];
        foreach ($recup['items'] as $key => $value) {
            $prix_total += $key['sous_total'];
            $outils[] = [
                'id_outillage' => $key['id'],
                'date_debut' => $key['date_debut'],
                'date_fin' => $key['date_fin'],
                'quantite' => $key['quantite'],
            ];
        }
        $status = 'validé';
        $id_reservation = Uuid::uuid4();
        $reservationDTO = new ReservationDTO($id_reservation, $id_user, $date_creation, $status, $prix_total);
        $request = $request->withAttribute('reservationDTO', $reservationDTO);
        $request = $request->withAttribute('outils', $outils);
        return $handler->handle($request);
    }
}