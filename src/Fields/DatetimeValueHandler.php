<?php
namespace Drupal\aten_dev_content\Fields;

use Drupal\aten_dev_content\Fields\FieldValueHandler;
use Drupal\Core\Datetime\DrupalDateTime;

/**
 * Handle date fields.
 */
class DatetimeValueHandler extends FieldValueHandler {
  /**
   * Handle entity_reference values.
   */
  public function processValue($key, $value, array $tree, array $instance) {
    $this->debugMessage(__CLASS__ . ':' . __FUNCTION__, 'Processing value: ' . $key . ' => ' . $value);

    $format = $this->fieldInfo->getSetting('datetime_type') == 'date' ? DATETIME_DATE_STORAGE_FORMAT : DATETIME_DATETIME_STORAGE_FORMAT;
    if (preg_match('/^\d+$/', $value)) {
      $value = gmdate($format, $value);
    }

    return $value;
  }

}
