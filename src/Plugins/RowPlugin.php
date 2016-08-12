<?php
namespace Drupal\aten_dev_content\Plugins;

use Drupal\aten_dev_content\Plugins\Plugin;

/**
 * Create a row plugin.
 */
class RowPlugin extends Plugin {
  /**
   * We can process rows.
   */
  public function processesRows() {
    return TRUE;
  }

  /**
   * Check if this plugin should fire.
   */
  public function canProcessRow(array $row, array $tree, array $item) {
    return TRUE;
  }

  /**
   * Process the value.
   */
  public function processRow(array $row, array $tree, array $item) {
    return $row;
  }

}
