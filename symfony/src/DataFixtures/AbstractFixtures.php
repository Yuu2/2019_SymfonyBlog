<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Portfolio;
use App\Entity\Skill;
use App\Entity\Tag;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @abstract 
 * @author yuu2dev
 * updated 2020.06.30
 */
abstract class AbstractFixtures extends Fixture {

  /**
   * @var UserPasswordEncoderInterface
   */
  protected $userPasswordEncoder;

  /**
   * @access public
   * @param UserPasswordEncoderInterface $userPasswordEncoder
   */
  public function __construct(UserPasswordEncoderInterface $userPasswordEncoder) {
    $this->userPasswordEncoder = $userPasswordEncoder;
  }

  /**
   * @access protected
   * @param ObjectManager $manager
   * @param string $name
   * @param int $percentage
   * @param string $level
   * @param bool $visible
   * @return Skill
   */
  protected function createSkill(ObjectManager $manager, string $name, int $percentage, string $level, bool $visible = true): ?Skill {
    
    $skill = new Skill();

    $skill->setName($name);
    $skill->setPercentage($percentage);
    $skill->setLevel($level);
    $skill->setVisible($visible);

    $manager->persist($skill);

    return $skill;
  }
  
  /**
   * @access protected
   * @param ObjectManager $manager
   * @param string $title
   * @param string $subtitle
   * @param string $url
   * @param bool $visible
   * @return Portfolio
   */
  protected function createPortfolio(ObjectManager $manager, string $title, string $subtitle, string $url, bool $visible = true): ?Portfolio {
    
    $portfolio = new Portfolio();
    $portfolio->setTitle($title);
    $portfolio->setSubtitle($subtitle);
    $portfolio->setUrl($url);
    $portfolio->setVisible($visible);
    $portfolio->setCreatedAt(new \DateTime);
    
    $manager->persist($portfolio);

    return $portfolio;
  }

  /**
   * @access protected
   * @param ObjectManager $manager
   * @param string $title
   * @param string $content
   * @param string thumbnail
   * @param bool $visible
   * @param Category $category
   * @return Article $article
   */
  protected function createArticle(ObjectManager $manager, string $title, string $content, string $thumbnail, bool $visible = true, Category $category): ?Article{
    
    $article = new Article();
    $article->setTitle($title);
    $article->setContent($content);
    $article->setThumbnail($thumbnail);
    $article->setVisible($visible);
    $article->setCreatedAt(new \DateTime);
    $article->setCategory($category);

    $manager->persist($article);

    return $article;
  }

  /**
   * @access protected
   * @param ObjectManager $manager
   * @param string $name
   * @return Tag
   */
  protected function createTag(ObjectManager $manager, string $name): ?Tag {
    
    $tag = new Tag();
    $tag->setName($name);
    $manager->persist($tag);

    return $tag;
  }
}

