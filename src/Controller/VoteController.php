<?php
/**
 * Created by PhpStorm.
 * User: lauti337r
 * Date: 11/09/18
 * Time: 14:27
 */

namespace App\Controller;


use App\Entity\Voteauthor;
use App\Entity\Votebook;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\VarDumper\VarDumper;
use Symfony\Component\Routing\Annotation\Route;

class VoteController extends AbstractController
{

    /**
     * @Route("/addAuthorVote",name="add_author_vote")
     */
    public function addAuthorVote(Request $request){
        $em = $this->getDoctrine()->getManager();
        $authorId = $request->request->get('authorId');
        $userId = $request->request->get('userId'); //We could also get it from $this->getUser()
        $vote = $request->request->get('vote');
        VarDumper::dump($authorId);
        VarDumper::dump($userId);
        VarDumper::dump($vote);
        $author = $em->getRepository('App:Author')->find($authorId);
        $user = $em->getRepository('App:User')->find($userId);

        $voteAuthor = $em->getRepository('App:VoteAuthor')->findOneBy(['author' => $author,'user' => $user]);
        if(!$voteAuthor){
            $voteAuthor = new Voteauthor();
            $voteAuthor->setUser($user);
            $voteAuthor->setAuthor($author);
            $author->addUservote($voteAuthor);
        }
        $voteAuthor->setVote($vote);
        $em->persist($voteAuthor);
        $em->flush();

        return $this->redirectToRoute('author_show',['authorId'=> $authorId]);


    }

    /**
     * @Route("/addBookVote",name="add_book_vote")
     */

    public function addBookVote(Request $request){
        $em = $this->getDoctrine()->getManager();
        $bookId = $request->request->get('bookId');
        $userId = $request->request->get('userId');
        $vote = $request->request->get('vote');

        $book = $em->getRepository('App:Book')->find($bookId);
        $user = $em->getRepository('App:User')->find($userId);

        $voteBook = $em->getRepository('App:VoteBook')->findOneBy(['book' => $book, 'user' => $user]);
        if(!$voteBook){
            $voteBook = new Votebook();
            $voteBook->setUser($user);
            $voteBook->setBook($book);
            $book->addUservote($voteBook);
        }
        $voteBook->setVote($vote);
        $em->persist($voteBook);
        $em->flush();

        return $this->redirectToRoute('bookview',['id' => $bookId]);

    }

}