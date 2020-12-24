<?php

namespace App\Service;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @author yuu2dev
 * updated 2020.12.24
 */
class CategoryService {

  /**
   * @var EntityManagerInterface
   */
  protected $entityManager;

  /**
   * @var CategoryRepository
   */
  protected $categoryRepository;

  /**
   * @access public
   * @param EntityManagerInterface $entityManager
   * @param CategoryRepository $categoryRepository
   */
  public function __construct(
    EntityManagerInterface $entityManager, 
    CategoryRepository $categoryRepository
  ) {
    $this->entityManager = $entityManager;
    $this->categoryRepository = $categoryRepository;
  }

  /**
   * 모든 카테고리 목록
   * @access public
   * @return array
   */
  public function allCategories() : ?array { 
    return $this->categoryRepository->findAll();
  }

  /**
   * @access public 
   * @param Category $category
   */
  public function addCategory(Category $category) {
    $this->entityManager->persist($category);
    $this->entityManager->flush();

    // 수정 일 때에는 정렬하지 않음
    if (!empty($category->getId())) 
    return;

    $this->sorting();
  } 

  /**
   * @access public
   * @param Category $category
   */
  public function removeCategory(Category $category) {
    $this->entityManager->remove($category);
    $this->entityManager->flush();
    $this->sorting();
  }

  /**
   * @access protected
   */
  protected function sorting() {

    $categories = $this->allCategories();
    
    if (empty($categories)) return;

    $sort_no = 1;

    foreach ($categories as $category) {
      $category->setSortNo($sort_no);
      $category->setUpdatedAt(new \DateTime);
      $this->entityManager->persist($category);
      $sort_no++;
    }

    $this->entityManager->flush();
  }
}