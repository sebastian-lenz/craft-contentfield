<?php

namespace lenz\contentfield\helpers\debug;

use Craft;
use craft\elements\db\ElementQuery;
use yii\base\Event;
use yii\debug\Panel;

/**
 * Class ElementQueryPanel
 */
class ElementQueryPanel extends Panel
{
  /**
   * @var QueryInfo[]
   */
  protected $_queries = [];

  /**
   * The internal id of this panel.
   */
  const ID = 'tcfElementQueries';


  /**
   * ElementQueryPanel constructor.
   *
   * @param array $config
   */
  public function __construct($config = []) {
    parent::__construct($config);

    $this->id = self::ID;
    $this->module = Craft::$app->getModule('debug');

    Event::on(ElementQuery::class, ElementQuery::EVENT_AFTER_PREPARE, function(Event $event) {
      $query = $event->sender;
      if ($query instanceof ElementQuery) {
        $info = new QueryInfo();
        $info->setQuery($query);
        $this->_queries[] = $info;
      }
    });
  }

  /**
   * @inheritDoc
   */
  public function getDetail(): string {
    if (!array_key_exists('@contentfieldDebug', Craft::$aliases)) {
      Craft::$aliases['@contentfieldDebug'] = implode(DIRECTORY_SEPARATOR, [__DIR__, 'views']);
    }

    return Craft::$app->view->render('@contentfieldDebug/panel.phtml', [
      'panel'    => $this,
      'queries'  => $this->_queries,
      'rootNode' => $this->getStructure(),
    ]);
  }

  /**
   * @inheritDoc
   */
  public function getName(): string {
    return 'Element queries';
  }

  /**
   * @inheritDoc
   */
  public function getSummary(): string {
    return implode('', [
      '<div class="yii-debug-toolbar__block">',
        '<a href="', $this->getUrl(), '">',
          'Element queries ',
          '<span class="yii-debug-toolbar__label">', count($this->_queries), '</span>',
        '</a>',
      '</div>'
    ]);
  }

  /**
   * @inheritDoc
   */
  public function load($data) {
    if (
      !is_array($data) ||
      !array_key_exists('queries', $data) ||
      !is_array($data['queries'])
    ) {
      return;
    }

    foreach ($data['queries'] as $query) {
      $this->_queries[] = new QueryInfo($query);
    }
  }

  /**
   * @inheritDoc
   */
  public function save() {
    $queries = [];
    foreach ($this->_queries as $query) {
      $query->beforeSave();
      $queries[] = $query->getAttributes();
    }

    return [
      'queries' => $queries,
    ];
  }


  // Private methods
  // ---------------

  /**
   * @return QueryNode
   */
  private function getStructure(): QueryNode {
    $root = new QueryNode();

    foreach ($this->_queries as $query) {
      $templates = array_reverse($query->templates);
      $node = $root;
      foreach ($templates as $template) {
        $node = $node->getTemplateChild($template);
      }

      $node->addQuery($query);
    }

    return $root;
  }
}
