<?php 

namespace App\Controller\Front;

use App\Service\SkillService;
use App\Service\PortfolioService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @author Yuu2
 * updated 2020.01.18
 */
class HomeController extends AbstractController {

  /**
   * 홈
   * @access public
   *
   * @Route("/", name="home", methods={"GET"})
   * @Template("front/home.twig")
   * @param SkillService $skillService
   * @param PortfolioService $portfolioService
   * @return array
   */
  public function home(SkillService $skillService, PortfolioService $portfolioService) {
 
    return array(
      'Skills' => $skillService->all(),
      'Portfolios' => $portfolioService->all()
    );
  }
}