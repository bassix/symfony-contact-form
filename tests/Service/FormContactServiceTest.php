<?php

namespace App\Tests\Service;

use App\Entity\FormContact;
use App\Service\FormContactService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class FormContactServiceTest extends TestCase
{
    public function testSaveAddsMetadata(): void
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->once())
            ->method('persist');
        $entityManager->expects($this->once())
            ->method('flush');

        $request = Request::create('/contact', 'POST', [], [], [], [
            'REMOTE_ADDR' => '127.0.0.1',
            'HTTP_USER_AGENT' => 'TestBrowser/1.0',
        ]);

        $requestStack = new RequestStack();
        $requestStack->push($request);

        $service = new FormContactService($entityManager, $requestStack);

        $formContact = new FormContact();
        $formContact->setName('Test User');
        $formContact->setEmail('test@example.com');
        $formContact->setMessage('Test message');

        $service->save($formContact);

        // Verify metadata was added
        $this->assertGreaterThan(0, $formContact->getMetadata()->count());
    }

    public function testFindById(): void
    {
        $formContact = new FormContact();
        
        $repository = $this->createMock(\App\Repository\FormContactRepository::class);
        $repository->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn($formContact);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->once())
            ->method('getRepository')
            ->willReturn($repository);

        $requestStack = new RequestStack();
        $service = new FormContactService($entityManager, $requestStack);

        $result = $service->findById(1);
        $this->assertSame($formContact, $result);
    }
}
