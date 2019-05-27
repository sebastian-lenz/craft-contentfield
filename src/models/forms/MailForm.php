<?php

namespace lenz\contentfield\models\forms;

use Craft;
use craft\base\Element;
use craft\base\Model;
use craft\elements\User;
use craft\mail\Message;
use lenz\contentfield\models\BeforeActionInterface;
use lenz\contentfield\models\InstanceAwareInterface;
use lenz\contentfield\models\values\InstanceValue;
use lenz\contentfield\models\values\LinkValue;
use lenz\contentfield\models\values\ReferenceValue;
use yii\base\ActionEvent;

/**
 * Class MailForm
 */
class MailForm extends Model implements BeforeActionInterface, InstanceAwareInterface
{
  /**
   * @var int
   */
  private $_genericError = 0;

  /**
   * @var bool
   */
  private $_isSubmitted = false;

  /**
   * @var InstanceValue|null
   */
  private $_instance = null;

  /**
   * Possible generic errors.
   */
  const ERROR_INVALID_CSRF_TOKEN = -1;
  const ERROR_SEND_FAILED = -2;
  const ERROR_UNKNOWN = -3;
  const ERROR_VALIDATION_FAILED = -4;

  /**
   * Statically declares the sender of the mail, see MailForm::getMessageFrom.
   */
  const MESSAGE_FROM = null;

  /**
   * Statically declares the subject of the mail, see MailForm::getMessageSubject.
   */
  const MESSAGE_SUBJECT = null;

  /**
   * Statically declares the receiver of the mail, see MailForm::getMessageTo.
   */
  const MESSAGE_TO = null;

  /**
   * The name of the post parameter we should read attributes from.
   */
  const POST_PARAMETER = 'form';

  /**
   * A static url the user will be redirected to after form submission.
   */
  const REDIRECT_URL = null;


  /**
   * @return string
   */
  public function __toString() {
    $lines = array();

    foreach ($this->attributes as $attribute => $value) {
      if (empty($value)) continue;

      $lines[] = $this->getAttributeLabel($attribute) . ':';
      $lines[] = wordwrap($value);
      $lines[] = '';
    }

    return implode("\n", $lines);
  }

  /**
   * @return int
   */
  public function getGenericError(): int {
    return $this->_genericError;
  }

  /**
   * @return InstanceValue|null
   */
  public function getInstance() {
    return $this->_instance;
  }

  /**
   * @param ActionEvent $event
   * @return void
   */
  public function onBeforeAction(ActionEvent $event) {
    $request = Craft::$app->getRequest();
    if (!$request->isPost) {
      return;
    }

    $attributes = $request->getParam(static::POST_PARAMETER);
    if (is_null($attributes)) {
      return;
    }

    if (!$request->validateCsrfToken()) {
      $this->_genericError = self::ERROR_INVALID_CSRF_TOKEN;
      return;
    }

    try {
      $this->setAttributes($attributes);
      if (!$this->validate() ) {
        $this->_genericError = self::ERROR_VALIDATION_FAILED;
        return;
      }

      if (!$this->send()) {
        $this->_genericError = self::ERROR_SEND_FAILED;
        return;
      }

      $this->_isSubmitted = true;
      $event->isValid = !$this->redirect();
    } catch (\Throwable $error) {
      $this->_genericError = self::ERROR_UNKNOWN;
    }
  }

  /**
   * @inheritDoc
   */
  public function hasErrors($attribute = null) {
    if (is_null($attribute) && $this->hasGenericError()) {
      return true;
    }

    return parent::hasErrors($attribute);
  }

  /**
   * @return bool
   */
  public function hasGenericError(): bool {
    return $this->_genericError != 0;
  }

  /**
   * @return bool
   */
  public function isSubmitted(): bool {
    return $this->_isSubmitted;
  }

  /**
   * @param InstanceValue $instance
   * @return void
   */
  public function setInstance(InstanceValue $instance) {
    $this->_instance = $instance;
  }


  // Protected methods
  // -----------------

  /**
   * @return string|null
   */
  protected function getRedirectUrl() {
    $instance = $this->_instance;

    if (!is_null($instance) && isset($instance->redirect)) {
      $redirect = $instance->redirect;

      if ($redirect instanceof ReferenceValue) {
        $element = $redirect->getFirst();
        return $element ? $element->getUrl() : null;
      } elseif ($redirect instanceof LinkValue) {
        return $redirect->getUrl();
      }
    }

    return static::REDIRECT_URL;
  }

  /**
   * @return string|array|User|User[]
   */
  protected function getMessageFom() {
    if (!is_null(static::MESSAGE_FROM)) {
      return static::MESSAGE_FROM;
    }

    $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
    $mail = 'noreply@' . $host;
    $name = (string)Craft::$app->name;

    return [
      $mail => $name
    ];
  }

  /**
   * @return string
   */
  protected function getMessageSubject() {
    if (!is_null(static::MESSAGE_SUBJECT)) {
      return static::MESSAGE_SUBJECT;
    }

    $subject = 'Submission';

    if ($this->_instance) {
      $element = $this->_instance->getElement();

      if ($element && $element instanceof Element) {
        $subject .= ': ' . $element->title;
      }
    }

    return $subject;
  }

  /**
   * @return string|array|User|User[]
   */
  protected function getMessageTo() {
    if (!is_null(static::MESSAGE_TO)) {
      return static::MESSAGE_TO;
    }

    $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
    return 'info@' . $host;
  }

  /**
   * @return bool
   */
  protected function redirect() {
    $url = $this->getRedirectUrl();
    if (empty($url)) {
      return false;
    }

    Craft::$app->getResponse()->redirect($url);
    return true;
  }

  /**
   * @return bool
   */
  protected function send() {
    $options = [
      'from'     => $this->getMessageFom(),
      'subject'  => $this->getMessageSubject(),
      'to'       => $this->getMessageTo(),
      'textBody' => (string)$this,
    ];

    try {
      $message = new Message($options);
      return \Craft::$app->mailer->send($message);
    } catch (\Throwable $error) {
      return false;
    }
  }
}
