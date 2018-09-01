<?php
/**
 * Created by PhpStorm.
 * User: lauti337r
 * Date: 16/08/18
 * Time: 18:03
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/adm", name="admin_index")
     */
    public function index()
    {
        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
        ]);
    }

}
