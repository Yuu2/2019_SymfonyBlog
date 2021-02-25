<?php 

namespace App\Controller\Front;

use App\Service\HomeService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @author yuu2dev
 * updated 2020.06.19
 */
class HomeController extends AbstractController {

    /**
     * 홈
     * @Route("/", name="home", methods={"GET"})
     * @Template("front/home.twig")
     * @access public
     * @param HomeService $homeService
     * @return array
     */
    public function home(HomeService $homeService) {
        
        return array(
            'Portfolios' => $homeService->findPortfolios(),
            'Skills'     => $homeService->findSkills(),
            'Work'       => $homeService->findWork()
        );
    }

    /**
     * 빈 페이지
     * @Route("/blank", name="blank", methods={"GET"})
     * @Template("front/blank.twig")
     * @access public
     */
    public function blank() {
        return array();
    }
}