<?php
namespace Pharborist;

use Pharborist\Operator\BinaryOperationNode;
use Pharborist\Operator\PostDecrementNode;
use Pharborist\Operator\PostIncrementNode;
use Pharborist\Operator\TernaryOperationNode;
use Pharborist\Operator\UnaryOperationNode;

/**
 * An Operator factory.
 *
 * Factory for building OperatorNode and also creating Operator for use in
 * ExpressionParser.
 */
class OperatorFactory {
  /**
   * Associativity, Precedence, Static, Binary Class, Unary Class
   * @var array
   */
  private static $operators = [
    T_LOGICAL_OR => [Operator::ASSOC_LEFT, 1, TRUE, '\Pharborist\Operator\LogicalOrNode', NULL],
    T_LOGICAL_XOR => [Operator::ASSOC_LEFT, 2, TRUE, '\Pharborist\Operator\LogicalXorNode', NULL],
    T_LOGICAL_AND => [Operator::ASSOC_LEFT, 3, TRUE, '\Pharborist\Operator\LogicalAndNode', NULL],
    '=' => [Operator::ASSOC_RIGHT, 4, FALSE, '\Pharborist\Operator\AssignNode', NULL],
    T_AND_EQUAL => [Operator::ASSOC_RIGHT, 4, FALSE, '\Pharborist\Operator\BitwiseAndAssignNode', NULL],
    T_CONCAT_EQUAL => [Operator::ASSOC_RIGHT, 4, FALSE, '\Pharborist\Operator\ConcatAssignNode', NULL],
    T_DIV_EQUAL => [Operator::ASSOC_RIGHT, 4, FALSE, '\Pharborist\Operator\DivideAssignNode', NULL],
    T_MINUS_EQUAL => [Operator::ASSOC_RIGHT, 4, FALSE, '\Pharborist\Operator\SubtractAssignNode', NULL],
    T_MOD_EQUAL => [Operator::ASSOC_RIGHT, 4, FALSE, '\Pharborist\Operator\ModulusAssignNode', NULL],
    T_MUL_EQUAL => [Operator::ASSOC_RIGHT, 4, FALSE, '\Pharborist\Operator\MultiplyAssignNode', NULL],
    T_OR_EQUAL => [Operator::ASSOC_RIGHT, 4, FALSE, '\Pharborist\Operator\BitwiseOrAssignNode', NULL],
    T_PLUS_EQUAL => [Operator::ASSOC_RIGHT, 4, FALSE, '\Pharborist\Operator\AddAssignNode', NULL],
    T_SL_EQUAL => [Operator::ASSOC_RIGHT, 4, FALSE, '\Pharborist\Operator\BitwiseShiftLeftAssignNode', NULL],
    T_SR_EQUAL => [Operator::ASSOC_RIGHT, 4, FALSE, '\Pharborist\Operator\BitwiseShiftRightAssignNode', NULL],
    T_XOR_EQUAL => [Operator::ASSOC_RIGHT, 4, FALSE, '\Pharborist\Operator\BitwiseXorAssignNode', NULL],
    T_POW_EQUAL => [Operator::ASSOC_RIGHT, 4, FALSE, '\Pharborist\Operator\PowerAssignNode', NULL],
    '?' => [Operator::ASSOC_LEFT, 5, TRUE, NULL, NULL],
    T_BOOLEAN_OR => [Operator::ASSOC_LEFT, 6, TRUE, '\Pharborist\Operator\BooleanOrNode', NULL],
    T_BOOLEAN_AND => [Operator::ASSOC_LEFT, 7, TRUE, '\Pharborist\Operator\BooleanAndNode', NULL],
    '|' => [Operator::ASSOC_LEFT, 8, TRUE, '\Pharborist\Operator\BitwiseOrNode', NULL],
    '^' => [Operator::ASSOC_LEFT, 9, TRUE, '\Pharborist\Operator\BitwiseXorNode', NULL],
    '&' => [Operator::ASSOC_LEFT, 10, TRUE, '\Pharborist\Operator\BitwiseAndNode', NULL],
    T_IS_EQUAL => [Operator::ASSOC_NONE, 11, TRUE, '\Pharborist\Operator\EqualNode', NULL],
    T_IS_IDENTICAL => [Operator::ASSOC_NONE, 11, TRUE, '\Pharborist\Operator\IdenticalNode', NULL],
    T_IS_NOT_EQUAL => [Operator::ASSOC_NONE, 11, TRUE, '\Pharborist\Operator\NotEqualNode', NULL],
    T_IS_NOT_IDENTICAL => [Operator::ASSOC_NONE, 11, TRUE, '\Pharborist\Operator\NotIdenticalNode', NULL],
    '<' => [Operator::ASSOC_NONE, 12, TRUE, '\Pharborist\Operator\LessThanNode', NULL],
    T_IS_SMALLER_OR_EQUAL => [Operator::ASSOC_NONE, 12, TRUE, '\Pharborist\Operator\LessThanOrEqualToNode', NULL],
    T_IS_GREATER_OR_EQUAL => [Operator::ASSOC_NONE, 12, TRUE, '\Pharborist\Operator\GreaterThanOrEqualToNode', NULL],
    '>' => [Operator::ASSOC_NONE, 12, TRUE, '\Pharborist\Operator\GreaterThanNode', NULL],
    T_SL => [Operator::ASSOC_LEFT, 13, TRUE, '\Pharborist\Operator\BitwiseShiftLeftNode', NULL],
    T_SR => [Operator::ASSOC_LEFT, 13, TRUE, '\Pharborist\Operator\BitwiseShiftRightNode', NULL],
    '+' => [Operator::ASSOC_LEFT, 14, TRUE, '\Pharborist\Operator\AddNode', '\Pharborist\Operator\PlusNode'],
    '-' => [Operator::ASSOC_LEFT, 14, TRUE, '\Pharborist\Operator\SubtractNode', '\Pharborist\Operator\NegateNode'],
    '.' => [Operator::ASSOC_LEFT, 14, TRUE, '\Pharborist\Operator\ConcatNode', NULL],
    '*' => [Operator::ASSOC_LEFT, 15, TRUE, '\Pharborist\Operator\MultiplyNode', NULL],
    '/' => [Operator::ASSOC_LEFT, 15, TRUE, '\Pharborist\Operator\DivideNode', NULL],
    '%' => [Operator::ASSOC_LEFT, 15, TRUE, '\Pharborist\Operator\ModulusNode', NULL],
    '!' => [Operator::ASSOC_RIGHT, 16, TRUE, NULL, '\Pharborist\Operator\BooleanNotNode'],
    T_INSTANCEOF => [Operator::ASSOC_NONE, 17, FALSE, '\Pharborist\Operator\InstanceOfNode', NULL],
    T_INC => [Operator::ASSOC_RIGHT, 18, FALSE, NULL, '\Pharborist\Operator\PreIncrementNode'],
    T_DEC => [Operator::ASSOC_RIGHT, 18, FALSE, NULL, '\Pharborist\Operator\PreDecrementNode'],
    T_BOOL_CAST => [Operator::ASSOC_RIGHT, 18, FALSE, NULL, '\Pharborist\Operator\BooleanCastNode'],
    T_INT_CAST => [Operator::ASSOC_RIGHT, 18, FALSE, NULL, '\Pharborist\Operator\IntegerCastNode'],
    T_DOUBLE_CAST => [Operator::ASSOC_RIGHT, 18, FALSE, NULL, '\Pharborist\Operator\FloatCastNode'],
    T_STRING_CAST => [Operator::ASSOC_RIGHT, 18, FALSE, NULL, '\Pharborist\Operator\StringCastNode'],
    T_ARRAY_CAST => [Operator::ASSOC_RIGHT, 18, FALSE, NULL, '\Pharborist\Operator\ArrayCastNode'],
    T_OBJECT_CAST => [Operator::ASSOC_RIGHT, 18, FALSE, NULL, '\Pharborist\Operator\ObjectCastNode'],
    T_UNSET_CAST  => [Operator::ASSOC_RIGHT, 18, FALSE, NULL, '\Pharborist\Operator\UnsetCastNode'],
    '@' => [Operator::ASSOC_RIGHT, 18, FALSE, NULL, '\Pharborist\Operator\SuppressWarningNode'],
    '~' => [Operator::ASSOC_RIGHT, 18, TRUE, NULL, '\Pharborist\Operator\BitwiseNotNode'],
    T_POW => [Operator::ASSOC_RIGHT, 19, TRUE, '\Pharborist\Operator\PowerNode', NULL],
    T_CLONE => [Operator::ASSOC_RIGHT, 20, FALSE, NULL, '\Pharborist\Operator\CloneNode'],
    T_PRINT => [Operator::ASSOC_RIGHT, 21, FALSE, NULL, '\Pharborist\Operator\PrintNode'],
  ];

