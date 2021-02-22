<?php

namespace App\Form;

use App\Entity\ArticleComment;
use App\Validator\Constraints\CommentPassword;
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
 * updated 2020.08.28
 */
class ArticleCommentCertType extends AbstractType {
  
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
  
    /** @var ArticleComment */
    $comment = $options['comment'];
    
    $builder
    // 패스워드
    ->add('password', PasswordType::class, [
      'attr' => [
        'placeholder' => $this->translator->trans('front.blog.article.comment.password'),
      ],
      'constraints' => $this->getCommentPasswordConstraints($comment),
      'empty_data' => '',
      'required' => true,
      'mapped' => false
    ])
    // 전송
    ->add('submit', SubmitType::class, [
      'label' => $this->translator->trans('front.blog.article.comment.cert.submit'),
    ]);
  }

  
  /**
   * @access private
   * @param ArticleComment $comment
   * @return array
   */
  private function getCommentPasswordConstraints(ArticleComment $comment): array {
    return [
      new Assert\NotBlank([
        'message' => $this->translator->trans('assert.blog.article.comment.password.blank')
      ]),
      new CommentPassword([
        'message' => $this->translator->trans('assert.blog.article.comment.password.invalid'),
        'comment' => $comment
      ]),
    ];
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
      'comment' => null
    ]);
  }
}
