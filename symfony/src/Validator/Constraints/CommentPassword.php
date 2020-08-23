<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @Annotation
 */
class CommentPassword extends Constraint {

  /**
   * @var Transtatlor
   */
  private $translator;

  /**
   * @var string
   */
  public $message;

  

  /**
   * @access public
   * @param TranslatorInterface $translator
   */
  public function __construct(TranslatorInterface $translator) {
    $this->translator = $translator;
    $this->message = $this->translator->trans('assert.blog.article.comment.password.invalid');
  }



}