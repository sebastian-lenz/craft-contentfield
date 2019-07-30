<?php

namespace lenz\contentfield\migrations;

use lenz\contentfield\records\ContentRecord;
use craft\db\Migration;
use craft\db\Table;

/**
 * Class Install
 */
class Install extends Migration
{
  /**
   * @inheritdoc
   */
  public function safeUp() {
    ContentRecord::createTable($this);
  }

  /**
   * @inheritdoc
   */
  public function safeDown() {
    return false;
  }
}
