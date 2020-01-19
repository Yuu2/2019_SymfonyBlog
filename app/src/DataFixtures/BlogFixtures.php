<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * @author Yuu2
 * updated 2020.01.19
 */
class BlogFixtures extends AbstractFixtures implements DependentFixtureInterface {

  /**
   * @access public
   * @param ObjectManager $manager
   * @return void
   */
  public function load(ObjectManager $manager): void {
    
    $this->createTags($manager, 20);
    $this->createArticles($manager, 50);

    $manager->flush();
  }

  /**
   * @access public
   * @return array
   */
  public function getDependencies(): array {
      return array(
        UserFixtures::class
      );
  }

   /**
   * @access private
   * @param ObjectManager $manager
   * @param int $count
   * @return void
   */
  private function createArticles(ObjectManager $manager, int $count) {
    for ($i = 1; $i <= $count; $i++) {
      $this->createArticle($manager, $i, $i, "work-1.jpg");
    }
  }

  /**
   * @access private
   * @param ObjectManager $manager
   * @param int $count
   * @return void
   */
  private function createTags(ObjectManager $manager, int $count) {
    for ($i = 1; $i <= $count; $i++) {
      $this->createTag($manager, $i);
    }
  }
}
