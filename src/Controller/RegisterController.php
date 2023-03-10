<?php

namespace App\Controller;

use App\classe\Mail;
use App\Entity\Utilisateur;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }


    #[Route('/inscription', name: 'app_register')]
    public function index(Request $request, UserPasswordHasherInterface $hasher): Response
    {
        $user = new Utilisateur();
        $form = $this->createForm(RegisterType::class, $user);
        $notification = null;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();
            $search_email = $this->entityManager->getRepository(Utilisateur::class)->findOneBy(['email' => $user->getEmail()]);

            if (!$search_email) {
                /*
                * la methode hashPassword permet d'encoder les mots de passe et donc de ne pas les stocker en clair
                 * dans notre base de donnée (Pour plus de sécurité)
                */

                $password = $hasher->hashPassword($user, $user->getPassword());
                $user->setPassword($password);

                /*
                 * dd() permet de debuger une variable pour voir ce qui s'y passe
                 * ici on observe l'encodage du mot de passe
                 */

                // met à jour la BD via doctrine
                $this->entityManager->persist($user);
                $this->entityManager->flush();


                // Crée un nouvel objet Mail
                $mail = new Mail();

                // Crée le contenu du message de bienvenue
                $content = "Bonjour " . $user->getFirstname() . " Bienvenue chez nous, choisissez le bien qui correspond à vos attentes";

                // Envoie un email de bienvenue à l'utilisateur en utilisant l'objet Mail
                $mail->send($user->getEmail(), $user->getFirstname(), 'Bienvenue sur le site de la SAFER', $content);

                // Affiche un message de confirmation à l'utilisateur
                $notification = "Votre inscription a été prise en compte avec succès !";

                // Si l'email existe déjà en base de données, affiche un message d'erreur à l'utilisateur
            } else {
                $notification = "L'email existe déjà, veuillez en choisir un autre !";
            }
        }
            // Affiche la vue Twig register/index.html.twig en lui passant en argument le formulaire d'inscription et le message de notification
            return $this->render('register/index.html.twig', [
                'form' => $form->createView(),
                'notification' => $notification
            ]);
        }
}
