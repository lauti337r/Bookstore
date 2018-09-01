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

    /**
     *@Route("/adm/author",name="author")
     */
    public function author(Request $request){
        $em = $this->getDoctrine()->getManager();

        $authors = $em->getRepository('App:Author')->findAll();

        $newAuthor = new Author();

        $addform = $this->createFormBuilder($newAuthor)
            ->add('name',TextType::class)
            ->add('comment',TextareaType::class)
            ->add('save',SubmitType::class,['label' => 'Save author'])
            ->getForm();

        $addform->handleRequest($request);

        if($addform->isSubmitted() && $addform->isValid()){
            $existingAuthor = $em->getRepository('App:Author')->findOneBy(['name' => $newAuthor->getName()]);

            if(!$existingAuthor) {
                $newAuthor->setRating(0);
                $newAuthor->setVotes(0);
                $em->persist($newAuthor);
                $em->flush();
            }

            return $this->render('admin/author.html.twig',[
                'addform' => $addform->createView(),
                'authors' => $em->getRepository('App:Author')->findAll()
            ]);
        }else return $this->render('admin/author.html.twig',[
            'addform' => $addform->createView(),
            'authors' => $authors]);
    }


    /**
     * @Route("/adm/genre",name="genre")
     */
    public function genre(Request $request){
        $em = $this->getDoctrine()->getManager();

        $newGenre = new Genre();

        $genres = $em->getRepository('App:Genre')->findAll();

        $form = $this->createFormBuilder($newGenre)
            ->add('name',TextType::class)
            ->add('description',TextareaType::class)
            ->add('save',SubmitType::class,array('label' => 'Save Genre'))
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $existingGenre = $em->getRepository('App:Genre')->findOneBy(array('name' => $newGenre->getName()));

            if (!$existingGenre) {
                $em->persist($newGenre);
                $em->flush();
            }

            return $this->render('admin/genre.html.twig',[
                'addform' => $form->createView(),
                'message' => 'Genre added successfully.',
                'genres' => $em->getRepository('App:Genre')->findAll()
            ]);
        }else return $this->render('admin/genre.html.twig', [
            'addform' => $form->createView(),
            'genres' => $genres]);
    }

    /**
     * @Route("/adm/book",name="book")
     */
    public function book(Request $request){
        $em = $this->getDoctrine()->getManager();

        $books = $em->getRepository('App:Book')->findAll();
        $newBook = new Book();

        $form = $this->createFormBuilder($newBook)
            ->add('title',TextType::class)
            ->add('description',TextareaType::class)
            ->add('genres',EntityType::class,[
                                'class' => Genre::class,
                                'choices' => $em->getRepository('App:Genre')->findAll(),
                                'choice_value' => function (Genre $entity = null) {
                                    return $entity ? $entity->getId() : '';
                                },
                                'multiple' => true])
            ->add('author',EntityType::class,[
                                'class' => Author::class,
                                'choices' => $em->getRepository('App:Author')->findAll(),
                                'multiple' => false,
                                'expanded' => false])
            ->add('price',NumberType::class)
            ->add('save',SubmitType::class,['label' => 'Save Book'])
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $existingBook = $em->getRepository('App:Book')->findOneBy([
                'title' => $newBook->getTitle(),
                'author' => $newBook->getAuthor()
            ]);
            if(!$existingBook){
                $newBook->setVotes(0);
                $newBook->setRating(0);
                VarDumper::dump($newBook);
                $em->persist($newBook);
                $em->flush();

                return $this->render('admin/book.html.twig',[
                    'success' => true,
                    'message' => 'Book added successfully!',
                    'addform' => $form->createView(),
                    'books' => $em->getRepository('App:Book')->findAll()]);
            }else return $this->render('admin/book.html.twig',[
                'success' => false,
                'message' => 'Book already existed!',
                'addform' => $form->createView(),
                'books' => $books]);

        }

        return $this->render('admin/book.html.twig',[
            'addform' => $form->createView(),
            'books' => $books]);
    }


}
