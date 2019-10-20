<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @author Yuu2
 */
class GuestBookController extends AbstractController implements ApplicationController {
    
    /**
     * @access public
     */
    public function __construct() {}

    /**
     * 방명록 일람
     * @access public
     * @Route("/guestbook/index", name="guestbook", methods={"GET"})
     * @Template("/guestbook/guestbook.twig")
     */
    public function guestbooks() {
      
        return array();
    }

    /** 
     * 방명록 작성 및 수정
     * @access public
     * @Route("/guestbook/new", name="guestbook_new", methods={"POST"})
     * @Route("/guestbook/edit/{$id}", name="guestbook_edit", methods={"POST"})
     * @Template("/guestbook/write.twig")
     */
    public function writeGuestbook() {

        return array();
    }

    /** 
     * 방명록 삭제
     * @access public
     * @Route("/guestbook/delete/{$id}", name="guestbook_delete", methods={"DELETE"})
     */
    public function deleteGuestbook() {

        return array();
    }

    /** 
     * 방명록 댓글 작성 및 수정
     * @access public
     * @Route("/guestbook/comment/new", name="guestbook_cooment_new", methods={"POST"})
     * @Route("/guestbook/comment/edit/{$id}", name="guestbook_comment_edit", methods={"POST"})
     */
    public function writeComment() {

        return array();
    }
    /** 
     * 방명록 댓글 삭제
     * @access public
     * @Route("/guestbook/comment/delete/{$id}", name="guestbook_comment_delete", methods={"DELETE"})
     */
    public function deleteComment() {

        return array();
    }
}