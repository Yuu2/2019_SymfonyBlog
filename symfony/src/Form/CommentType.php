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

/**
 * @author yuu2dev
 * updated 2020.08.01
 */
class CommentType extends AbstractType {
  
  /**
   * @var ParameterBagInterface $params
   */
  private $params;

  /**
   * @var TranslatorInterface
   */
  private $translator;

  /**
   * @access public
   * @param ParameterBagInterface $params
   * @param TranslatorInterface $translator
   */
  public function __construct(ParameterBagInterface $params, TranslatorInterface $translator) {
    $this->params = $params;
    $this->translator = $translator;
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
        'label' => $translator->trans('front.blog.article.comment.username'),
        'constraints' => $this->getUsernameConstraints(),
        'required' => false
      ])
      // 비밀번호
      ->add('password', PasswordType::class, [
        'label' => $translator->trans('front.blog.article.comment.password'),
        'constraints' => $this->getPasswordConstraints(),
        'required' => true
      ])
      // 공개여부
      ->add('visible', ChoiceType::class, [
        'choices' => [
          $translator->trans('front.blog.article.comment.visible.true')  => true,
          $translator->trans('front.blog.article.comment.visible.false') => false
        ],
        'label' => $translator->trans('front.blog.article.comment.visible'),
        'constraints' => $this->getVisibleConstraints(),
      ])
      // 내용
      ->add('content', TextareaType::class, [ 
        'label' => $translator->trans('front.blog.article.comment.content'),
        'constraints' => $this->getContentConstraints(),
      ])
    ;
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
