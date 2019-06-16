<?php

namespace lenz\contentfield\models\forms;

use Craft;
use craft\base\Element;
use craft\elements\User;
use craft\mail\Message;
use lenz\contentfield\events\BeforeActionEvent;
use Throwable;

/**
 * Class MailForm
 */
class MailFormModel extends FormModel
{
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


  // Protected methods
  // -----------------

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

    $subject  = 'Submission';
    $instance = $this->getInstance();

    if ($instance) {
      $element = $instance->getElement();

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
   * @inheritDoc
   */
  protected function submit(BeforeActionEvent $event) {
    $options = [
      'from'     => $this->getMessageFom(),
      'subject'  => $this->getMessageSubject(),
      'to'       => $this->getMessageTo(),
      'textBody' => (string)$this,
    ];

    try {
      $message = new Message($options);
      $result  = Craft::$app->mailer->send($message);

      if ($result) {
        $this->redirect($event);
      }

      return $result;
    } catch (Throwable $error) {
      return false;
    }
  }
}
