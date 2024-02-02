<?php

namespace App\EventSubscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ContactSubscriber implements EventSubscriber
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function getSubscribedEvents()
    {
        return [
            Events::postPersist,
        ];
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

//     Vérifier si l'entité est un nouvel objet de type Contact;
//    Si l'objet persité n'est pas de type Contact, on ne veut pas que le Subscriber se déclenche!
        if ($entity instanceof \App\Entity\Contact) {

            $nom = $entity->getNomComplet();
            $email = $entity->getEmail();
            $sujet = $entity->getSujet();
            $demande = $entity->getMessage();

            //Si l'objet ou le text du message contiennent le mot "rgpd", le Subscriber enverra un email à l'adresse "admin@velvet.com"
            if (preg_match("/rgpd\b/i", $nom) || preg_match("/rgpd\b/i", $email) || preg_match("/rgpd\b/i", $sujet) || preg_match("/rgpd\b/i", $demande) ) {
                //     Envoyer un e-mail à l'admin
                $email = (new Email())
                    ->from('votre_adresse_email@example.com')
                    ->to('admin@district.com')
                    ->subject('Alerte RGPD')
                    ->text("Un nouveau message en rapport avec la loi sur les RGPD vous a été envoyé! L'id du message : " .$entity->getId(). " \n Nom et Prénom : " .$entity->getNomComplet(). " \n Address Email " .$entity->getEmail() . " \n Sujet : " .$entity->getSujet(). " \n Demande : " .$entity->getMessage());

                $this->mailer->send($email);
            }

        }
    }
}