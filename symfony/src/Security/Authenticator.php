<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

/**
 * @author yuu2
 * updated 2020.01.27
 */
class Authenticator extends AbstractFormLoginAuthenticator {

  use TargetPathTrait;

  /**
   * @var EntityManagerInterface
   */
  private $entityManager;
  
  /**
   * @var UrlGeneratorInterface
   */
  private $urlGenerator;
  
  /**
   * @var CsrfTokenManagerInterface
   */
  private $csrfTokenManager;

  /**
   * @var UserPasswordEncoderInterface
   */
  private $passwordEncoder;

  /**
   * @access public
   * @param EntityManagerInterface $entityManager
   * @param UrlGeneratorInterface $urlGenerator, 
   * @param CsrfTokenManagerInterface $csrfTokenManager
   * @param UserPasswordEncoderInterface $passwordEncoder
   */
  public function __construct(
    EntityManagerInterface $entityManager, 
    UrlGeneratorInterface $urlGenerator, 
    CsrfTokenManagerInterface $csrfTokenManager, 
    UserPasswordEncoderInterface $passwordEncoder
  ) {
    $this->entityManager = $entityManager;
    $this->urlGenerator = $urlGenerator;
    $this->csrfTokenManager = $csrfTokenManager;
    $this->passwordEncoder = $passwordEncoder;
  }

  /**
   * @access public
   * @param Request $request
   * @return bool
   */
  public function supports(Request $request): bool {
    
    return 'member_login' === $request->attributes->get('_route') && $request->isMethod('POST');
  }

  /**
   * @access public
   * @param Request $request
   */
  public function getCredentials(Request $request) {
    
    $credentials = [
      'email' => $request->request->get('_email'),
      'password' => $request->request->get('_password'),
      'csrf_token' => $request->request->get('_csrf_token'),
    ];
    
    $request->getSession()->set(
      Security::LAST_USERNAME,
      $credentials['email']
    );

    return $credentials;
  }

  /**
   * @access public
   * @param array $credentials
   * @param UserProviderInterface $userProvider
   */
  public function getUser($credentials, UserProviderInterface $userProvider) {
    
    $token = new CsrfToken('authenticate', $credentials['csrf_token']);
    
    if(!$this->csrfTokenManager->isTokenValid($token))
    throw new CustomUserMessageAuthenticationException('security.user.csrf');
    

    $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $credentials['email']]);

    if(!$user)
    throw new CustomUserMessageAuthenticationException('security.user.notfound');
    
    return $user;
  }

  /**
   * @access public
   * @param array $credentials
   * @param UserInterface $user
   */
  public function checkCredentials($credentials, UserInterface $user) {
    return $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
  }

  /**
   * @access public
   */
  public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey) {
    
    if($targetPath = $this->getTargetPath($request->getSession(), $providerKey)) {
      return new RedirectResponse($targetPath);
    }

    return new RedirectResponse($this->urlGenerator->generate('blog_index'));
  }

  /**
   * @access public
   */
  protected function getLoginUrl() {
    return $this->urlGenerator->generate('member_login');
  }
}
