<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Tweet;

class LoadTweetData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for($i = 1; $i < 10; $i++)
        {
            $tweet = new Tweet();
            $tweet->setTitle("Tweet no." . $i);
            $tweet->setBody("Lorem ipsum no." . $i . "!");
            $tweet->setAuthor($this->getReference("user"));

            $manager->persist($tweet);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}