<?php
namespace Pharborist;

/**
 * Interface method.
 * @package Pharborist
 */
class InterfaceMethodNode extends Node {
  /**
   * @var Node
   */
  public $visibility;

  /**
   * @var Node
   */
  public $methodName;

  /**
   * @var Node[]
   */
  public $parameters;
}
