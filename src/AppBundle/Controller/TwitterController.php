<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Tweet;
use Doctrine\ORM\EntityManagerInterface;

class TwitterController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {
        $tweets = $this->getDoctrine()->getRepository(Tweet::class)->findAll();

        if(!$tweets)
        {
            $tweets = array();
        }

        return $this->render("twitter/index.html.twig", ['tweets' => $tweets]);
    }

    /**
     * @Route("/show/{id}", name="show", requirements={"id": "\d+"}, defaults={"id" = 0})
     */
    public function showAction(int $id)
    {
        if($id == 0)
        {
            return $this->redirectToRoute("index");
        }

        $tweet = $this->getDoctrine()->getRepository(Tweet::class)->find($id);

        if(!$tweet)
        {
            throw $this->createNotFoundException("Oops! Looks like there is no tweet no." . $id);
        }

        return $this->render("twitter/show.html.twig", ['tweet' => $tweet]);
    }

    /**
     * @Route("/remove/{id}", name="remove", requirements={"id": "\d+"}, defaults={"id" = 0})
     */
    public function removeAction(int $id)
    {
        if($id == 0)
        {
            return $this->redirectToRoute("index");
        }

        $em = $this->getDoctrine()->getManager();
        $tweet = $em->getRepository(Tweet::class)->find($id);

        if(!$tweet)
        {
            throw $this->createNotFoundException("Oops! Looks like there is no tweet no." . $id);
        }

        $em->remove($tweet);
        $em->flush();

        return $this->redirectToRoute("index");
    }
}
