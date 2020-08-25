<?php

namespace App\Validator\Constraints;

use App\Validator\Constraints\CommentPassword;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @author yuu2dev
 * updated 2020.08.25
 */
class CommentPasswordValidator extends ConstraintValidator {

  /**
   * @var EntityManagerInterface
   */
  private $entityManager;

  /**
   * @access public
   * @param EntityManagerInterface $entityManager
   */
  public function __construct(EntityManagerInterface $entityManager) {
    $this->entityManager = $entityManager;
  }

  /**
   * @access public
   * @param $value
   * @param Constraint $constraint
   * @return void
   */
  public function validate($value, Constraint $constraint): void {

    // 비어있을 경우 리턴
    if (empty(trim($value))) {
      return;
    }

    if (!$constraint instanceof CommentPassword) {
      throw new UnexpectedTypeException($constraint, CommentPassword::class);
    }

    // 패스워드 불일치 시 유효성 검증 실패
    if (!password_verify($value, $constraint->comment->getPassword())) {
      $this->context->buildViolation($constraint->message)->addViolation();
    }
  }
}