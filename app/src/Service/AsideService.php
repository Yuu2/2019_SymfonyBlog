<?php 
namespace App\Service;

use App\Entity\Account;
use App\Entity\Board;
use App\Entity\Category;

use Doctrine\ORM\EntityManagerInterface;

class AsideService {

  /**
   * @var EntityManagerInterface
   */
  private $entityManager;

  /**
   * @param EntityManagerInterface $entityManager;
   */
  public function __construct($entityManager) {
    $this->entityManager = $entityManager;
  }

  /**
   * @access public
   */
  function execute() {

    $account = $this->entityManager->getRepository(Account::class);
    $data['Account'] = $account->find(1);
    
    $category = $this->entityManager->getRepository(Category::class);
    $data['Categories'] = $category->findAll();

    $board = $this->entityManager->getRepository(Board::class);
    $data['Boards'] = $board->findAll();
   
    return $data;
  }
}
?>