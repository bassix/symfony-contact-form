<?php

namespace App\Service;

use App\Entity\FormContact;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailManService
{
    public function __construct(
        private MailerInterface $mailer,
        private string $fromEmail = 'noreply@example.com',
        private string $toEmail = 'admin@example.com'
    ) {
    }

    public function sendContactEmail(FormContact $formContact): void
    {
        $email = (new Email())
            ->from($this->fromEmail)
            ->to($this->toEmail)
            ->replyTo($formContact->getEmail())
            ->subject('New Contact Form Submission: ' . ($formContact->getSubject() ?? 'No Subject'))
            ->html($this->buildEmailContent($formContact))
            ->text($this->buildTextEmailContent($formContact));

        $this->mailer->send($email);
    }

    private function buildEmailContent(FormContact $formContact): string
    {
        return sprintf(
            '<html><body style="font-family: Arial, sans-serif;">
                <h2>New Contact Form Submission</h2>
                <table style="border-collapse: collapse; width: 100%%;">
                    <tr>
                        <td style="padding: 8px; border: 1px solid #ddd; font-weight: bold; width: 150px;">Name:</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">%s</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px; border: 1px solid #ddd; font-weight: bold;">Email:</td>
                        <td style="padding: 8px; border: 1px solid #ddd;"><a href="mailto:%s">%s</a></td>
                    </tr>
                    <tr>
                        <td style="padding: 8px; border: 1px solid #ddd; font-weight: bold;">Subject:</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">%s</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px; border: 1px solid #ddd; font-weight: bold;">Submitted At:</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">%s</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px; border: 1px solid #ddd; font-weight: bold; vertical-align: top;">Message:</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">%s</td>
                    </tr>
                </table>
            </body></html>',
            htmlspecialchars($formContact->getName()),
            htmlspecialchars($formContact->getEmail()),
            htmlspecialchars($formContact->getEmail()),
            htmlspecialchars($formContact->getSubject() ?? 'N/A'),
            $formContact->getSubmittedAt()->format('Y-m-d H:i:s'),
            nl2br(htmlspecialchars($formContact->getMessage()))
        );
    }

    private function buildTextEmailContent(FormContact $formContact): string
    {
        return sprintf(
            "New Contact Form Submission\n\n" .
            "Name: %s\n" .
            "Email: %s\n" .
            "Subject: %s\n" .
            "Submitted At: %s\n\n" .
            "Message:\n%s",
            $formContact->getName(),
            $formContact->getEmail(),
            $formContact->getSubject() ?? 'N/A',
            $formContact->getSubmittedAt()->format('Y-m-d H:i:s'),
            $formContact->getMessage()
        );
    }
}
