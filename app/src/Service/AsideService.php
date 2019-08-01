<?php 
namespace App\Service;

use App\Entity\Account;
use App\Entity\Board;
use App\Entity\Category;

use Doctrine\ORM\EntityManagerInterface;

class AsideService {

  /**
   * @access public
   * @static
   */
  function get(EntityManagerInterface $entityManager) {

    $account = $entityManager->getRepository(Account::class);
    $data['Account'] = $account->find(1);
    
    $category = $entityManager->getRepository(Category::class);
    $data['Categories'] = $category->findAll();

    $board = $entityManager->getRepository(Board::class);
    $data['Boards'] = $board->findAll();
   
    return $data;
  }
}
?>