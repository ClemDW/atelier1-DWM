<?php

namespace charlymatloc\api\actions;

use charlymatloc\core\application\ports\api\serviceinterfaces\ReservServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

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
        $historique = [];
        foreach ($reservations as $reserv) {
            $historique[] = [
                'id' => method_exists($reserv, 'getId') ? $reserv->getId() : ($reserv->id ?? null),
                'user_id' => method_exists($reserv, 'getUserId') ? $reserv->getUserId() : ($reserv->user_id ?? null),
                'outils' => method_exists($reserv, 'getOutils') ? $reserv->getOutils() : ($reserv->outils ?? []),
                'date_debut' => method_exists($reserv, 'getDateDebut') ? $reserv->getDateDebut() : ($reserv->date_debut ?? null),
                'date_fin' => method_exists($reserv, 'getDateFin') ? $reserv->getDateFin() : ($reserv->date_fin ?? null),
                'date_creation' => method_exists($reserv, 'getDateCreation') ? $reserv->getDateCreation() : ($reserv->date_creation ?? null),
                'statut' => method_exists($reserv, 'getStatut') ? $reserv->getStatut() : ($reserv->statut ?? null),
                'prix_total' => method_exists($reserv, 'getPrixTotal') ? $reserv->getPrixTotal() : ($reserv->prix_total ?? null),
            ];
        }

        $response->getBody()->write(json_encode($historique, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
