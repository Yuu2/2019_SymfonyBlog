<?php 
namespace App\Services;

use App\Entity\Account;
use App\Entity\Board;
use App\Entity\Category;
use App\Repository\CategoryRepository;

use Doctrine\ORM\EntityManagerInterface;

class CategoryHelper {

  /**
   * @var EntityManagerInterface
   */
  private $entityManager;
  /**
   * @var CategoryRepository $categoryRepository
   */
  private $categoryRepository;

  /**
   * @param EntityManagerInterface $entityManager;
   */
  public function __construct(EntityManagerInterface $entityManager) {
    $this->entityManager = $entityManager;
  }

  /**
   * @access public
   * @param String $command
   * @return array
   */
  function exec() {

    $category = $this->entityManager->getRepository(Category::class);
    $data['Categories'] = $category->findAll();

  
    return $data;
  }
}
?>