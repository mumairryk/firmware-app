<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PublicController extends AbstractController
{
    #[Route('/', name: 'software_checker')]
    public function index(): Response
    {
        $msg = "";
        return $this->render('public/software_checker.html.twig', [
            'msg' => $msg
        ]);
    }
}
