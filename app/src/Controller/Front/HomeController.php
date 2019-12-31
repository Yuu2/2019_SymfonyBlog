<?php 

namespace App\Controller\Front;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * updated 2019.12.31
 * @author Yuu2
 */
class HomeController extends AbstractController {

    /**
     * 홈
     * @access public
     *
     * @Route({"ko": "/", "jp": "/"}, name="home", methods={"GET"})
     * @Template("front/home.twig")
     * @return array
     */
  public function home() {

    return array();
  }
}