<?php

namespace lenz\contentfield\validators;

use yii\validators\Validator;

/**
 * Class ValueValidator
 *
 * This class is used by lenz\contentfield\models\schemas\AbstractSchema
 * to detect whether a validator accepts an instance of
 * lenz\contentfield\models\values\Value or not.
 */
abstract class ValueValidator extends Validator { }
