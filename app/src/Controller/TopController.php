<?php 

namespace App\Controller;

use App\Service\AsideService;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TopController extends AbstractController implements ApplicationController {

    /**
     * @access public
     * @Route("/", name="route")
     */
    function profile() {
      
      $entityManager = $this->getDoctrine()->getManager();
      $aside = new AsideService($entityManager);
      $data['Aside'] = $aside->execute();
      
      return $this->render('profile.html.twig', $data);
    }

    /**
     * @access public
     * @Route("/about", name="about")
     */
    function about() {

      $entityManager = $this->getDoctrine()->getManager();
      $aside = new AsideService($entityManager);
      $data['Aside'] = $aside->execute();

      return $this->render('about.html.twig', $data);
    }
}

?>