  /**
   * Create an OperatorNode for the given token type.
   * @param int|string $token_type
   * @param bool $static_only
   * @return Operator
   */
  public static function createOperator($token_type, $static_only = FALSE) {
    if (array_key_exists($token_type, self::$operators)) {
      list($assoc, $precedence, $static, $binary_class_name, $unary_class_name) = self::$operators[$token_type];
      if ($static_only && !$static) {
        return NULL;
      }
      $operator = new Operator();
      $operator->type = $token_type;
      $operator->associativity = $assoc;
      $operator->precedence = $precedence;
      $operator->hasBinaryMode = $binary_class_name !== NULL;
      $operator->hasUnaryMode = $unary_class_name !== NULL;
      $operator->binaryClassName = $binary_class_name;
      $operator->unaryClassName = $unary_class_name;
      return $operator;
    }
    return NULL;
  }

  /**
   * @param Operator $question_operator
   * @param PartialNode $colon_node
   * @return Operator
   */
  public static function createElvisOperator(Operator $question_operator, PartialNode $colon_node) {
    $operator = new Operator();
    $operator->mergeNode($question_operator);
    $operator->mergeNode($colon_node);
    $operator->type = '?:';
    $operator->associativity = Operator::ASSOC_LEFT;
    $operator->precedence = 5;
    $operator->hasBinaryMode = TRUE;
    $operator->hasUnaryMode = FALSE;
    $operator->binaryClassName = '\Pharborist\Operator\ElvisNode';
    return $operator;
  }

