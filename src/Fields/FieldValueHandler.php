<?php
namespace Drupal\aten_dev_content\Fields;

/**
 * Abstract handler class.
 */
abstract class FieldValueHandler {
  public $debug = FALSE;

  protected $fieldInfo = NULL;

  /**
   * Constructor.
   */
  public function __construct($field_info) {
    $this->fieldInfo = $field_info;

    if ($this->debug) {
      $this->debugMessage(__FUNCTION__, 'Field info: ' . var_export($this->fieldInfo, TRUE));
    }
  }

  /**
   * Process the value.
   */
  public function processValue($key, $value, array $tree, array $instance) {
    return $value;
  }

  /**
   * Debug message.
   */
  public function debugMessage($function, $message) {
    if ($this->debug) {
      aten_dev_content_debug($function, $message);
    }
  }

}
