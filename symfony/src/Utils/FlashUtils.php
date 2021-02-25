<?php 

namespace App\Utils;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class FlashUtils {
        
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
     * @param string $key
     * @param string $type
     * @return void
     */
    public function msg(string $key, string $type = 'success') {
        $this->flashBag->add($type, $this->translator->trans($key));
    }

    
    
}