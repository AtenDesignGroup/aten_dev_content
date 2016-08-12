<?php
namespace Drupal\aten_dev_content\Plugins;

use Drupal\aten_dev_content\Plugins\Plugin;

/**
 * Create a value plugin.
 */
class ValuePlugin extends Plugin {
  protected $keys = [];

  /**
   * We can process values.
   */
  public function processesValues() {
    return TRUE;
  }

  /**
   * Check if this plugin should fire.
   */
  public function canProcessValue($key, $value, array $tree, array $item) {
    return in_array($key, $this->keys);
  }

  /**
   * Process the value.
   */
  public function processValue($key, $value, array $tree, array $item) {
    return $value;
  }

}
