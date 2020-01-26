<?php

namespace App\Tests;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @author yuu2
 * updated 2020.01.26
 */
class AccessTest extends WebTestCase {

  /**
   * @access public
   */
  public function setUp() {
    
    parent::setUp();
    
  }

  /**
   * @access public
   */
  public function test() {
    
    $client = static::createClient(array(), array(
      'PHP_AUTH_USER' => 'admin@yuu2.dev',
      'PHP_AUTH_PW'   => 'admin',
    ));

    $clawler = $client->request('GET', '/admin/config');

    $crawler = $client->followRedirect();

    $this->assertSame(200, $client->getResponse()->getStatusCode());
  }

  /**
   * 관리자 페이지 목록
   * @access private
   */
  private function getAdminUrls() {
      yield array('/admin/config');
  }
}