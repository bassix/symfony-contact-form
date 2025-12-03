<?php

namespace App\Tests\Service;

use App\Entity\FormContact;
use App\Service\MailManService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailManServiceTest extends TestCase
{
    public function testSendContactEmail(): void
    {
        $mailer = $this->createMock(MailerInterface::class);
        
        $mailer->expects($this->once())
            ->method('send')
            ->with($this->callback(function (Email $email) {
                return $email->getFrom()[0]->getAddress() === 'noreply@example.com'
                    && $email->getTo()[0]->getAddress() === 'admin@example.com';
            }));

        $service = new MailManService($mailer, 'noreply@example.com', 'admin@example.com');

        $formContact = new FormContact();
        $formContact->setName('John Doe');
        $formContact->setEmail('john@example.com');
        $formContact->setSubject('Test Subject');
        $formContact->setMessage('This is a test message');

        $service->sendContactEmail($formContact);
    }

    public function testSendContactEmailWithoutSubject(): void
    {
        $mailer = $this->createMock(MailerInterface::class);
        
        $mailer->expects($this->once())
            ->method('send')
            ->with($this->callback(function (Email $email) {
                return str_contains($email->getSubject(), 'No Subject');
            }));

        $service = new MailManService($mailer, 'noreply@example.com', 'admin@example.com');

        $formContact = new FormContact();
        $formContact->setName('Jane Doe');
        $formContact->setEmail('jane@example.com');
        $formContact->setMessage('Message without subject');

        $service->sendContactEmail($formContact);
    }
}
