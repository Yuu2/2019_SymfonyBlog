<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

/**
 * @author yuu2dev
 * updated 2020.08.15
 */
class FlashEvent extends Event {

  public const SIGNUP_EMAIL_CONFIRM = "flash.front.user.signup.email.confirm";
  public const SIGNUP_EMAIL_INVALID = "flash.front.user.signup.email.invalid";
  public const SIGNUP_EMAIL_VERIFIED = "flash.front.user.signup.email.verified";
  public const SIGNUP_RECAPTCHAR_FAILED = "flash.front.user.signup.recaptcha.failed";
  public const BLOG_ARTICLE_WRITE_SUCCESS = "flash.front.blog.article.write.success";
  public const BLOG_ARTICLE_WRITE_FAILED = "flash.front.blog.article.write.failed";
  public const BLOG_ARTICLE_INVISIBLE = "flash.front.blog.article.invisible";
  public const BLOG_ARTICLE_COMMENT_WRITE_SUCCESS = "flash.front.blog.article.comment.write.success";
  public const BLOG_ARTICLE_COMMENT_WRITE_FAILED = "flash.front.blog.article.comment.write.failed";
  public const BLOG_ARTICLE_COMMENT_DEL_SUCCESS = "flash.front.blog.article.comment.del.success";
  public const BLOG_ARTICLE_COMMENT_DEL_FAILED = "flash.front.blog.article.comment.del.failed";
  public const BLOG_ARTICLE_COMMENT_DEL_PASSWORD_INVALID = "flash.front.blog.article.comment.del.password.invalid";
}