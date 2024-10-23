<?php

namespace App\Controller;

use App\Entity\Message;
use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route("/contact", name: "contact", methods: ["GET"])]
    function contact()
    {
        return $this->render('contact.html.twig');
    }

    #[Route("/traitement", name: "contact.traitement", methods: ["POST"])]
    function sendMessage(Request $req, MessageRepository $repo)
    {

        // Récuperer les données depuis le corps de requête
        $email = $req->request->get('email');
        $fullName = $req->request->get('fullName');
        $message = $req->request->get('message');

        // Valider les donnée, sinon retourner 400
        if (!isset($email) || !isset($fullName) || !isset($message) || $email == "" || $fullName == "" || $message == "") {
            return $this->render(
                'contact.html.twig',
                ['success' => false, 'message' => "Données obligatoires!"]
            );
        }
        // Utiliser Entity pour créer un nouveau Message
        $nouveauMessage = new Message();
        $nouveauMessage->setEmail($email);
        $nouveauMessage->setFullName($fullName);
        $nouveauMessage->setMessage($message);

        // Utiliser Repository pour enregistrer le message
        $repo->sauvegarder($nouveauMessage, true);
        // Retourner le contact
        return $this->render(
            'contact.html.twig',
            ['success' => true, 'message' => "Message envoyé"]
        );
    }
}
