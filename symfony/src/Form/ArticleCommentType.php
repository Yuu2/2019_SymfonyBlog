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
class ArticleCommentType extends AbstractType {
  
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
    // 유저명
    ->add('username', TextType::class, [
      'constraints' => $this->getUsernameConstraints(),
      'attr' => [
        'placeholder' => $translator->trans('front.blog.article.comment.username'),
      ],
    ])

    // 공개여부
    ->add('visible', ChoiceType::class, [
      'choices' => [
        $translator->trans('front.blog.article.comment.visible.true')  => true,
        $translator->trans('front.blog.article.comment.visible.false') => false
      ],
      'constraints' => $this->getVisibleConstraints(),
    ])
    // 내용
    ->add('content', TextareaType::class, [ 
      'label' => $translator->trans('front.blog.article.comment.content'),
      'constraints' => $this->getContentConstraints(),
    ])
    ;
    
    if (!$this->security->isGranted('IS_AUTHENTICATED_FULLY')) {

      $builder
      // 패스워드
      ->add('password', PasswordType::class, [
        'constraints' => $this->getPasswordConstraints(),
        'required' => true,
        'attr' => [
          'placeholder' => $translator->trans('front.blog.article.comment.password'),
        ]
      ]);
    }
  }
  
  private function getArticleConstraints() {
    return;
  }
  private function getUsernameConstraints() {
    return;
  }
  private function getPasswordConstraints() {
    return;
  }
  private function getVisibleConstraints() {
    return;
  }
  private function getContentConstraints() {
    return;
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
