<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AddingFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class SecuredAreaController extends AbstractController
{


    /**
     * @Route("/secured-area", name="app_securedArea")
     */
    public function securedArea(UserRepository $repository): Response
    {
        $users = $repository->findAll();
        if (!isset($_GET['message']))
        {
            $_GET['message'] = false;
        }
        elseif ($_GET['message'] !== 'Added' && $_GET['message'] !== 'Edited')
        {
            $_GET['message'] = false;
        }
        $this->denyAccessUnlessGranted("IS_AUTHENTICATED_FULLY");
        return $this->render("securedArea/securedArea.html.twig", [
            "users" => $users,
            "message" => $_GET['message']
        ]);
    }

    /**
     * * @Route("/secured-area/add", name="app_securedAreaAdd")
     */
    public function addUser(
        Request $request,
        UserPasswordHasherInterface $hasher,
        EntityManagerInterface $entityManager,
        ): Response
    {
        $this->denyAccessUnlessGranted("IS_AUTHENTICATED_FULLY");
        $user = new User();
        $form = $this->createForm(AddingFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $user->setPassword(
                $hasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_securedArea', [
                "message" => "Added"
            ]);

        }


        return $this->render('adding/add.html.twig',[
            'addForm' => $form->createView()
        ]);
    }
}
