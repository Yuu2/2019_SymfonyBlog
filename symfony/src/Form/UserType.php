<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Profile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author yuu2dev
 * updated 2020.06.16
 */
class UserType extends AbstractType {
  
  /**
   * @var TranslatorInterface
   */
  private $translator;

  /**
   * @access public
   * @param TranslatorInterface $translator
   */
  public function __construct(TranslatorInterface $translator) {
    $this->translator = $translator;
  }
  
  /**
   * @access public
   * @param FormBuilderInterface $builder
   * @param array $options
   * @return void
   */
  public function buildForm(FormBuilderInterface $builder, array $options) {
    
    $translator = $this->translator;

    $builder

      // 이메일
      ->add('email', EmailType::class, array(
        'label' => $translator->trans('front.user.signup.email'),
        'required' => true,
      ))

      // 이메일 확인
      ->add('check_email', HiddenType::class, array(
        // 'constraints'    => $this->getEmailCheckConstraints(),
        'error_bubbling' => false,
        'empty_data'     => false,
        'mapped'         => false,
        'required'       => true,
      ))

      ->add('check_email_btn', ButtonType::class, array(
        'label' => $translator->trans('front.user.signup.email.check'),
        'attr' => array(
          'class' => 'btn-outline-primary btn-sm'
        )
      ))

      // 패스워드
      ->add('password', RepeatedType::class, array(
        'type' => PasswordType::class,
        'invalid_message' => $translator->trans('front.user.signup.password.invalid'),
        'first_options'  => array(
          'help' => $translator->trans('front.user.signup.password.help'),
          'label' => $translator->trans('front.user.signup.password'),
          'constraints' => $this->getPasswordConstraints()
        ),
        'second_options' => array(
          'help' => $translator->trans('front.user.signup.password.confirm.help'),
          'label' => $translator->trans('front.user.signup.password.confirm'),
          'constraints' => $this->getPasswordConstraints() 
        ),
        'required' => true,
      ))

      // 닉네임
      ->add('alias', TextType::class, array(
        'help' => $translator->trans('front.user.signup.alias.help'),
        'label' => $translator->trans('front.user.signup.alias'),
        'required' => true
      ))

      // 썸네일
      ->add('thumbnail', FileType::class, array(
        'constraints' => $this->getThumbnailConstraints(),
        'help' => $translator->trans('front.user.signup.thumbnail.help'),
        'required' => false,
      ))
      
      // 전송
      ->add('submit', SubmitType::class, array(
        'label' => $translator->trans('front.user.signup.submit')
      ));
    ;
  }

  /**
   * @access private
   * @return array
   */
  private function getEmailCheckConstraints(): ?array{
    return array(
      new Assert\IsTrue(array(
        'message' => 'assert.user.email.check'
      ))
    );
  }

  /**
   * @access private
   * @return array
   */
  private function getPasswordConstraints(): ?array {
    return array(
      new Assert\Length(array(
        'min'        => 8,
        'max'        => 20,
        'minMessage' => 'assert.user.password.length.min',
        'maxMessage' => 'assert.user.password.length.max'
      )),
      new Assert\Regex(array(
        'pattern' => '/^[\W]{8, 20}$/',
        'match'   => false,
        'message' => 'assert.user.password.regex'
      )),
    );
  }
  
  /**
   * @access private
   * @return array
   */
  private function getThumbnailConstraints(): ?array {
    return array(
      new Assert\File(array(
        'maxSize' => '5000000',
        'maxSizeMessage' => 'assert.user.thumbnail.size.max',
        'mimeTypes' => array('image/png', 'image/jpg', 'image/jpeg'),
        'mimeTypesMessage' => 'assert.user.thumbnail.mimetype',
      ))
    );
  }

  /**
   * @access public
   * @param OptionResolver $resolver
   * @return void
   */
  public function configureOptions(OptionsResolver $resolver) {
    
    $resolver->setDefaults([
      'csrf_protection' => true,
      'data_class'      => User::class
    ]);
  }
}
