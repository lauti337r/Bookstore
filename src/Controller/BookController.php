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
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\VarDumper\VarDumper;

class BookController extends AbstractController
{

    /**
     * @Route("/addBook",name="add_book")
     */
    public function addBook(){
        $em = $this->getDoctrine()->getManager();
        $newBook = new Book();

    }

    /**
     * @Route("/books/{genreId}",name="list_books",methods={"GET"}))
     */
    public function listBooks(Request $request, $genreId=0){
        $em = $this->getDoctrine()->getManager();
        //$genreId = $request->request->get('genreId');
        //VarDumper::dump($genreId);
        $genre = false;
        if($genreId == 0)
            $books = $em->getRepository("App:Book")->findAll();
        else {
            $genre = $em->getRepository("App:Genre")->find($genreId);
            $books = $genre->getBooks();
        }
        VarDumper::dump($books);

        //VarDumper::dump($books);

         return $this->render('books/list.html.twig',[
            'genre' => $genre,
            'books' => $books
        ]);

    }

    /**
     * @Route("/getBook",name="get_book",methods={"POST"}))
     */
    public function getBook(Request $request){
        $em = $this->getDoctrine()->getManager();

        $bookId = $request->request->get('bookId');
        VarDumper::dump($bookId);

        $book = $em->getRepository('App:Book')->find($bookId);
        $author = $book->getAuthor();
        $response = [
            'bookId' => $book->getId(),
            'title' => $book->getTitle(),
            'author' => $author->getName(),
            'price' => $book->getPrice()
        ];
        return new JsonResponse($response);
    }

    /**
     * @Route("/book/{id}",name="bookview")
     */
    public function viewBook($id){
        $em = $this->getDoctrine()->getManager();

        $book = $em->getRepository('App:Book')->find($id);
        VarDumper::dump($book);
        return $this->render('books/show.html.twig',['book' => $book]);
    }
}