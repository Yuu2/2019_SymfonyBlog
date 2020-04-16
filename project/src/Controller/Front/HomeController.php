<?php 

namespace App\Controller\Front;

use App\Service\HomeService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @author Yuu2
 * updated 2020.04.09
 */
class HomeController extends AbstractController {

  /**
   * 홈
   * @access public
   *
   * @Route("/", name="home", methods={"GET"})
   * @Template("front/home.twig")
   * @param HomeService $homeService
   * @return array
   */
  public function home(HomeService $homeService) {
    
    return array(
      'Portfolios' => $homeService->renderPortfolios(),
      'Skills'     => $homeService->renderSkills(),
      'Work'       => $homeService->renderWork()
    );
  }
}