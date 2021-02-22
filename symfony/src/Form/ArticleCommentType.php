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
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\Translation\TranslatorInterface;
/**
 * @author yuu2dev
 * updated 2020.09.01
 */
class ArticleCommentType extends AbstractType {
  
  /**
   * @access public
   */
  public const BRANCH_NEW  = 'NEW';
  
  /**
   * @access public
   */
  public const BRANCH_EDIT = 'EDIT';
  
  /**
   * @access public
   */
  public const BRANCH_DEL = 'DEL';

  /**
   * @access public
   */
  public const BRANCH_ANSWER = 'ANSWER';

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
    
    /** @var string */
    $branch = $options['branch'];
    
    switch ($branch) {
      case 'NEW'   : 
        $this->buildNewForm($builder); 
      break;
      case 'EDIT'  : 
        $this->buildEditForm($builder); 
      break;
    }
  }
  /**
   * @access private
   * @param FormBuilderInterface $builder
   * @return void
   */
  private function buildNewForm(FormBuilderInterface $builder) : void {
    $builder
    // 유저명
    ->add('username', TextType::class, [
      'constraints' => $this->getUsernameConstraints(),
      'attr' => [
        'placeholder' => $this->translator->trans('front.blog.article.comment.username'),
      ],
    ])
    // 공개여부
    ->add('visible', ChoiceType::class, [
      'choices' => [
        $this->translator->trans('front.blog.article.comment.visible.true')  => true,
        $this->translator->trans('front.blog.article.comment.visible.false') => false
      ],
      'constraints' => $this->getVisibleConstraints(),
    ])
    // 내용
    ->add('content', TextareaType::class, [ 
      'label' => $this->translator->trans('front.blog.article.comment.content'),
      'constraints' => $this->getContentConstraints(),
    ]);
    // 패스워드
    if (!$this->security->isGranted('IS_AUTHENTICATED_FULLY')) {
      $builder
      ->add('password', PasswordType::class, [
        'constraints' => $this->getPasswordConstraints(),
        'required' => true,
        'empty_data' => '',
        'attr' => [
          'placeholder' => $this->translator->trans('front.blog.article.comment.password'),
        ]
      ]);
    }
    // 전송
    $builder->add('submit', SubmitType::class, [
      'label' => $this->translator->trans('front.blog.article.comment.new.submit'),
    ]);
  }

  /**
   * @access private
   * @param FormBuilderInterface $builder
   * @return void
   */
  private function buildEditForm(FormBuilderInterface $builder) : void{
    $builder
    // 내용
    ->add('content', TextareaType::class, [ 
      'label' => $this->translator->trans('front.blog.article.comment.content'),
      'constraints' => $this->getContentConstraints(),
    ])
    // 공개여부
    ->add('visible', ChoiceType::class, [
      'choices' => [
        $this->translator->trans('front.blog.article.comment.visible.true')  => true,
        $this->translator->trans('front.blog.article.comment.visible.false') => false
      ],
      'constraints' => $this->getVisibleConstraints(),
      'label' => $this->translator->trans('front.blog.article.comment.visible'),
    ]);
    // 전송
    $builder->add('submit', SubmitType::class, [
      'label' => $this->translator->trans('front.blog.article.comment.edit.submit'),
    ]);
  }
  
  private function getIdConstraints() {
    return;
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
      'branch' => null,
      'parent' => null
    ]);
  }
}
