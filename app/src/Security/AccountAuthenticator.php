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
     * @access public
     * @param EntityManagerInterface $entityManager
     * @param UrlGeneratorInterface $urlGenerator
     * @param CsrfTokenManagerInterface $csrfTokenManager
     */
    public function __construct(
        EntityManagerInterface $entityManager, 
        UrlGeneratorInterface $urlGenerator, 
        CsrfTokenManagerInterface $csrfTokenManager
    ) {
        $this->entityManager = $entityManager;
        $this->urlGenerator = $urlGenerator;
        $this->csrfTokenManager = $csrfTokenManager;
    }

    /**
     * 인증처리
     * @access public
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
     */
    public function supports(Request $request) {
        return 'account_signin' === $request->attributes->get('_route') && $request->isMethod('POST');
    }

    /**
     * @access public
     */
    public function getUser($credentials, UserProviderInterface $userProvider) {
        $token = new CsrfToken('authenticate', $credentials['csrf_token']);
        
        if (!$this->csrfTokenManager->isTokenValid($token)) { throw new InvalidCsrfTokenException(); }

        $user = $this->entityManager->getRepository(Account::class)->findOneBy(['email' => $credentials['email']]);

        if (!$user) { throw new CustomUserMessageAuthenticationException('존재하지 않는 이메일 입니다.'); }

        return $user;
    }

    /**
     * @access public
     */
    public function checkCredentials($credentials, UserInterface $user) {

        throw new \Exception('인증 처리 실패:  '.__FILE__);
    }

    /**
     * @access public
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey) {
        if ($targetPath = $this->getTargetPath($request->getSession(), $providerKey)) {
            return new RedirectResponse($targetPath);
        }
        throw new \Exception('옳바르지 않은 리다이렉트 처리: '.__FILE__);
    }

    protected function getLoginUrl() {
        return $this->urlGenerator->generate('account_signin');
    }
}
