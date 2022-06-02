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
 * @noinspection PhpUnused
 *
 * A simple base class for forms that send a mail when being submitted.
 */
class MailForm extends AbstractForm
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
   * An array that defines the names of attributes that should be omitted in
   * the generated mail message body.
   */
  const OMIT_ATTRIBUTES = [];

  /**
   * Defines whether empty attributes should be omitted.
   */
  const OMIT_EMPTY_ATTRIBUTES = true;


  /**
   * @return string
   */
  public function __toString() {
    return $this->getMessageBody();
  }


  // Protected methods
  // -----------------

  /**
   * Creates the message about to be sent.
   *
   * @return Message
   */
  protected function createMessage(): Message {
    return new Message([
      'from'     => $this->getMessageFrom(),
      'subject'  => $this->getMessageSubject(),
      'to'       => $this->getMessageTo(),
      'textBody' => $this->getMessageBody(),
    ]);
  }

  /**
   * Transforms a single attribute to a chunk of text.
   *
   * By default this returns a text like this:
   * ```
   * ATTRIBUTE:
   * VALUE
   * ```
   *
   * @param string $attribute
   * @param mixed $value
   * @return string|null
   */
  protected function getAttributeString(string $attribute, mixed $value): ?string {
    if (empty($value) && static::OMIT_EMPTY_ATTRIBUTES) {
      return null;
    }

    return implode("\n", [
      $this->getAttributeLabel($attribute) . ':',
      $this->getAttributeStringValue($attribute, $value),
    ]);
  }

  /**
   * Transforms a single attribute value to a string.
   *
   * By default, this simply applies a word wrap. Override this function
   * if you have attribute values that must perform some kind of transformation.
   *
   * @param string $attribute
   * @param mixed $value
   * @return string
   * @noinspection PhpUnusedParameterInspection (API signature)
   */
  protected function getAttributeStringValue(string $attribute, mixed $value): string {
    return wordwrap((string)$value);
  }

  /**
   * Returns the body of the mail.
   *
   * By default this renders all attributes of this modal as a chunk of
   * text. Override this method to customize the message body.
   *
   * @return string
   */
  protected function getMessageBody(): string {
    $lines = [];

    foreach ($this->attributes as $attribute => $value) {
      if (in_array($attribute, static::OMIT_ATTRIBUTES)) {
        continue;
      }

      $line = $this->getAttributeString($attribute, $value);
      if (!is_null($line)) {
        $lines[] = $line;
      }
    }

    return implode("\n\n", $lines);
  }

  /**
   * Returns the sender of the mail.
   *
   * By default, this returns the system default sender. Either set the desired sender
   * with the constant `MESSAGE_FROM` or override this method.
   *
   * @return string|array|User|User[]
   */
  protected function getMessageFrom(): array|string|User|null {
    if (!is_null(static::MESSAGE_FROM)) {
      return static::MESSAGE_FROM;
    }

    return Craft::$app->mailer->from;
  }

  /**
   * Returns the subject of the mail.
   *
   * By default, this returns `Submission: ENTRY_NAME`. Either set the desired
   * subject with the constant `MESSAGE_SUBJECT` or override this method.
   *
   * @return string|null
   */
  protected function getMessageSubject(): ?string {
    if (!is_null(static::MESSAGE_SUBJECT)) {
      return static::MESSAGE_SUBJECT;
    }

    $subject = 'Submission';
    $instance = $this->getInstance();

    $element = $instance?->getElement();
    if ($element instanceof Element) {
      $subject .= ': ' . $element->title;
    }

    return $subject;
  }

  /**
   * Returns the recipient of the mail.
   *
   * By default this returns `info@HTTP_HOST`. Either set the desired
   * recipient with the constant `MESSAGE_TO` or override this method.
   *
   * @return string|array|User|User[]
   */
  protected function getMessageTo(): array|string|User|null {
    if (!is_null(static::MESSAGE_TO)) {
      return static::MESSAGE_TO;
    }

    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    return 'info@' . $host;
  }

  /**
   * @inheritDoc
   */
  protected function submit(BeforeActionEvent $event): bool {
    try {
      $message = $this->createMessage();
      $result = Craft::$app->mailer->send($message);

      if ($result) {
        $this->tryRedirect($event);
      }

      return $result;
    } catch (Throwable) {
      return false;
    }
  }
}
