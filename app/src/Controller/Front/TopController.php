<?php 

namespace App\Controller\Front;

use App\Service\TopSkillHelper;
use App\Service\TopWorkHelper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * updated 2019.12.23
 * @author Yuu2
 */
class TopController extends AbstractController {

    /**
     * 홈
     * @access public
     *
     * @Route({"ko": "/", "jp": "/"}, name="home", methods={"GET"})
     * @Template("front/home.twig")
     * @param TopSkillHelper $topSkillHelper
     * @return array
     */
  public function home(TopSkillHelper $skillHelper, TopWorkHelper $workHelper) {

    return array(
      'Skills' => $skillHelper->all(),
      'Work'   => $skillHelper->all()
    );
  }
}