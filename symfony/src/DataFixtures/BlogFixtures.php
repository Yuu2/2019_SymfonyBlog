<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Tag;
use App\Entity\ArticleTag;
use App\Entity\Category;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * @author yuu2dev
 * updated 2020.01.19
 */
class BlogFixtures extends AbstractFixtures implements DependentFixtureInterface {
  
  /**
   * @var ObjectManager
   */
  private $objectManager;

  /**
   * @access public
   * @param ObjectManager $objectManager
   * @return void
   */
  public function load(ObjectManager $objectManager): void {
    
  }

  /**
   * @access protected
   * @param int $count
   * @return void
   */
  protected function createCategories(array $categories) {
    foreach ($categories as $category) {
      $this->createCategory($category);
    }
  }
  
  /**
   * @access protected
   * @param string $title
   * @return Category
   */
  protected function createCategory(string $title): ?Category {
    
    $category = new Category();
    $category->setTitle($title);

    $this->objectManager->persist($category);

    return $category;
  }

  /**
   * @access public
   * @return array
   */
  public function getDependencies(): array {
    return [
      UserFixtures::class
    ];
  }
}
