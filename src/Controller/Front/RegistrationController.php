<?php

namespace App\Controller\Front;

use App\Entity\User;
use App\Form\RegistrationFormType;
// use App\Security\LoginAuthenticator;
use App\Service\Mailer\Mailing;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
// use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;
use App\Repository\UserRepository;



class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, VerifyEmailHelperInterface $verifyEmailHelper): Response
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

            //*refuse access unfless email confirmed.

            // return $userAuthenticator->authenticateUser(
            //     $user,
            //     $authenticator,
            //     $request
            // );

            $signatureComponents = $verifyEmailHelper->generateSignature(
                'front_app_verify_email',
                $user->getId(),
                $user->getEmail(),
                ['id' => $user->getId()]
            );

            $signedUrl = $signatureComponents->getSignedUrl();

            //*send confirmation email
            Mailing::sendEmail($user, $signedUrl);

            return $this->redirectToRoute('front_home_index');
        }

        return $this->render('front/registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/verify", name="app_verify_email")
     */
    #[Route('/verify', name: 'app_verify_email')]
    public function verifyUserEmail(EntityManagerInterface $entityManager, Request $request, VerifyEmailHelperInterface $verifyEmailHelper, UserRepository $userRepository)
    {

        $user = $userRepository->find($request->query->get('id'));
        if (!$user) {
            throw $this->createNotFoundException();
        }


        try {
            $verifyEmailHelper->validateEmailConfirmation(
                $request->getUri(),
                $user->getId(),
                $user->getEmail(),
            );
        } catch (Exception $e) {
            $this->addFlash('error', "validation échouée");
            return $this->redirectToRoute('front_app_register');
        }

        $user->setIsEmailVerified(true);
        $entityManager->flush();
        $this->addFlash('success', 'Votre compte a été validé. Vous pouvez à présent vous connecter.');
        return $this->redirectToRoute('front_app_login');
    }
}
