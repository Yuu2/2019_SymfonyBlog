<?php

namespace App\DataFixtures;

use App\Entity\Account;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface; 

/**
 * 2019.10.20
 * @author Yuu2
 * bin/console doctrine:fixtrues:load 실행
 */
class AccountFixtures extends Fixture {

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * @access public
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }
    
    /**
     * @access public
     */
    public function load(ObjectManager $manager) {
        $account = new Account();

        $account->setEmail('test@gmail.com');
        $account->setPassword(
            $this->encoder->encodePassword($account, '1234')
        );

        $manager->persist($account);
        $manager->flush();
    }
}
