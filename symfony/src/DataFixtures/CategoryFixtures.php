<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * @author yuu2dev
 * updated 2020.12.26
 */
class CategoryFixtures extends Fixture implements DependentFixtureInterface {

  /**
   * @var ObjectManager
   */
  private $objectManager;

  /**
   * @access public
   * @param ObjectManager $objectManager
   * @return void
   */
  public function load(ObjectManager $objectManager) {
    
    $this->objectManager = $objectManager;

    $this->addCategory(
      (new Category)
        ->setTitle('일기')
        ->setCreatedAt(new \DateTime)
        ->setSortNo(1)
    );

    $this->addCategory(
      (new Category)
        ->setTitle('공부')
        ->setCreatedAt(new \DateTime)
        ->setSortNo(2)
    );
  }

  /**
   * @access protected
   * @param array $categories
   * @return void
   */
  protected function addCategories(array $categories) {}
  
  /**
   * @access protected
   * @param Category $category
   * @param bool $flagFlush
   * @return void;
   */
  protected function addCategory(Category $category, $flagFlush = true) {
    $this->objectManager->persist($category);
    $flagFlush ? $this->objectManager->flush() : null;
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
