<?php

namespace App\Controller\Front;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\LoginAuthenticator;
use App\Service\Mailer\Mailing;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, LoginAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            //*assigner le rôle qu'on veut

            //*persist and flush
            $entityManager->persist($user);
            $entityManager->flush();

            //*send confirmation email
            Mailing::sendEmail($user);

            //*refuse access unfless email confirmed.

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('front/registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}



    // //*Update la compagne 
            // $campaignId = 1;
            // $emailCampaign = new \SendinBlue\Client\Model\UpdateEmailCampaign();
            // $emailCampaign['templateId'] = "5ea1551d2e9ad34b8640be9f";
            // // $emailCampaign['toField'] = '{{contact.FIRSTNAME}} {{contact.LASTNAME}}';
            // $emailCampaign['recipients'] =  array(
            //     'listIds' => array($user->getId())
            // );

            // $emailCampaign['recipients'] =  array(
            //     'listIds' => array(19, 20), 'exclusionListIds' => array(2)
            // );

            // $apiInstance->updateEmailCampaign($campaignId, $emailCampaign);








            // //*envoyer un email de confirmation 
            // $email = (new TemplatedEmail())
            //     ->from(new Address('challengestack@gmail.com', 'noreply'))
            //     ->to(new Address($user->getEmail(), $user->getName()))
            //     ->subject('Confirmation de votre adresse mail')
            //     // ->addTextHeader('templateId', 1)
            //     ->htmlTemplate('emails/confirme_email.html.twig')
            //     ->context([
            //         'user' => $user
            //     ]);
            // $mailer->send($email);
