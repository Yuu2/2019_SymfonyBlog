<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * @author Yuu2
 * updated 2020.01.18
 */
class ArticleFixtures extends AbstractFixtures implements DependentFixtureInterface {

  /**
   * @access public
   * @param ObjectManager $manager
   */
  public function load(ObjectManager $manager) {
    
    $count = 50;

    for ($i = 1; $i <= $count; $i++) {
      $this->createArticle($manager, $i, $i, "work-2.jpg");
    }

    $manager->flush();
  }

  /**
   * @access public
   */
  public function getDependencies() {
      return array(
        UserFixtures::class
      );
  }
}
