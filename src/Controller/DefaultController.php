<?php


namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends AbstractController
{
     /**
     * @Route("/", name="home")
     */
    public function showIndex()
    {
//        $routeName= $_SERVER["BASE"];
//        return $this->render("admin/index.html.twig",
//            [
//                "base_url" => $routeName
//            ]);

        return $this->render("admin/index.html.twig");

    }
}