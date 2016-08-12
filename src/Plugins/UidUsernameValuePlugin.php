<?php
namespace Drupal\aten_dev_content\Plugins;

/**
 * Convert a uid field with a username to the uid.
 */
class UidUsernameValuePlugin extends ValuePlugin {
  /**
   * Constructor
   */
  public function __construct() {
    $this->keys[] = 'uid';
  }

  /**
   * Process the uid value.
   */
  public function processValue($key, $value, array $tree, array $item) {
    // if this is just numeric, return.
    if (preg_match('/^\d+$/', $value)) {
      return $value;
    }

    // find the user
    $user = user_load_by_name($value);
    if (!$user) {
      throw new PluginException('Could not find user with username: ' . $value);
    }

    return $user->id();
  }

}
