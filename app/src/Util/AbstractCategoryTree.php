<?php

namespace App\Util;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @abstract
 * @author Yuu2
 * @todo
 * updated 2020.01.20
 */
abstract class AbstractCategoryTree {

  /**
   * @var EntityManagerInterface
   */
  public $manager;

  /**
   * @var UrlGeneratorInterface
   */
  protected $generator;

  protected static $conn; 

  /**
   * @var array
   */
  public $categories;

  /**
   * @access public
   * @param EntityManagerInterface $manager
   * @param UrlGeneratorInterface $generator
   */
  public function __construct(EntityManagerInterface $manager, UrlGeneratorInterface $generator) {
    $this->manager = $manager;
    $this->generator = $generator;
    $this->categories = $this->all();
  }

  /**
   * @abstract
   * @access public
   */
  abstract public function frontCategory(array $categories);  

   /**
    * @access public
    */
  public function buildTree(int $parent_id = NULL): ?array {

    $subCategory = [];
      
    foreach($this->categories as $category) {

      if($category['parent_id'] == $parent_id) {
              
        $children = $this->buildTree($category['id']);

        if($children) $category['children'] = $children;
          
        $subCategory[] = $category;
      }
    }
    return $subCategory;
  }
  
  /**
   * DB로부터 모든 카테고리 리스트를 취득
   * @access public
   * @return array
   */
  public function all(): ?array {
      if(self::$conn) {
          return self::$conn;
      } else {
          $conn = $this->manager->getConnection();
          $sql  = "SELECT * FROM category";
          $stmt = $conn->prepare($sql);
          $stmt->execute();
          return self::$conn = $stmt->fetchAll();
      }
  }
}