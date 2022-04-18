<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecuredAreaController extends AbstractController
{
    /**
     * @Route("/secured-area", name="app_securedArea")
     */
    public function securedArea(UserRepository $repository): Response
    {
        $users = $repository->findAll();

        $this->denyAccessUnlessGranted("IS_AUTHENTICATED_FULLY");
        return $this->render("securedArea/securedArea.html.twig", [
            "users" => $users
        ]);
    }
}
