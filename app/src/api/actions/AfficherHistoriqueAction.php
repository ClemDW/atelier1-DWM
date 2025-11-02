<?php

namespace charlymatloc\api\actions;

use charlymatloc\core\application\ports\api\serviceinterfaces\ReservServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use charlymatloc\core\application\ports\api\dtos\HistoriqueDTO;

class AfficherHistoriqueAction
{
    private ReservServiceInterface $reservService;

    public function __construct(ReservServiceInterface $reservService)
    {
        $this->reservService = $reservService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $user = $request->getAttribute('user');
        if ($user === null) {
            $response->getBody()->write(json_encode(['error' => 'Utilisateur non authentifié']));
            return $response->withStatus(401)->withHeader('Content-Type', 'application/json');
        }

        $userId = $user->id ?? ($user->getId() ?? null);
        if ($userId === null) {
            $response->getBody()->write(json_encode(['error' => 'Identifiant utilisateur introuvable']));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        $reservations = $this->reservService->getUserReservations($userId, 'Terminé');

        $historique = array_map(function ($reservation) {
            return new HistoriqueDTO(
                $reservation->getId(),
                $reservation->getUserId(),
                $reservation->getReservOutils(),
                $reservation->getDateCreation(),
                $reservation->getStatut(),
                $reservation->getPrixTotal()
            );
        }, $reservations);

        $historiqueArray = [];
        foreach ($historique as $dto) {
            $historiqueArray[] = get_object_vars($dto);
        }


        $response->getBody()->write(json_encode($historiqueArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}