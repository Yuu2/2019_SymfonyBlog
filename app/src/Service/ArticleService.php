<?php 
namespace App\Service;

use App\Entity\Account;
use App\Entity\Article;
use App\Entity\Board;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\Session\Session;

class ArticleService {

  /**
   * @var EntityManagerInterface
   */
    protected $entityManager;

    public $error;

  /**
   * @param EntityManagerInterface $entityManager;
   */
  public function __construct($entityManager) {
    $this->entityManager = $entityManager;
  }
  /* --------------------------------------------- */
  public function generate($action, $request, $data) {
   
    switch($action) {
      
      case "article_index":
        return $this->article_index(); break;

      case "article_show" :
        return $this->article_show($data); break;

      case "article_new"  :
        $this->article_new($data); break;    
    }
  }
  /* --------------------------------------------- */
  public function article_index() {
    return $this->entityManager->getRepository(Article::class)
                ->index();
  }
  /* --------------------------------------------- */
  public function article_show($article_id) {
    
    return $this->entityManager->getRepository(Article::class)
                ->show($article_id);

  }
  /* --------------------------------------------- */
  public function article_new($data) {
    
    $article = new Article();
    $article = $data;
    $article->setCreatedAt(new \DateTime());

    $entityManager = $this->entityManager;

    $board = $entityManager->getRepository(Board::class)->find(1);
    $article->setBoard($board); // TODO: 게시판 분류 세분화

    $session = new Session();
    $account = $entityManager->getRepository(Account::class)->find($session->get('id'));
    $article->setAccount($account);
    
    $entityManager->persist($account);
    $entityManager->persist($board);
    $entityManager->persist($article);
    $entityManager->flush();
  
  }
}
?>