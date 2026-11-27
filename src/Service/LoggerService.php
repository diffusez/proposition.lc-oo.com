<?php

namespace App\Service;

use App\Entity\Log;
use Doctrine\ORM\EntityManagerInterface;

class LoggerService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    )
    {
    }

    public function log(string $message): void
    {
        $log = new Log();
        $log->setMessage($message);
        $this->entityManager->persist($log);
        $this->entityManager->flush();
    }
}
