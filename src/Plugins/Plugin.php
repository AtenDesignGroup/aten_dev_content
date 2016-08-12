<?php
namespace Drupal\aten_dev_content\Plugins;

/**
 * Defines a plugin.
 */
class Plugin {
  public $debug = FALSE;

  /**
   * Processes values.
   */
  public function processesValues() {
    return FALSE;
  }

  /**
   * Processes rows.
   */
  public function processesRows() {
    return FALSE;
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
