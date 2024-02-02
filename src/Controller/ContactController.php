<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use App\Service\MailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer, MailService $ms): Response
    {
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = new Contact();

            // Traitement des données du formulaire
            $contact->setNomComplet($form->get('nomComplet')->getData());
            $contact->setEmail($form->get('email')->getData());
            $contact->setSujet($form->get('sujet')->getData());
            $contact->setMessage($form->get('message')->getData());

            // Persistance des données
            $entityManager->persist($contact);
            $entityManager->flush();

            $expirationDate = new \DateTime();
            $emailContext = [
                'email' => [
                    'toName' => 'Your To Name',
                    'to' => [['address' => 'recipient@example.com']]
                ],
                'contact' => $contact,
                'expiration_date' => $expirationDate,
            ];
            
            $email = $ms->sendEmail('District@purple.com', $contact->getSujet(), '/emails/contact_email.html.twig', $emailContext, $contact->getEmail());
            
            return $this->redirect("/district");
        }

        return $this->render('/contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

