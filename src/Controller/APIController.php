<?php

namespace App\Controller;

use App\Entity\PropositionPartagee;
use App\Mapper\PropositionMapper;
use App\Service\LoggerService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class APIController extends AbstractController
{
    public function __construct(
        private readonly PropositionMapper $propositionMapper,
        private readonly LoggerService $loggerService,
        private readonly EntityManagerInterface $entityManager,
    )
    {
    }

    #[Route('/api/proposition', name: 'api_proposition_add', methods: ['PUT'])]
    public function addProposition(Request $request): JsonResponse
    {
        $payload = $request->getContent();
        // @todo vérifier le payload
        $propositionPartagee = new PropositionPartagee();
        $propositionPartagee->setProposition($payload);
        try {
            $this->entityManager->persist($propositionPartagee);
            $this->entityManager->flush();
        } catch (Exception $e) {
            $this->loggerService->log($e->getMessage());
            return $this->json(['message' => 'Impossible d\'ajouter la proposition'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->json(['message' => 'Proposition ajoutée']);
    }
}
