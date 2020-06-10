<?php

namespace App\DataFixtures;

use App\Entity\Skill;
use App\Entity\Portfolio;
use App\Entity\PortfolioSkill;

use Doctrine\Common\Persistence\ObjectManager;

/**
 * @author yuu2dev
 * updated 2020.06.10
 */
class HomeFixtures extends AbstractFixtures {

  public function load(ObjectManager $manager) {
    
    $portfolio = $this->createPortfolio($manager, "JavaFx-Chat", "Window/Mac 어플리케이션", "https://github.com/Yuu2/javafx-chat");

    $this->createPortfolioSkill(
      $manager, 
      $portfolio,
      $this->createSkill($manager, 'Java', 70, "A")
    );
    $this->createPortfolioSkill(
      $manager, 
      $portfolio,
      $this->createSkill($manager, 'MySQL', 50, "B", false)
    );
    
    $manager->flush();
  }
  
  /**
   * @access protected
   * @param ObjectManager $manager
   * @param Portfolio $portfolio
   * @param Skill $skill
   */
  protected function createPortfolioSkill(ObjectManager $manager, Portfolio $portfolio, Skill $skill) {

    $portfolio_skill = new PortfolioSkill();
    $portfolio_skill->setPortfolio($portfolio);
    $portfolio_skill->setSkill($skill);

    $manager->persist($portfolio_skill);
  }
}
