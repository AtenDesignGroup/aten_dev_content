<?php
namespace Drupal\aten_dev_content\Fields;

use Drupal\aten_dev_content\Fields\FieldValueHandler;

/**
 * Handle entity_reference fields.
 */
class EntityReferenceValueHandler extends FieldValueHandler {
  /**
   * Handle entity_reference values.
   */
  public function processValue($key, $value, array $tree, array $instance) {
    $this->debugMessage(__CLASS__ . ':' . __FUNCTION__, 'Processing value: ' . $key . ' => ' . $value);
    $target_type = $this->fieldInfo->getSetting('target_type');

    // if this is a taxonomy_term and in the form of "vocab|term"
    if ($target_type === 'taxonomy_term' && preg_match('/^([^\|]+)\|(.+)$/', $value)) {
      $target_value = explode('|', $value);
      $terms = NULL;
      if (count($target_value) === 2) {
        $terms = taxonomy_term_load_multiple_by_name($target_value[1], $target_value[0]);
      }
      else {
        $terms = taxonomy_term_load_multiple_by_name($target_value[1]);
      }

      if ($terms) {
        $term = array_shift($terms);
        return [
          'target_id' => $term->id(),
        ];
      }
    }
    // if this is a user and not a uid
    elseif ($target_type === 'user' && !preg_match('/^\d+$/', $value)) {
      $user = user_load_by_name($value);
      if ($user) {
        return [
          'target_id' => $user->id(),
        ];
      }
    }
    // in the form of "file.machine_name"
    elseif (preg_match('/^[^\.]+\..+$/', $value)) {
      $target_value = explode('.', $value);
      $entity = aten_dev_content_get_development_content([
        'source' => $target_value[0],
        'machine_name' => $target_value[1],
        'module' => $tree['module'],
      ]);
      if ($entity) {
        $this->debugMessage(__CLASS__ . ':' . __FUNCTION__, "Found {$target_value[0]}.{$target_value[1]}: {$entity['entity_id']}");
        return [
          'target_id' => $entity['entity_id'],
        ];
      }
      $this->debugMessage(__CLASS__ . ':' . __FUNCTION__, "Could not find content {$target_value[0]}.{$target_value[1]}");
    }

    return $value;
  }

}
