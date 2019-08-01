<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType {
  
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('title', TextType::class, array(
              'label' => '題名',
              'attr'  => [ 'placeholder' => 'タイトルを入力してください (100文字)' ]
            ))
            ->add('content', TextareaType::class, array(
              'label' => '内容',
              'attr'  => [ 'placeholder' => '本文を記載してください (1000文字)' ]
            ));
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
