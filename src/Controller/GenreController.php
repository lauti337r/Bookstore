<?php
/**
 * Created by PhpStorm.
 * User: lauti337r
 * Date: 01/09/18
 * Time: 06:06
 */

namespace App\Controller;


use App\Entity\Genre;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\VarDumper\VarDumper;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

class GenreController extends AbstractController
{

    /**
     * @Route("/genres", name="get_genres")
     */
    public function getGenres(){
        $em = $this->getDoctrine()->getManager();

        $genres = $em->getRepository('App:Genre')->findAll();

        return $genres;
    }


}