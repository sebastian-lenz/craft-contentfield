<?php

namespace lenz\contentfield\models\forms;

use Craft;
use craft\base\Model;
use craft\web\Request;
use Exception;
use lenz\contentfield\events\BeforeActionEvent;
use lenz\contentfield\models\BeforeActionInterface;
use lenz\contentfield\models\InstanceAwareInterface;
use lenz\contentfield\models\values\InstanceValue;
use lenz\contentfield\models\values\LinkValue;
use lenz\contentfield\models\values\ReferenceValue;
use Throwable;

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
   * The name of the post parameter we should read attributes from.
   */
  const PARAM_NAME = 'form';


  /**
   * Retrieves the generic errors.
   *
   * A generic error is an error that is not directly bound to an
   * attribute, e.g. if the csrf token validation fails.
   *
   * @return string|null
   */
  public function getGenericError() {
    return $this->_genericError;
  }

  /**
   * Retrieves the instance value this model is attached to.
   *
   * @return InstanceValue|null
   */
  public function getInstance() {
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
      $this->_genericError = self::ERROR_INVALID_CSRF_TOKEN;
      return;
    }

    $attributes = $this->getPostedParam($request);
    if (is_null($attributes)) {
      return;
    }

    try {
      $this->setAttributes($attributes);
      if (!$this->validate()) {
        $this->_genericError = self::ERROR_VALIDATION_FAILED;
      } elseif (!$this->submit($event)) {
        $this->_genericError = self::ERROR_SUBMIT_FAILED;
      } else {
        $this->_isSubmitted = true;
      }
    } catch (Throwable $error) {
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


  // Protected methods
  // -----------------

  /**
   * Returns the posted form data.
   *
   * @param Request $request
   * @return array|null
   */
  protected function getPostedParam(Request $request) {
    return $request->getParam(static::PARAM_NAME);
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
  protected function getRedirectUrl() {
    try {
      $instance = $this->getInstance();

      if (!is_null($instance) && isset($instance->redirect)) {
        $redirect = $instance->redirect;

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
   * Tries to redirect the user.
   *
   * @param BeforeActionEvent $event
   * @return bool
   * @throws Exception
   */
  protected function tryRedirect(BeforeActionEvent $event) {
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
  abstract protected function submit(BeforeActionEvent $event);
}