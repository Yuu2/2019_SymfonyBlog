<?php

namespace App\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author yuu2
 * updated 2020.01.26
 * @Route("/admin")
 */
class ConfigController extends AbstractController {

  /**
   * 관리자 홈
   * @access public
   * @Route("/config", name="config", methods={"GET"})
   * @Template("admin/config.twig")
   * @return array
   */
  public function home(): ?array {

    return array();
  }
}