<?php

namespace lenz\contentfield\models\forms;

use Craft;
use craft\base\Model;
use craft\console\Request as ConsoleRequest;
use craft\web\Request as WebRequest;
use Exception;
use lenz\contentfield\events\BeforeActionEvent;
use lenz\contentfield\helpers\BeforeActionInterface;
use lenz\contentfield\helpers\InstanceAwareInterface;
use lenz\contentfield\models\values\InstanceValue;
use lenz\contentfield\models\values\LinkValue;
use lenz\contentfield\models\values\ReferenceValue;
use Throwable;
use yii\base\Request;
use yii\web\UploadedFile;

/**
 * Class AbstractForm
 *
 * An abstract base class for models used to represent form inputs.
 *
 * Either extend this class or use it as a rough guide on how to
 * implement your own form models.
 */
abstract class AbstractForm
  extends Model
  implements BeforeActionInterface, InstanceAwareInterface
{
  /**
   * @var string|null
   */
  private $_genericError = null;

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
  const ERROR_INVALID_CSRF_TOKEN = 'INVALID_CSRF_TOKEN';
  const ERROR_SUBMIT_FAILED = 'SUBMIT_FAILED';
  const ERROR_UNKNOWN = 'UNKNOWN';
  const ERROR_VALIDATION_FAILED = 'VALIDATION_FAILED';

  /**
   * Defines the validators that declare an attribute to be a file.
   */
  const FILE_VALIDATORS = ['file', 'image'];


  /**
   * Retrieves the generic errors.
   *
   * A generic error is an error that is not directly bound to an
   * attribute, e.g. if the csrf token validation fails.
   *
   * @return string|null
   */
  public function getGenericError(): ?string {
    return $this->_genericError;
  }

  /**
   * Retrieves the instance value this model is attached to.
   *
   * @return InstanceValue|null
   */
  public function getInstance(): ?InstanceValue {
    return $this->_instance;
  }

  /**
   * @inheritDoc
   */
  public function onBeforeAction(BeforeActionEvent $event) {
    $request = Craft::$app->getRequest();
    if (!$request->isPost) {
      return;
    }

    if (!$request->validateCsrfToken()) {
      $this->setGenericError(self::ERROR_INVALID_CSRF_TOKEN);
      return;
    }

    $attributes = $this->getPostedParam($request);
    if (is_null($attributes)) {
      return;
    }

    try {
      $this->setPostAttributes($attributes);

      if (!$this->validate()) {
        $this->setGenericError(self::ERROR_VALIDATION_FAILED);
      } elseif (!$this->submit($event)) {
        $this->setGenericError(self::ERROR_SUBMIT_FAILED);
      } else {
        $this->_isSubmitted = true;
      }
    } catch (Throwable $error) {
      $this->setGenericError(self::ERROR_UNKNOWN, $error);
    }
  }

  /**
   * @inheritDoc
   */
  public function hasErrors($attribute = null): bool {
    if (is_null($attribute) && $this->hasGenericError()) {
      return true;
    }

    return parent::hasErrors($attribute);
  }

  /**
   * Returns whether the form has a generic error.
   *
   * A generic error is an error that is not directly bound to an
   * attribute, e.g. if the csrf token validation fails.
   *
   * @return bool
   */
  public function hasGenericError(): bool {
    return !is_null($this->_genericError);
  }

  /**
   * Return whether this form has been successfully submitted or not.
   *
   * Use this in templates to decide whether the form or a success
   * message should be displayed.
   *
   * @return bool
   */
  public function isSubmitted(): bool {
    return $this->_isSubmitted;
  }

  /**
   * @inheritDoc
   */
  public function setInstance(InstanceValue $instance) {
    $this->_instance = $instance;
  }

  /**
   * @param array $values
   */
  public function setPostAttributes(array $values) {
    $this->setAttributes($values);
  }


  // Protected methods
  // -----------------

  /**
   * @param array $result
   * @return array
   */
  protected function getPostedFiles(array $result = []): array {
    $name = $this->getPostedParamName();
    if (is_null($name)) {
      return $result;
    }

    foreach ($this->rules() as $rule) {
      list($fields, $validator) = $rule;
      if (!in_array($validator, static::FILE_VALIDATORS)) {
        continue;
      }

      $fields = is_array($fields) ? $fields : [$fields];
      foreach ($fields as $field) {
        $result[$field] = UploadedFile::getInstanceByName($name . '[' . $field . ']');
      }
    }

    return $result;
  }

  /**
   * Returns the posted form data.
   *
   * @param Request $request
   * @return array|null
   */
  protected function getPostedParam(Request $request): ?array {
    if (
      !$request instanceof ConsoleRequest &&
      !$request instanceof WebRequest
    ) {
      return null;
    }

    $name = $this->getPostedParamName();
    if (is_null($name)) {
      return null;
    }

    $param = $request->getParam($name);
    return is_array($param)
      ? $this->getPostedFiles($param)
      : null;
  }

  /**
   * @return string|null
   */
  protected function getPostedParamName(): ?string {
    return is_null($this->_instance)
      ? null
      : $this->_instance->getNamespace();
  }

  /**
   * Tries to find the url the user should be redirected to
   * upon submitting the form.
   *
   * The default implementation looks for a field named `redirect`
   * on the instance, it should be either a link or reference field.
   *
   * Override this function to implement custom redirect logic.
   *
   * @return string|null
   */
  protected function getRedirectUrl(): ?string {
    try {
      $instance = $this->getInstance();

      if (!is_null($instance) && isset($instance->redirect)) {
        $redirect = $instance->getValue('redirect');

        if ($redirect instanceof ReferenceValue) {
          $element = $redirect->getFirst();
          return $element ? $element->getUrl() : null;
        } elseif ($redirect instanceof LinkValue) {
          return $redirect->getUrl();
        }
      }
    } catch (Throwable $error) {
      // Silently ignore errors
    }

    return null;
  }

  /**
   * Sets the general error state of the form after submission.
   * This is a good hook if one would wish to record form submission errors.
   *
   * @param string|null $value
   * @param Throwable|null $exception
   * @noinspection PhpUnusedParameterInspection
   */
  protected function setGenericError(string $value = null, Throwable $exception = null) {
    $this->_genericError = $value;
  }

  /**
   * Tries to redirect the user.
   *
   * @param BeforeActionEvent $event
   * @return bool
   * @throws Exception
   */
  protected function tryRedirect(BeforeActionEvent $event): bool {
    $url = $this->getRedirectUrl();
    if (empty($url)) {
      return false;
    }

    Craft::$app->getResponse()->redirect($url);
    $event->originalEvent->isValid = false;
    return true;
  }

  /**
   * Callback invoked when this form is being submitted.
   *
   * This is only invoked if
   * - The current request is a post request.
   * - The form data is present in the submitted post data.
   * - The posted data could be validated.
   *
   * @param BeforeActionEvent $event
   * @return bool
   */
  abstract protected function submit(BeforeActionEvent $event): bool;
}
