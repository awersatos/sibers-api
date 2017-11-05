<?php
/**
 * Created by PhpStorm.
 * User: jedi
 * Date: 05.11.17
 * Time: 14:37
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Foo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class FooFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i = 0;$i < 10; $i++){
            $foo = new Foo();
            $foo->setBar("Bar-$i");
            $manager->persist($foo);

        }
        $manager->flush();
    }
}