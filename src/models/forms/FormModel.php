<?php

namespace lenz\contentfield\models\forms;

use Craft;
use craft\base\Model;
use craft\web\Request;
use lenz\contentfield\events\BeforeActionEvent;
use lenz\contentfield\models\BeforeActionInterface;
use lenz\contentfield\models\InstanceAwareInterface;
use lenz\contentfield\models\values\InstanceValue;
use lenz\contentfield\models\values\LinkValue;
use lenz\contentfield\models\values\ReferenceValue;

/**
 * Class FormModel
 */
abstract class FormModel
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
   * A static url the user will be redirected to after form submission.
   */
  const REDIRECT_URL = null;


  /**
   * @return string|null
   */
  public function getGenericError() {
    return $this->_genericError;
  }

  /**
   * @return InstanceValue|null
   */
  public function getInstance() {
    return $this->_instance;
  }

  /**
   * @param BeforeActionEvent $event
   * @return void
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
    return !is_null($this->_genericError);
  }

  /**
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
   * @param Request $request
   * @return array|null
   */
  protected function getPostedParam(Request $request) {
    return $request->getParam(static::PARAM_NAME);
  }

  /**
   * @return string|null
   */
  protected function getRedirectUrl() {
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

    return static::REDIRECT_URL;
  }

  /**
   * @param BeforeActionEvent $event
   * @return bool
   */
  protected function redirect(BeforeActionEvent $event) {
    $url = $this->getRedirectUrl();
    if (empty($url)) {
      return false;
    }

    Craft::$app->getResponse()->redirect($url);
    $event->originalEvent->isValid = false;
    return true;
  }

  /**
   * @param BeforeActionEvent $event
   * @return bool
   */
  abstract protected function submit(BeforeActionEvent $event);
}
