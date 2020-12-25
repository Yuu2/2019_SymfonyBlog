<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Portfolio;
use App\Entity\Skill;
use App\Entity\Tag;
use App\Entity\User;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @abstract 
 * @author yuu2dev
 * updated 2020.12.27
 */
abstract class AbstractFixtures extends Fixture {

}

