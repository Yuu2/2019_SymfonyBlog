<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class CommentPasswordValidator extends ConstraintValidator {

  /**
   * @access public
   */
  public function __construct() {}

  /**
   * @access public
   * @param
   * @param Constraint $constraint
   */
  public function validate($value, Constraint $constraint) {

    if (!$constraint instanceof ConstraintPassword) {
      throw new UnexpectedTypeException($constraint, ConstraintPassword::class);
    }

    // password_verify($value, $comment->getPassword())
  }
}