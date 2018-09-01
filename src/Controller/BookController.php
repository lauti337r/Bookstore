<?php
/**
 * Created by PhpStorm.
 * User: lauti337r
 * Date: 01/09/18
 * Time: 05:57
 */

namespace App\Controller;


use App\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{

    /**
     * @Route("/addBook",name="add_book")
     */
    public function addBook(){
        $em = $this->getDoctrine()->getManager();
        $newBook = new Book();

    }

}