<?php

namespace App\Service;

use App\Entity\Article;
use App\Entity\ArticleComment;
use App\Entity\ArticleTag;
use App\Entity\Tag;
use App\Entity\User;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\TagRepository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @author yuu2dev
 * updated 2021.02.16
 */
class BlogService {
  
    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @var TagRepository
     */
    private $tagRepository;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var Security
     */
    private $security;
  

    /**
     * @access public
     * @param ArticleRepository $articleRepository
     * @param EntityManagerInterface $entityManager
     * @param CategoryRepository $categoryRepository
     * @param TagRepository $tagRepository
     * @param TokenStorageInterface $tokenStorage
     * @param PaginatorInterface $paginatorInterface
     * @param Security $security
     */
    public function __construct(
        ArticleRepository $articleRepository,
        EntityManagerInterface $entityManager, 
        CategoryRepository $categoryRepository,
        TagRepository $tagRepository,
        TokenStorageInterface $tokenStorage,
        PaginatorInterface $paginator,
        Security $security
    ) {
        $this->entityManager = $entityManager;
        $this->articleRepository = $articleRepository;
        $this->categoryRepository = $categoryRepository;
        $this->tagRepository = $tagRepository;
        $this->tokenStorage = $tokenStorage;
        $this->paginator = $paginator;
        $this->security = $security;
    }

    /**
     * 블로그 게시글 가져오기
     * @access public
     * @param int $id
     * @return Article
     */
    public function findArticle(int $id): ?Article {
        return $this->articleRepository->findArticleById($id);
    }

    /**
     * 블로그 게시글 페이징
     * @access public
     * @param Request $request
     * @return Object
     */
    public function pagingArticles(Request $request, $limit = 5): Object {

        $params = [
        'category' => $request->query->get('category'),
        'search' => $request->query->get('search'),
        'tag' => $request->query->get('tag'),
        ];
        
        $query = $this->articleRepository->paging($params);
        $page  = $request->query->getInt('page', 1);

        $pagination = $this->paginator->paginate($query, $page, $limit);

        return $pagination;
    }


    /**
     * 최근 블로그 게시글
     * @access public
     * @param int $count
     * @return array
     */
    public function recentArticles(int $count = 10): ?array {
        return $this->articleRepository->recentArticles($count);
    }

    /**
     * 총 게시글 수
     * @access public
     * @return string
     */
    public function countArticles(): ?string {
        return $this->articleRepository->countArticles();
    }

    /**
     * 게시글 댓글 수
     * @access public
     * @param Article $article
     * @return int
     */
    public function countCommentsByEntity(Article $article): int {
        
        $count = 0;

        $parents = $article->getComments()->getValues();
        
        foreach($parents as $child) {
            $count += count($child->getRecomment());
        }

        $count += count($parents);

        return $count;
    }

    /**
     * 최근 블로그 태그
     * @access public
     * @param int $count
     * @return array
     */
    public function recentTags(int $count = 30): ?array {
        return $this->tagRepository->countTags($count);
    }

    /**
     * 블로그 게시글 작성
     * @access public
     * @param Article $article
     * @param array $hashtagForm
     * @return bool
     */
    public function writeArticle(Article $article, array $hashtags): bool {
        
        try {
        
            $artitags = [];
        
            foreach($article->getTag() as $tag) {
                $artitags[] = $tag->getName();
            }

            // 해시태그 주입 시 
            foreach(array_diff($hashtags, $artitags) as $hashtag) {

                $tag = new Tag;
                
                $tag->setName($hashtag);
                $tag->setCreatedAt(new \DateTime);
                
                $this->entityManager->persist($tag);

                $article->addTag($tag);
            }

            // 해시태그 삭제 시
            foreach(array_diff($artitags, $hashtags) as $hashtag) {
                
                foreach($article->getTag() as $tag) {
                
                    if($tag->getName() == $hashtag) {
                        $article->removeTag($tag);
                    }
                }
            }
        
            $article->setCreatedAt(new \DateTime);

            $this->entityManager->persist($article);
            $this->entityManager->flush();
            return true;
        } catch(\Exception $e) {
            return false;
        }
    }

    /**
     * 블로그 댓글 작성
     * @access public
     * @param ArticleComment $comment
     * @return bool
     */
    public function writeComment(ArticleComment $comment): bool {

        try {
            $user = $this->tokenStorage->getToken() ? $this->tokenStorage->getToken()->getUser() : null;

            /** [1] 멤버유저 */
            if ($user instanceof User) {
                $comment->setUser($user);
                $comment->setUsername($user->getUsername());
            
            /** [2] 익명유저 */
            } else {

                // 패스워드가 존재하지 않을 경우 세팅
                if (!$comment->getId()) {
                    $comment->setPassword(password_hash($comment->getPassword(), PASSWORD_BCRYPT, ['cost' => 8]));
                }
            }

            $comment->setIp($_SERVER['REMOTE_ADDR'] .':'.$_SERVER['SERVER_PORT']);
            $comment->setDevice($_SERVER['HTTP_USER_AGENT']);
            $comment->getCreatedAt() ? $comment->setUpdatedAt(new \DateTime) : $comment->setCreatedAt(new \DateTime);
            
            $this->entityManager->persist($comment);
            $this->entityManager->flush();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
  
    /**
     * 블로그 게시글 삭제
     * @access public
     * @param Article $article
     * @return void
     */
    public function removeArticle(Article $article): void {
        $this->entityManager->remove($article);
        $this->entityManager->flush();
    }

    /**
     * 블로그 태그 삭제
     * @access public
     * @param Tag $tag
     * @return void
     */
    public function removeTag(Tag $tag): void {
        $this->entityManager->remove($tag);
        $this->entityManager->flush();
    }

    /**
     * 블로그 댓글 삭제
     * @access public
     * @param ArticleComment $comment
     * @return bool
     */
    public function removeComment(ArticleComment $comment): bool {

        try {
            // 답글이 없을 경우 비공개처리  
            $comment->getRecomment()->isEmpty() ? $comment->setVisible(false) : null;
            
            $comment->setDeletedAt(new \DateTime);
    
            $this->entityManager->persist($comment);
            $this->entityManager->flush();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 해시태그 문자열을 배열로
     * @access public
     * @param string $hashtag
     * @return array
     */
    public function hashtagStringToArray(?string $hashtag): array {
        
        $hashtagArr = [];

        if (!empty($hashtag)) {
            $hashtagArr = explode(',', $hashtag);
        }

        return $hashtagArr;
    }
}