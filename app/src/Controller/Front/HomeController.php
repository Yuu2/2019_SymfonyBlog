<?php 

namespace App\Controller\Front;

use App\Service\SkillHelper;
use App\Service\WorkHelper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * updated 2019.12.23
 * @author Yuu2
 */
class HomeController extends AbstractController {

    /**
     * 홈
     * @access public
     *
     * @Route({"ko": "/", "jp": "/"}, name="home", methods={"GET"})
     * @Template("front/home.twig")
     * @param SkillHelper $SkillHelper
     * @param WorkHelper $workHelper
     * @return array
     */
  public function home(SkillHelper $skillHelper, WorkHelper $workHelper) {

    return array(
      'Skills' => $skillHelper->all()
    );
  }
}