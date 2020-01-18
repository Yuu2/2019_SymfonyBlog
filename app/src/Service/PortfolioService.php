<?php

namespace App\Service;

use App\Repository\PortfolioRepository;

/**
 * @author Yuu2
 * updated 2020.01.18
 */
class PortfolioService extends AbstractService {

  /**
   * @var PortfolioRepository
   */
  private $portfolioRepository;

  /**
   * @access public
   * @param PortfolioRepository $portfolioRepository
   */
  public function __construct(PortfolioRepository $portfolioRepository) {
    $this->portfolioRepository = $portfolioRepository;
  }

  /**
   * @access public
   * @return array
   */
  public function all(): ?array {
    return $this->portfolioRepository->findAll();
  }
}