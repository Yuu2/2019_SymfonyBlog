<?php 
namespace App\Service;

use App\Entity\Account;
use App\Entity\Article;
use App\Entity\Board;

use App\Util\Paginator;
use App\Util\Validator;

use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\Session\Session;

use Doctrine\ORM\EntityManagerInterface;

class ArticleService {

  /**
   * @var EntityManagerInterface
   */
    private $entityManager;

    // TEMP
    public $error;

  /**
   * @access public
   * @param EntityManagerInterface $entityManager;
   */
  public function __construct($entityManager) {
    $this->entityManager = $entityManager;
  }
  
  /* --------------------------------------------- */
  /**
   * @access public
   * @param String $action
   * @param Request $request
   * @param Array $data
   * @param Session $session
   */ 
  function execute($action, $request, $data, $session) {
    
    switch($action) {
      case "index":
        return $this->index($request); break;
      case "paging":
        return $this->paging($request); break;
      case "show" :
        return $this->show($data); break;
      case "new"  :
        $this->new($data, $session); break;
    }
  }

  /* --------------------------------------------- */
  /**
   * @access private
   * @param Request $request
   */
  function index($request) {
  
    $board = $request->query->get('board');
    if(!Validator::isNum($board)){return null;}

    $page = $request->query->get('page');
    if(!Validator::isNum($page)){return null;}

    return $this->entityManager
                ->getRepository(Article::class)
                ->index($board, $page);
  }

  /* --------------------------------------------- */
  /**
   * @access private
   * @param Request $request
   */
  function paging($request) {
  
    $board = $request->query->get('board');
    if(!Validator::isNum($board)){return null;}
    
    $page = $request->query->get('page');
    if(!Validator::isNum($page)){return null;}

    $row = $this->entityManager
                ->getRepository(Article::class)
                ->total($board);
    
    $pageInfo = new Paginator($board, $page, $row['total']);
    
    return $pageInfo->data;
  }  
  /* --------------------------------------------- */
  /**
   * @access private
   */
  function show($id) {
    
    return $this->entityManager
                ->getRepository(Article::class)
                ->show($id);
  }
  /* --------------------------------------------- */
  /**
   * @access public
   */
  function new($data, $session) {

    $article = new Article();
    $article = $data;

    $article->setCreatedAt(new \DateTime());
  
    $entityManager = $this->entityManager;
    
    $account = $entityManager->getRepository(Account::class)->find(1);
    $board = $entityManager->getRepository(Board::class)->find($article->getBoard()->getId());
    
    if(empty($account)) { 
      return; 
    }

    $article->setAccount($account);
    $article->setBoard($board);

    $entityManager->persist($account);
    $entityManager->persist($board);
    $entityManager->persist($article);
    $entityManager->flush();
  
  }
}
?>