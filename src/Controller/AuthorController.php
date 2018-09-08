<?php
/**
 * Created by PhpStorm.
 * User: lauti337r
 * Date: 16/08/18
 * Time: 18:03
 */

namespace App\Controller;


use App\Entity\Author;
use App\Entity\Book;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Genre;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\VarDumper\VarDumper;

class AuthorController extends AbstractController
{
    /**
     * @Route("/author/{authorId}", name="author_show")
     */
    public function showAuthor($authorId)
    {
        $em = $this->getDoctrine()->getManager();

        $author = $em->getRepository('App:Author')->find($authorId);


        return $this->render('author/show.html.twig', [
            'author' => $author
        ]);
    }



}
