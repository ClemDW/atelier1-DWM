<?php

namespace charlymatloc\api\actions;

use charlymatloc\core\application\ports\api\serviceinterfaces\OutilsServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AjouterAuPanierAction
{
    private OutilsServiceInterface $outilsService;

    public function __construct(OutilsServiceInterface $outilsService)
    {
        $this->outilsService = $outilsService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $data = $request->getParsedBody();
        $id_outil = (int) $args['id'];
        $date = $data['date'] ?? null;

        if (!$date) {
            $response->getBody()->write(json_encode(['error' => 'Date is required']));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        if ($this->outilsService->isOutilDisponible($id_outil, $date)) {
            // Return outil details for frontend panier
            $outil = $this->outilsService->AfficherOutillage($id_outil);
            $response->getBody()->write(json_encode([
                'success' => true,
                'outil' => [
                    'id' => $id_outil,
                    'nom' => $outil->nom,
                    'prix' => $outil->prix,
                    'date' => $date
                ]
            ]));
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } else {
            $response->getBody()->write(json_encode(['error' => 'Outil non disponible']));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }
    }
}
