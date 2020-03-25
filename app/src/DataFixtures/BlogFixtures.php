<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Tag;
use App\Entity\ArticleTag;

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
    
    $this->createCategories($manager, 10);

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
   * @access protected
   * @param ObjectManager $manager
   * @param int $count
   * @return void
   */
  protected function createCategories(ObjectManager $manager, int $count) {
    for ($i = 1; $i <= $count; $i++) {
      $this->createCategory($manager, $i);
    }
  }
}
