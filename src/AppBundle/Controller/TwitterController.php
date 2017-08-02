<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Utils\Tweet;

class TwitterController extends Controller
{
    /**
     * @param int $num
     * @return array
     *
     * This is a temporary function. It will be removed.
     */
    private function getTweets(int $num) : array
    {
        $res = array();

        for($i = 1; $i < $num; $i++)
        {
            $tweet = new Tweet($i, 'Tweet no.' . $i, 'anonymous', 'Lorem ipsum etc.');

            array_push($res, $tweet);
        }

        shuffle($res);

        return $res;
    }

    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {
        return $this->render("twitter/index.html.twig", ['tweets' => $this->getTweets(15)]);
    }

    /**
     * @Route("/show/{id}", name="show", requirements={"id": "\d+"}, defaults={"id" = 0})
     */
    public function showAction(int $id)
    {
        $tweet = new Tweet($id, "Tweet no." . $id, "anonymous", "Lorem ipsum etc.");

        if($id == 0)
        {
            return $this->redirectToRoute("index");
        }

        return $this->render("twitter/show.html.twig", ['tweet' => $tweet]);
    }
}
