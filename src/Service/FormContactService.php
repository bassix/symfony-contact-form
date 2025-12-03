<?php

namespace App\Service;

use App\Entity\FormContact;
use App\Entity\FormSubmissionMeta;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class FormContactService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private RequestStack $requestStack
    ) {
    }

    public function save(FormContact $formContact): void
    {
        // Add metadata about the submission
        $request = $this->requestStack->getCurrentRequest();
        
        if ($request) {
            // Store IP address (Note: getClientIp() can be influenced by proxy headers)
            // In production, validate or use getTrustedProxies() if behind a load balancer
            $ipMeta = new FormSubmissionMeta();
            $ipMeta->setMetaKey('ip_address');
            $ipMeta->setMetaValue($request->getClientIp() ?? 'unknown');
            $formContact->addMetadata($ipMeta);

            // Store user agent
            $uaMeta = new FormSubmissionMeta();
            $uaMeta->setMetaKey('user_agent');
            $uaMeta->setMetaValue($request->headers->get('User-Agent') ?? 'unknown');
            $formContact->addMetadata($uaMeta);

            // Store referer if available
            if ($request->headers->get('Referer')) {
                $refererMeta = new FormSubmissionMeta();
                $refererMeta->setMetaKey('referer');
                $refererMeta->setMetaValue($request->headers->get('Referer'));
                $formContact->addMetadata($refererMeta);
            }
        }

        $this->entityManager->persist($formContact);
        $this->entityManager->flush();
    }

    public function findById(int $id): ?FormContact
    {
        return $this->entityManager->getRepository(FormContact::class)->find($id);
    }

    public function findAll(): array
    {
        return $this->entityManager->getRepository(FormContact::class)->findAll();
    }
}
