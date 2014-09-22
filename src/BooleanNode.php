<?php
namespace Pharborist;

/**
 * Base class for TRUE and FALSE.
 */
abstract class BooleanNode extends ConstantNode implements ScalarNode {
  /**
   * Create
   *
   * @param mixed $boolean
   *   Boolean value.
   *
   * @return BooleanNode
   */
  public static function create($boolean) {
    if ($boolean) {
      return TrueNode::create();
    }
    else {
      return FalseNode::create();
    }
  }

  /**
   * Boolean value of constant.
   *
   * @return boolean
   *   TRUE or FALSE.
   */
  abstract public function toBoolean();

  /**
   * @return boolean
   */
  public function toValue() {
    return $this->toBoolean();
  }
}
