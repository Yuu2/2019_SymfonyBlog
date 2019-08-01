<?php 
namespace App\Service;

use App\Entity\Account;
use Doctrine\ORM\EntityManagerInterface;
use ReCaptcha\ReCaptcha;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\Session\Session;

// TODO: 에러기능 수정필요!!
class AccountService {

  /**
   * @var EntityManagerInterface
   */
    protected $entityManager;
    public $error;
  /**
   * @param EntityManagerInterface $entityManager;
   */
  public function __construct($entityManager) {
    $this->entityManager = $entityManager;
  }

  public function execute($action, $request, $form_data, $secret_key) {
    $recaptcha = new ReCaptcha($secret_key);
    $recaptcha_result = $recaptcha->verify($request->request->get('g-recaptcha-response'), $request->getClientIp())->isSuccess();

    // if(!$recaptcha_result) {
    //  $this->setRecaptchaError($recaptcha_result); return; 
    // }

    switch($action) {
      case "signin":
        $this->account_signin($form_data); break;
      case "signup" : 
        $this->account_signup($form_data); break;
      case "signout" : 
        $this->account_signout(); break;
    }
  }
  /* ----------------------------------------- */
  private function account_signin($form_data) {
    $account_result = $this->entityManager->getRepository(Account::class)->findBy($form_data);
    
    if(empty($account_result)) {
      $this->setSignInError($account_result);
      return;
    }

    $session = new Session();

    $session->set('id', $account_result[0]->getId());
    $session->set('email', $account_result[0]->getEmail());
    $session->set('created_at', new \DateTime());
  }

  private function account_signup($form_data) {

    $account = new Account();

    foreach($form_data as $key => $value) {
      switch($key) {
        case "email": $account->setEmail($value); break;
        case "password": $account->setPassword($value); break;
        case "username": $account->setUsername($value); break;
        case "birth": $account->setBirth($value); break;
    }}
    $account->setCreatedAt(new \DateTime());

    $entityManager = $this->entityManager;
    $entityManager->persist($account);
    $entityManager->flush();
  }
  public function account_signout() {
    $session = new Session();
    $session->remove('email');
  }
  /* ----------------------------------------- */
  // TODO:
  // 상수로 에러 서비스를 구현 할 예정. 

  private function setSignInError($account_result) {
    empty($account_result) ? $this->error = '存在していないユーザです。 改めてログインお願いします。' : $this->error = null;
  }

  private function setRecaptchaError($recaptcha_result) {
    $recaptcha_result ? $this->error = null : $this->error = 'ロボットではないことを証明してください。';
  }
}
?>