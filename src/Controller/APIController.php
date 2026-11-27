<?php

namespace App\Controller;

use App\Entity\PropositionPartagee;
use App\Mapper\PropositionMapper;
use App\Service\LoggerService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use InvalidArgumentException;
use JsonException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use TypeError;

final class APIController extends AbstractController
{
    public function __construct(
        private readonly PropositionMapper $propositionMapper,
        private readonly LoggerService $loggerService,
        private readonly EntityManagerInterface $entityManager,
        private readonly ValidatorInterface $validator,
    )
    {
    }

    #[Route('/api/proposition', name: 'api_proposition_add', methods: ['PUT'])]
    public function addProposition(Request $request): JsonResponse
    {
        $payload = $request->getContent();

        try {
            $proposition = $this->propositionMapper->fromJSON($payload);
        } catch (Exception $e) {
            $this->loggerService->log($e->getMessage());
            return $this->json(['message' => 'Mauvaise requête'], Response::HTTP_BAD_REQUEST);
        }

        $violations = $this->validator->validate($proposition);
        if (count($violations) > 0) {
            $errors = [];
            foreach ($violations as $violation) {
                $errors[] = [
                    'champ' => $violation->getPropertyPath(),
                    'message' => $violation->getMessage(),
                ];
            }
            return $this->json(['message' => 'La proposition est invalide', 'errors' => $errors], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

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
