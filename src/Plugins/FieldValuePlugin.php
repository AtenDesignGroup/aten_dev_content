<?php
namespace Drupal\aten_dev_content\Plugins;

use Drupal\aten_dev_content\FieldValueHandlers;

/**
 * Try to handle some automatic field value processing based on field types.
 */
class FieldValuePlugin extends ValuePlugin {
  /**
   * See if this is a field.
   */
  public function canProcessValue($key, $value, array $tree, array $item) {
    return preg_match('/^field_/', $key);
  }

  /**
   * Process the uid value.
   */
  public function processValue($key, $value, array $tree, array $item) {
    // get the field definition
    $field_info = \Drupal\field\Entity\FieldStorageConfig::loadByName($tree['entity'], $key);
    if (!$field_info) {
      $this->debugMessage(__CLASS__ . ':' . __FUNCTION__, 'No field info for ' . $tree['entity'] . '.' . $key);
      return $value;
    }

    try {
      $handler = FieldValueHandlers::get($field_info);
      if ($handler) {
        $this->debugMessage(__CLASS__ . ':' . __FUNCTION__, 'Processing with ' . get_class($handler));
        $handler->debug = $this->debug;
        return $handler->processValue($key, $value, $tree, $item);
      }

      $this->debugMessage(__CLASS__ . ':' . __FUNCTION__, 'No handler found for ' . $key);
      return $value;
    }
    catch (\Drupal\aten_dev_content\Fields\FieldValueHandlerException $e) {

    }
  }

}
