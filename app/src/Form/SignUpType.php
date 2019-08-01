<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SignUpType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('email', EmailType::class, array(
              'label' => 'E-mail',
              'attr'  => ['placeholder' => '使用しているメールを入力してください。']
            ))
            ->add('username', TextType::class, array(
              'label' => 'Name',
              'attr'  => ['placeholder' => '希望するネーム']
            ))
            ->add('password', PasswordType::class, array(
              'label' => 'パスワード',
              'attr'  => ['placeholder' => '希望するパスワード']
            ))
            ->add('password_confirm', PasswordType::class, array(
              'label' => '再確認パスワード',
              'attr'  => ['placeholder' => '入力したパスワードを再確認']
            ))
            ->add('birth', DateType::class, array(
              'label' => '誕生日',
              'widget' => 'single_text',
              'html5' => true,
              'required' => true,
              'attr' => [
                         'class' => 'form-control input-inline datetimepicker',
                         'data-provide' => 'datetimepicker',
                         'data-format'  => 'dd-mm-yyyy'
                        ]
            ));
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
