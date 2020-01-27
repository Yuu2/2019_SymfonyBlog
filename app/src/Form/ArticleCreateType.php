<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Board;
use KMS\FroalaEditorBundle\Form\Type\FroalaEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author yuu2
 * updated 2020.01.27
 */
class ArticleCreateType extends AbstractType {
  
  /**
   * @access public
   */
  public function __construct() {}

  /**
   * @access public
   * @param FormBuilderInterface $builder
   * @param array $options
   * @return void
   */
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
      ->add('title', TextType::class, array())
      ->add('content', FroalaEditorType::class, array())
      ->add('submit', SubmitType::class, array())
    ;
  }

  /**
   * @access public
   * @param OptionsResolver $resolver
   * @return void
   */
  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults([
      'data_class' => Article::class,
      'csrf_protection' => true
    ]);
  }
}
