<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AddingFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use http\Exception\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


class EditorController extends AbstractController
{
    /**
     * @Route ("/secured-area/edit/{id}", name="app_securedAreaEdit")
     */
    public function editUser(
        int $id,
        Request $request,
        UserRepository $repository,
        UserPasswordHasherInterface $hasher,
        EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted("IS_AUTHENTICATED_FULLY");
        $user = new User();
        $form = $this->createForm(AddingFormType::class, $user);
        $form->handleRequest($request);

        $user = $repository->find($id);

        if(!$user)
        {
            throw $this->createNotFoundException("No user with this id=".$id);
        }

        if ($form->isSubmitted() && $form->isValid())
        {
            $user = $this->dataFromForm($form, $user, $hasher);
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_securedArea', [
                "message" => "Edited"
            ]);
        }

        return $this->render('editing/edit.html.twig',[
            'editForm' => $form->createView(),
            'user' => $user
        ]);
    }

    private function dataFromForm(Form $form, User $user, UserPasswordHasherInterface $hasher ): User
    {
        $email = $form->get('email')->getData();
        $username = $form->get('username')->getData();
        $password = $form->get('password')->getData();

        if($email){
            $user->setEmail($email);
        }
        if($username && $username !== $user->getUsername())
        {
            $user->setUsername($username);
        }
        if($password)
        {
            $user->setPassword($hasher->hashPassword($user,$password));
        }
        return $user;
    }

}
