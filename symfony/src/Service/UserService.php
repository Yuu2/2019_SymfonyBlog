<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @author yuu2dev
 * updated 2020.06.19
 */
class UserService {

  /**
   * @var ContainerInterface
   */
  private $container;

  /**
   * @var LoggerInterface
   */
  private $logger;

  /**
   * @var EntityManagerInterface
   */
  protected $entityManager;
 
  /**
   * @var UserPasswordEncoderInterface
   */
  protected $passwordEncoder;

  /**
   * @var UserRepository
   */
  protected $userRepository;

  /**
   * @access public
   * @param ContainerInterface $container
   * @param EntityManagerInterface $entityManager
   * @param UserRepository $userRepository
   * @param UserPasswordEncoderInterface $passwordEncoder
   * @param LoggerInterface $logger
   */
  public function __construct(ContainerInterface $container, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder, UserRepository $userRepository, LoggerInterface $logger) {
    $this->container = $container;
    $this->entityManager = $entityManager;
    $this->passwordEncoder = $passwordEncoder;
    $this->userRepository = $userRepository;
  }
  
  /**
   * @access public
   * @param User $user
   * @return void
   */
  public function saveUser(User $user) {

    $encryptedPw = $this->passwordEncoder->encodePassword($user, $user->getPassword());
    
    $user->setPassword($encryptedPw);
    $user->setRoles(['ROLE_USER']);
    $user->setCreatedAt(new \DateTime);

    $this->entityManager->persist($user);
    $this->entityManager->flush();
  }

  /**
   * 썸네일 파일 업로드
   * @todo monolog
   * @access public
   * @param File $thumbnail
   * @return string
   */
  public function saveThumbnail($thumbnail): ?string {
    
    $thumbnail_src = null;
    
    if ($thumbnail) {

      try {

        $thumbnail_src = pathinfo($thumbnail->getClientOriginalName(), PATHINFO_FILENAME) . '-' . uniqid() . '.' . $thumbnail->guessExtension();
        $thumbnail->move($this->container->getParameter('upload_dir'), $thumbnail_src);
      
      } catch (\FileException $fe) {

        $thumbnail_src = null;
      }
    }
    return $thumbnail_src;
  }

  /**
   * @todo 유저 중복 검사
   * @access public
   * @param string $_email
   * @return bool
   */
  public function isDuplicatedEmail(?string $_email) : bool {
    
    if (is_null($_email)) {
      return false;
    } else {
      $email = $this->userRepository->findOneBy(['email' => $_email]);
    }

    return $email ? true : false;
  }
}
