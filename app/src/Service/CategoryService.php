<?php

namespace App\Service;

use App\Repository\CategoryRepository;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @author Yuu2
 * updated 2020.01.26
 */
class CategoryService {

  /**
   * @var UrlGeneratorInterface
   */
  protected $urlGenerator;

  /**
   * @var CategoryRepository
   */
  protected $categoryRepository;

  /**
   * @var string
   */
  protected $html;

  /**
   * @access public
   * @param UrlGeneratorInterface $urlGenerator
   * @param CategoryRepository $categoryRepository
   */
  public function __construct(UrlGeneratorInterface $urlGenerator, CategoryRepository $categoryRepository) {
    $this->urlGenerator = $urlGenerator;
    $this->categoryRepository = $categoryRepository;
  }

  /**
   * 블로그 카테고리
   * @access public
   * @param array $categories
   * @return string
   */
  public function categories(array $categories): string {

    $this->html .= '<ul>';
  
    foreach($categories as $category) {
      $url = $this->urlGenerator->generate('blog_index', array('category' => $category['id']));
      $this->html .= '<li>' . '<a href="' . $url .'">' . $category['title'] .  '</a>'.'</li>';

      if(!empty($category['subcategory'])) 
        $this->categories($category['subcategory']);

    }

    $this->html .= '</ul>';

    return $this->html;
  }

  /**
   * 계층 카테고리 배열
   * @access public
   * @param int $parent
   */
  public function hierarachy(int $parent = NULL): ?array {

      $tree = array();

      $categories = $this->categoryRepository->findBy(array('parent' => $parent), array('id' => 'ASC'));
      
      foreach ($categories as $category) {

        array_push(
          $tree,
          array_filter(
            array(
              'id' => $category->getId(),
              'title' => $category->getTitle(),
              'subcategory' => $this->hierarachy($category->getId())
            )
          )
        );
      }
      return $tree;
  }
}