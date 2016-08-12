<?php
namespace Drupal\aten_dev_content;

class FieldValueHandlers {
  public static function get(\Drupal\field\Entity\FieldStorageConfig $type) {
    $pieces = explode('_', $type->getType());
    $pieces = array_map('ucfirst', $pieces);
    $handler = 'Drupal\aten_dev_content\Fields\\' . implode('', $pieces) . 'ValueHandler';
    if (class_exists($handler)) {
      return new $handler($type);
    }
    return FALSE;
  }

}
