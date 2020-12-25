<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Portfolio;
use App\Entity\Skill;
use App\Entity\Tag;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @abstract 
 * @author yuu2dev
 * updated 2020.06.30
 */
abstract class AbstractFixtures extends Fixture {

  /**
   * @var ObjectManager
   */
  protected $objectManager;

  /**
   * @var UserPasswordEncoderInterface
   */
  protected $userPasswordEncoder;

  /**
   * @access public
   * @param UserPasswordEncoderInterface $userPasswordEncoder
   */
  public function __construct(UserPasswordEncoderInterface $userPasswordEncoder) {
    $this->userPasswordEncoder = $userPasswordEncoder;
  }
}