  /**
   * @param Operator $assign_operator
   * @param PartialNode $by_ref_node
   * @return Operator
   */
  public static function createAssignReferenceOperator(Operator $assign_operator, PartialNode $by_ref_node) {
    $operator = new Operator();
    $operator->mergeNode($assign_operator);
    $operator->mergeNode($by_ref_node);
    $operator->associativity = Operator::ASSOC_RIGHT;
    $operator->precedence = 4;
    $operator->hasBinaryMode = TRUE;
    $operator->hasUnaryMode = FALSE;
    $operator->binaryClassName = '\Pharborist\Operator\AssignReferenceNode';
    return $operator;
  }

  /**
   * @param Operator $operator
   * @param Node $operand
   * @return UnaryOperationNode
   */
  public static function createUnaryOperatorNode(Operator $operator, Node $operand) {
    $class_name = $operator->unaryClassName;
    /** @var UnaryOperationNode $node */
    $node = new $class_name();
    $node->mergeNode($operator);
    $node->addChild($operand, 'operand');
    return $node;
  }

  /**
   * @param Node $left
   * @param Operator $operator
   * @param Node $right
   * @return BinaryOperationNode
   */
  public static function createBinaryOperatorNode(Node $left, Operator $operator, Node $right) {
    $class_name = $operator->binaryClassName;
    /** @var BinaryOperationNode $node */
    $node = new $class_name();
    $node->addChild($left, 'left');
    $node->mergeNode($operator);
    $node->addChild($right, 'right');
    return $node;
  }

  /**
   * @param Node $operand
   * @param Operator $operator
   * @return PostDecrementNode|PostIncrementNode
   * @throws ParserException
   */
  public static function createPostfixOperatorNode(Node $operand, Operator $operator) {
    if ($operator->type === T_DEC) {
      $node = new PostDecrementNode();
    }
    elseif ($operator->type === T_INC) {
      $node = new PostIncrementNode();
    }
    else {
      throw new ParserException($operator->getOperator()->getSourcePosition(), "Invalid postfix operator!");
    }
    $node->addChild($operand, 'operand');
    $node->mergeNode($operator);
    return $node;
  }

  /**
   * @param Node $condition
   * @param Operator $operator
   * @param Node $then
   * @param ParentNode $colon
   * @param Node $else
   * @return TernaryOperationNode
   */
  public static function createTernaryOperatorNode(
    Node $condition,
    Operator $operator,
    Node $then,
    ParentNode $colon,
    Node $else
  ) {
    $node = new TernaryOperationNode();
    $node->addChild($condition, 'condition');
    $node->mergeNode($operator);
    $node->addChild($then, 'then');
    $node->mergeNode($colon);
    $node->addChild($else, 'else');
    return $node;
  }
}
