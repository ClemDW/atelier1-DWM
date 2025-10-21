<?php

namespace charlymatloc\api\actions;

use charlymatloc\core\application\ports\api\serviceinterfaces\OutilsServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class VerifierDisponibiliteAction
{
    private OutilsServiceInterface $outilsService;

    public function __construct(OutilsServiceInterface $outilsService)
    {
        $this->outilsService = $outilsService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $id_outil = (int) $args['id'];
        $queryParams = $request->getQueryParams();
        $date = $queryParams['date'] ?? null;

        if (!$date) {
            $response->getBody()->write(json_encode(['error' => 'Date parameter is required']));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        $disponible = $this->outilsService->isOutilDisponible($id_outil, $date);

        $response->getBody()->write(json_encode([
            'id_outil' => $id_outil,
            'date' => $date,
            'disponible' => $disponible
        ]));

        return $response->withHeader('Content-Type', 'application/json');
    }
}
