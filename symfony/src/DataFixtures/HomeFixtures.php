<?php

namespace App\DataFixtures;

use App\Entity\Skill;
use App\Entity\Portfolio;
use App\Entity\PortfolioSkill;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * @author yuu2dev
 * updated 2020.06.30
 */
class HomeFixtures extends Fixture implements DependentFixtureInterface {

  public function load(ObjectManager $objectManager) {
    /*
    $portfolio = $this->createPortfolio($objectManager, "JavaFx-Chat", "Window/Mac 어플리케이션", "https://github.com/Yuu2/javafx-chat");

    $this->createPortfolioSkill(
      $objectManager, 
      $portfolio,
      $this->createSkill($objectManager, 'Java', 70, "A")
    );
    $this->createPortfolioSkill(
      $objectManager, 
      $portfolio,
      $this->createSkill($objectManager, 'MySQL', 50, "B", false)
    );
    
    $objectManager->flush();
    */
  }
  
  /**
   * @access protected
   * @param ObjectManager $objectManager
   * @param Portfolio $portfolio
   * @param Skill $skill
   */
  protected function createPortfolioSkill(ObjectManager $objectManager, Portfolio $portfolio, Skill $skill) {

    $portfolio_skill = new PortfolioSkill();
    $portfolio_skill->setPortfolio($portfolio);
    $portfolio_skill->setSkill($skill);

    $objectManager->persist($portfolio_skill);
  }
}
