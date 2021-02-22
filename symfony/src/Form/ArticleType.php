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
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @author yuu2dev
 * updated 2020.07.04
 */
class ArticleType extends AbstractType {
  
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
   * @access public
   * @param FormBuilderInterface $builder
   * @param array $options
   * @return void
   */
  public function buildForm(FormBuilderInterface $builder, array $options) {
    
    $translator = $this->translator;

    $builder
      // 제목
      ->add('title', TextType::class, [ 
        'label' => $translator->trans('front.blog.article.title'),
        'constraints' => $this->getTitleConstraints(),
      ])

      // 내용
      ->add('content', CKEditorType::class, [
        'label'  => false,
        'config' => [
          'toolbar'  => 'full',
          'required' => true,
          'extraPlugins' => 'codesnippet', 
          'codeSnippet_theme' =>'monokai_sublime'
        ],
        'plugins' => [
          'codesnippet' => [
            'path' => $this->params->get("ckeditor_plugins_dir") . "codesnippet/",
            'filename' => 'plugin.js'
          ]
        ],
        'constraints' => $this->getContentConstraints(),
      ])

      // 공개여부
      ->add('visible', ChoiceType::class, [
        'choices' => [
          $translator->trans('front.blog.article.visible.true')  => true,
          $translator->trans('front.blog.article.visible.false') => false
        ],
        'label' => $translator->trans('front.blog.article.visible'),
        'constraints' => $this->getVisibleConstraints(),
      ])

      // 카테고리
      ->add('category', EntityType::class, [
        'choice_label' => function(Category $category) {
          return $category->getTitle();
        },
        'class' => Category::class,
        'label' => $translator->trans('front.blog.article.category'),
        'constraints' => $this->getCategoryConstraints(),
      ])

      // 해시태그
      ->add('hashtag', HiddenType::class, [
        'required' => false,
        'mapped'   => false,
      ])
    ;
  }

  /**
   * @access private
   * @return array
   */
  private function getTitleConstraints(): array {
    return [
      new Assert\NotBlank([
        'message' => 'assert.blog.article.title.blank'
      ]),
      new Assert\Length([
        'min'        => 1,
        'max'        => 40,
        'minMessage' => 'assert.blog.article.title.length.min',
        'maxMessage' => 'assert.blog.article.title.length.max'
      ]),
    ];
  }

  /**
   * @access private
   */
  private function getContentConstraints(): array {
    return [
      new Assert\NotBlank([
        'message' => 'assert.blog.article.content.blank'
      ])
    ];
  }

  /**
   * @access private
   */
  private function getVisibleConstraints(): array {
    return [
      new Assert\NotBlank([
        'message' => 'assert.blog.article.visible.blank'
      ]),
      new Assert\Type([
        'type'    => 'bool',
        'message' => 'assert.blog.article.visible.type'
      ]),
    ];
  }

  /**
   * @access private
   */
  private function getCategoryConstraints(): array {
    return [
      new Assert\NotBlank([
        'message' => 'assert.blog.article.category.blank'
      ])
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
      'data_class' => Article::class,
    ]);
  }
}
