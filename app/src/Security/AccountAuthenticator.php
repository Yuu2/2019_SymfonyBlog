<?php

namespace App\Security;

use App\Entity\Account;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

/**
 * 2019.10.20
 * @author Yuu2
 */
class AccountAuthenticator extends AbstractFormLoginAuthenticator {

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
    private $encoder;

    /**
     * @access public
     * @param EntityManagerInterface $entityManager
     * @param UrlGeneratorInterface $urlGenerator
     * @param CsrfTokenManagerInterface $csrfTokenManager
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(
        EntityManagerInterface $entityManager, 
        UrlGeneratorInterface $urlGenerator, 
        CsrfTokenManagerInterface $csrfTokenManager,
        UserPasswordEncoderInterface $encoder
    ) {
        $this->entityManager = $entityManager;
        $this->urlGenerator = $urlGenerator;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->encoder = $encoder;
        
    }

    /**
     * @access public
     * @param Request $request
     */
    public function getCredentials(Request $request) {
     
        $credentials = [
            'email' => $request->request->get('email'),
            'password' => $request->request->get('password'),
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
     * @param Request $request
     */
    public function supports(Request $request) {
        return 'account_signin' === $request->attributes->get('_route') && $request->isMethod('POST');
    }

    /**
     * [유저정보 취득]
     * @access public
     */
    public function getUser($credentials, UserProviderInterface $userProvider) {

        $token = new CsrfToken('authenticate', $credentials['csrf_token']);
        
        if (!$this->csrfTokenManager->isTokenValid($token)) { 
            throw new InvalidCsrfTokenException("유효하지 않은 토큰입니다."); 
        }

        $user = $this->entityManager->getRepository(Account::class)->findOneBy(['email' => $credentials['email']]);

        if (!$user) { 
            throw new CustomUserMessageAuthenticationException('존재하지 않는 이메일 입니다.'); 
        }

        return $user;
    }

    /**
     * [인증 검사]
     * @access public
     */
    public function checkCredentials($credentials, UserInterface $user) {
        return $this->encoder->isPasswordValid($user, $credentials['password']);
    }

    /**
     * [인증 성공]
     * @access public
     * @param Request $request
     * @param TokenInterface $token
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey) {

        if ($targetPath = $this->getTargetPath($request->getSession(), $providerKey)) {
            return new RedirectResponse($targetPath);
        }
    }

    protected function getLoginUrl() {
        return $this->urlGenerator->generate('account_signin');
    }
}
