<?php

namespace App\Validator\Constraints;

use App\Validator\Constraints\CommentPassword;
use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CommentPassword extends Constraint {

  /**
   * @var string
   */
  public $message;

  /**
   * @var ArticleComment
   */
  public $comment;

  /**
   * @access public
   * @param array
   */
  public function __construct(array $argument) {
    parent::__construct();

    $this->message = isset($argument['message']) ? $argument['message'] : null;
    $this->comment = isset($argument['comment']) ? $argument['comment'] : null;
  }
}