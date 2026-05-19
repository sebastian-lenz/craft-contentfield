<?php

namespace lenz\contentfield\services\anchors;

use craft\helpers\StringHelper;

/**
 * Class Anchor
 */
class Anchor implements AnchorInterface
{
  /** @var string */
  public string $id;


  /**
   * @param string $title
   * @param string|null $id
   */
  public function __construct(
    public readonly string $title,
    string|null $id = null,
  ) {
    $this->id = is_null($id) ? StringHelper::slugify($title) : $id;
  }

  /**
   * @return string
   */
  public function __toString(): string {
    return $this->id;
  }

  /**
   * @inheritDoc
   */
  public function getId(): string {
    return $this->id;
  }

  /**
   * @return string
   */
  public function getTitle(): string {
    return $this->title;
  }

  /**
   * @inheritDoc
   */
  public function setId(string $value): void {
    $this->id = $value;
  }
}
