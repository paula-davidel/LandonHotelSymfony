<?php
// src/Controller/AdminController.php
namespace App\Controller;

use phpDocumentor\Reflection\DocBlock\Tags\Reference\Reference;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    
    /**
     * @Route("/admins", name="home")
     */
    public function showIndex()
    {
        //using the global variable, SERVER
//        $routeName= $_SERVER["BASE"];
//        return $this->render("admin/index.html.twig",
//            [
//                "base_url" => $routeName
//            ]);
        //USING THE PATH FUNCTION

         return $this->render("admin/index.html.twig");

    }
}