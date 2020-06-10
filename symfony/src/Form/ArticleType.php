<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author yuu2dev
 * updated 2020.06.10
 */
class ArticleType extends AbstractType {
  
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
      // 제목
      ->add('title', TextType::class, array(  
        'label' => $translator->trans('front.blog.article.title')
      ))

      // 내용
      ->add('content', CKEditorType::class, array(
        'label' => false
      ))

      // 공개여부
      ->add('visible', ChoiceType::class, array(
        'choices' => [
          $translator->trans('front.blog.article.visible.true')  => TRUE,
          $translator->trans('front.blog.article.visible.false') => FALSE
        ],
        
        'label' => $translator->trans('front.blog.article.visible')
      ))

      // 카테고리
      ->add('category', EntityType::class, array(
        'choice_label' => function(Category $category) {
          return $category->getTitle();
        },
        'class' => Category::class,
        'label' => $translator->trans('front.blog.article.category')
      ))

      // 해시태그
      ->add('hashtag', HiddenType::class, array(
        'required' => false,
        'mapped'   => false,
      ))
    ;
  }

  /**
   * @access public
   * @param OptionsResolver $resolver
   * @return void
   */
  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults([
      'csrf_protection' => true,
      'data_class' => Article::class,
    ]);
  }
}
