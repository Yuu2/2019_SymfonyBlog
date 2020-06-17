<?php

namespace App\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author yuu2dev
 * updated 2020.06.16
 * @Route("/admin")
 */
class HomeController extends AbstractController {

  /**
   * 홈
   * @access public
   * @Route("/", name="admin_home", methods={"GET"})
   * @Template("admin/home.twig")
   * @return array
   */
  public function home(): ?array {

    return array();
  }
}