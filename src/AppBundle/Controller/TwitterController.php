<?php
/**
 * Created by PhpStorm.
 * User: imolcean
 * Date: 01.08.17
 * Time: 15:55
 */

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

        for($i = 0; $i < $num; $i++)
        {
            $tweet = new Tweet('Tweet no.' . $i, 'anonymous', 'Lorem ipsum etc.');

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
}