<?php

namespace App\Form;

use App\Entity\ArticleComment;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Security\Core\Security;

/**
 * @author yuu2dev
 * updated 2020.08.19
 */
class ArticleCommentVerifyType extends AbstractType {
  
  /**
   * @var ParameterBagInterface
   */
  private $params;

  /**
   * @var TranslatorInterface
   */
  private $translator;

  /**
   * @var Security
   */
  private $security;

  /**
   * @access public
   * @param ParameterBagInterface $params
   * @param TranslatorInterface $translator
   * @param Security $security
   */
  public function __construct(ParameterBagInterface $params, TranslatorInterface $translator, Security $security) {
    $this->params = $params;
    $this->translator = $translator;
    $this->security = $security;
  }

  /**
   * @todo 유효성검사
   * @access public
   * @param FormBuilderInterface $builder
   * @param array $options
   * @return void
   */
  public function buildForm(FormBuilderInterface $builder, array $options) {
    
    $translator = $this->translator;

    $builder
    // 패스워드
    ->add('password', PasswordType::class, [
      'constraints' => $this->getPasswordConstraints(),
      'required' => true,
      'attr' => [
        'placeholder' => $translator->trans('front.blog.article.comment.password'),
      ]
    ])
    // 전송
    ->add('submit', SubmitType::class, [
      'label' => $translator->trans('front.blog.article.comment.verify.submit'),
    ])
    ;
  }

  
  /**
   * @access private
   */
  private function getPasswordConstraints() {
    return null;
  }

  /**
   * @access public
   * @param OptionsResolver $resolver
   * @return void
   */
  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults([
      'csrf_protection' => true,
      'data_class' => ArticleComment::class,
    ]);
  }
}
