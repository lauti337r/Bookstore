<?php
/**
 * Created by PhpStorm.
 * User: lauti337r
 * Date: 01/09/18
 * Time: 10:48
 */

namespace App\Controller;


use App\Entity\Detail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/clearCart",name="clear_cart")
     */
    public function clearCart(){
        try{
        $user = $this->getUser();
        $cart = $user->getCart();
        $cart->clear();
        $em = $this->getDoctrine()->getManager();
        $em->persist($cart);
        $em->flush();
        }catch(\ErrorException $e){
            return new JsonResponse(['success' => false]);
        }
        return new JsonResponse(['success' => true]);

    }

    /**
     * @Route("/addToCart",name="add_to_cart",methods={"POST"}))
     */
    public function addToCart(Request $request){
        $em = $this->getDoctrine()->getManager();
        $bookId = $request->request->get('bookId');
        $book = $em->getRepository('App:Book')->find($bookId);
        $user = $this->getUser();
        $cart = $user->getCart();

        $detail = $cart->findBook($bookId);
        if(!$detail){
            $detail = new Detail();
            $detail->setBook($book);
            $detail->setQuantity(1);
            $detail->setCart($cart);
        }else{
            $detail->incrQuant();
        }


        $em->persist($detail);
        $em->flush();

        if($detail->getId())
            return new JsonResponse([
                'success' => true,
                'quantity' => $detail->getQuantity(),
                'book' => [
                    'id' => $book->getId(),
                    'title' => $book->getTitle(),
                    'author' => $book->getAuthor()->getName(),
                    'price' => $book->getPrice()
                ]
                ]);
        else return new JsonResponse(['success' => false]);
    }
}