<?php

namespace App\Controller;

use App\Entity\FormContact;
use App\Form\FormContactType;
use App\Service\FormContactService;
use App\Service\MailManService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    public function __construct(
        private FormContactService $formContactService,
        private MailManService $mailManService
    ) {
    }

    #[Route('/', name: 'app_contact', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $formContact = new FormContact();
        $form = $this->createForm(FormContactType::class, $formContact);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                // Save to database
                $this->formContactService->save($formContact);

                // Send email notification
                $this->mailManService->sendContactEmail($formContact);

                // Add success flash message
                $this->addFlash('success', 'Thank you for contacting us! Your message has been sent successfully.');

                // Redirect to success page with the submission ID
                return $this->redirectToRoute('app_contact_success', ['id' => $formContact->getId()]);
            } catch (\Exception $e) {
                // Add error flash message
                $this->addFlash('error', 'An error occurred while submitting your message. Please try again later.');
            }
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/contact/success/{id}', name: 'app_contact_success', methods: ['GET'])]
    public function success(int $id): Response
    {
        $formContact = $this->formContactService->findById($id);

        if (!$formContact) {
            throw $this->createNotFoundException('Submission not found');
        }

        return $this->render('contact/success.html.twig', [
            'submission' => $formContact,
        ]);
    }
}
