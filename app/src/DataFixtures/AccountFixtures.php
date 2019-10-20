<?php

namespace App\DataFixtures;

use App\Entity\Account;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * 2019.10.20
 * @author Yuu2
 */
class AccountFixtures extends Fixture {
    public function load(ObjectManager $manager) {
        $account = new Account();
        //        

        $manager->flush();
    }
}
