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
            $message = new Contact();
        
                    // Traitement des données du formulaire
            $message->setNom($form->get('nom')->getData());
            $message->setPrenom($form->get('prenom')->getData());
            $message->setEmail($form->get('email')->getData());
            $message->setDemande($form->get('demande')->getData());
        
            // Persistance des données
            $entityManager->persist($message);
            $entityManager->flush();

            // Envoi de mail avec notre service MailService
            $email = $ms->sendMail('District@purple.com', $message->getEmail() , $message->getNom(), $message->getPrenom(), $message->getEmail(), $message->getDemande());

            return $this->redirect("/district");
        }
        return $this->render('/contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}