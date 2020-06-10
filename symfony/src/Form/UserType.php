<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Profile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
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
 * updated 2020.06.10
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

      ->add('email', EmailType::class, array(
        'label' => $translator->trans('front.member.register.email'),
        'required' => true,
      ))

      ->add('password', RepeatedType::class, array(
        'type' => PasswordType::class,
        'invalid_message' => $translator->trans('front.member.register.password.err'),
        'first_options'  => [
          'help' => $translator->trans('front.member.register.password1.help'),
          'label' => $translator->trans('front.member.register.password1'),
        ],
        'second_options' => [
          'help' => $translator->trans('front.member.register.password2.help'),
          'label' => $translator->trans('front.member.register.password2'),
        ],
        'required' => true,
      ))

      ->add('name', TextType::class, array(
        'label' => $translator->trans('front.member.register.name'),
        'mapped' => false,
        'required' => false
      ))

      ->add('thumbnail', FileType::class, array(
        'constraints' => [
          new File([
              'maxSize' => '5120k',
              'mimeTypes' => [
                  'image/png',
                  'image/jpg',
                  'image/jpeg'
              ],
          ])
        ],
        'help' => $translator->trans('front.member.register.thumbnail.help'),
        'mapped' => false,
        'required' => false,
      ))

      ->add('submit', SubmitType::class, array(
        'label' => $translator->trans('front.member.register.submit')
      ));
    ;
  }

  /**
   * @access public
   * @param OptionResolver $resolver
   * @return void
   */
  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults([
      'csrf_protection' => true,
      'data_class' => User::class
    ]);
  }
}
