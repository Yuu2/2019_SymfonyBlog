<?php 

namespace App\Utils;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class FlashUtils {
    
    private const SUCCESS = 'success';
    private const FAILED  = 'failed';

    /**
     * @var FlashBagInterface
     */
    private $flashBag;
        
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @access public
     * @param FlashBagInterface $flashBag
     * @param TranslatorInterface $translator
     * @return void
     */
    public function __construct(FlashBagInterface $flashBag, TranslatorInterface $translator) {
        $this->flashBag = $flashBag;
        $this->translator = $translator;
    }
    
    /**
     * @access public
     * @param string $status
     * @param string $key
     * @return void
     */
    public function msg(string $status, string $key) {
        $this->flashBag->add($status, $this->translator->trans($key));
    }
    
    /**
     * @access public
     * @param string $key
     * @return void
     */
    public function success(string $key) {
        $this->msg('success', $key);
    }

    /**
     * @access public
     * @param string $key
     * @return void
     */
    public function failed(string $key) {
        $this->msg('danger', $key);
    }

    /**
     * @access public
     * @param string $key
     * @return void
     */ 
    public function info(string $key) {
        $this->msg('info', $key);
    }

    /**
     * 성공 또는 실패 를 가리키는 축약형 메시지.
     * @access public
     * @param string $isCollect
     * @param string $successKey
     * @param string $failedKey
     * @return void
     */
    public function whether(bool $isCollect, string $key) {
        $success = ".".self::SUCCESS;
        $failed  = ".".self::FAILED;

        $key = str_replace([$success, $failed], "", $key);

        $isCollect ? $this->success($key.$success) : $this->failed($key.$failed);
    }
    
}