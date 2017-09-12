<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Doctrine\ORM\EntityManagerInterface;

use AppBundle\Form\TweetType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Tweet;
use Symfony\Component\HttpFoundation\Request;

class TwitterController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {
        $tweets = $this->getDoctrine()->getRepository(Tweet::class)->findAllOrderedByIdDesc();

        if(!$tweets)
        {
            $tweets = array();
        }

        return $this->render("twitter/list.html.twig", ['tweets' => $tweets]);
    }

    /**
     * @Route("/list", name="list")
     */
    public function listAction()
    {
        return $this->redirectToRoute("index");
    }

    /**
     * @Route("/list/{name}", name="listByAuthor", )
     */
    public function listByAuthor(string $name)
    {
        $author = $this
            ->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy(["name" => $name]);

        if(!$author)
        {
            throw $this->createNotFoundException("Oops! Looks like there is no such user");
        }

        $tweets = $this->getDoctrine()->getRepository(Tweet::class)->findBy(['author' => $author]);

        if(!$tweets)
        {
            $tweets = array();
        }

        return $this->render("twitter/list.html.twig", ['tweets' => $tweets]);
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

    /**
     * @Route("/create", name="create")
     */
    public function createAction(Request $request)
    {
        $tweet = new Tweet();
        $form = $this->createForm(TweetType::class, $tweet);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();

            // TODO Set the current user
            $author = $em->getRepository(User::class)->findOneBy(['name' => 'Bob']);
            $tweet->setAuthor($author);

            $em->persist($tweet);
            $em->flush();

            return $this->redirectToRoute('index');
        }

        return $this->render('twitter/create.html.twig', ['form' => $form->createView()]);
    }
}
