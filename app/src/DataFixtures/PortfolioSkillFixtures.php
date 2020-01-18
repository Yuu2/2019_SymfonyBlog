<?php

namespace App\DataFixtures;

use App\Entity\Skill;
use App\Entity\Portfolio;
use App\Entity\PortfolioSkill;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * @author Yuu2
 * updated 2020.01.18
 */
class PortfolioSkillFixtures extends Fixture {

  public function load(ObjectManager $manager) {
    
    $this->createPortfolioSkill(
      $manager,
      $this->createPortfolio($manager, "JavaFx-Chat", "Window/Mac 어플리케이션"),
      $this->createSkill($manager, 'Symfony', 70, "A")
    );
    
    $manager->flush();
  }

    /**
   * @access private
   * @param ObjectManager $manager
   * @param string $name
   * @param int $percentage
   * @param string $level
   * @return Skill
   */
  private function createSkill(ObjectManager $manager, string $name, int $percentage, string $level): Skill {
    
    $skill = new Skill();

    $skill->setName($name);
    $skill->setPercentage($percentage);
    $skill->setLevel($level);

    $manager->persist($skill);

    return $skill;
  }
  
  /**
   * @access private
   * @param ObjectManager $manager
   * @param string $title
   * @param string $subtitle
   * @return Portfolio
   */
  private function createPortfolio(ObjectManager $manager, string $title, string $subtitle): Portfolio {
    
    $portfolio = new Portfolio();
    $portfolio->setTitle($title);
    $portfolio->setSubtitle($subtitle);
    $portfolio->setCreateAt(new \DateTime);
    
    $manager->persist($portfolio);

    return $portfolio;
  }

  /**
   * @access private
   * @param ObjectManager $manager
   * @param Portfolio $portfolio
   * @param Skill $skill
   */
  private function createPortfolioSkill(ObjectManager $manager, Portfolio $portfolio, Skill $skill) {

    $portfolio_skill = new PortfolioSkill();
    $portfolio_skill->setPortfolio($portfolio);
    $portfolio_skill->setSkill($skill);

    $manager->persist($portfolio_skill);
  }
}
