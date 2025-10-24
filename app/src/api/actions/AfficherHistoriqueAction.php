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
        $historique = [];
        foreach ($reservations as $reserv) {
            $id = method_exists($reserv, 'getId') ? (string)$reserv->getId() : ((string)($reserv->id ?? ''));
            $user_id = method_exists($reserv, 'getUserId') ? (string)$reserv->getUserId() : ((string)($reserv->user_id ?? ''));
            $outils = method_exists($reserv, 'getOutils') ? $reserv->getOutils() : ($reserv->outils ?? []);
            $date_creation = method_exists($reserv, 'getDateCreation') ? (string)$reserv->getDateCreation() : ((string)($reserv->date_creation ?? ''));
            $statut = method_exists($reserv, 'getStatut') ? (string)$reserv->getStatut() : ((string)($reserv->statut ?? ''));
            $prix_total = method_exists($reserv, 'getPrixTotal') ? (float)$reserv->getPrixTotal() : ((float)($reserv->prix_total ?? 0.0));

            $historique[] = new HistoriqueDTO(
                $id,
                $user_id,
                $outils,
                $date_creation,
                $statut,
                $prix_total
            );
        }

        $historiqueArray = array_map(function (HistoriqueDTO $dto) {
            return get_object_vars($dto);
        }, $historique);

        $response->getBody()->write(json_encode($historiqueArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}