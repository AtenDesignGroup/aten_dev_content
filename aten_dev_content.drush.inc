<?php

/**
 * Implements hook_drush_command().
 */
function aten_dev_content_drush_command() {
  $items = [];

  $items['dev-content-disable'] = [
    'description' => 'Disable dev content',
    'aliases' => ['dcd'],
    'arguments' => [
      'module' => 'Module machine name ex. page',
    ],
    'options' => [
      'force' => 'Force updates',
      'debug' => 'Enable debugging',
      'all' => 'Disable all development content',
      'file' => 'The file name to disable. By default it disables all of a module\'s files, this will limit it to a single file.',
    ],
    'examples' => [
      'drush dcd example_module' => 'Disable dev content for example_module',
      'drush dcd example_module --file schools' => 'Disable the schools.ymlm dev content for example_module',
    ],
  ];

  $items['dev-content-enable'] = [
    'description' => 'Enable dev content',
    'aliases' => ['dce'],
    'arguments' => [
      'module' => 'Module machine name ex. page',
    ],
    'options' => [
      'force' => 'Force updates',
      'debug' => 'Enable debugging',
      'all' => 'Enable all development content',
    ],
    'examples' => [
      'drush dce example_module' => 'Enable dev content for example_module',
    ],
  ];

  $items['dev-content-find'] = [
    'description' => 'Find dev content',
    'aliases' => ['dcf'],
    'arguments' => [
      'machine_name' => 'The machine name for the content',
    ],
    'options' => [
      'module' => 'The module that defines the content',
    ],
    'examples' => [
      'drush dcf example_class' => 'Finds dev content with the machine name example_class',
    ],
  ];

  $items['dev-content-implementations'] = [
    'description' => 'Find modules with dev content',
    'aliases' => ['dci'],
    'arguments' => [],
    'options' => [],
    'examples' => [],
  ];

  return $items;
}

/**
 * Callback for the content disable command
 */
function drush_aten_dev_content_dev_content_disable() {
  $args = array_slice(drush_get_arguments(), 1);

  $options = [
    'force' => drush_get_option('force', FALSE),
    'debug' => drush_get_option('debug', FALSE),
    'all' => drush_get_option('all', FALSE),
    'file' => drush_get_option('file', FALSE),
  ];

  if ($options['all']) {
    aten_dev_content_disable_all($options);
    return;
  }

  // uninstall everything
  foreach ($args as $arg) {
    drush_print('Disabling dev content for ' . $arg);
    try {
      aten_dev_content_disable_content($arg, $options);
    }
    catch (Exception $e) {
      drush_log($e->getMessage(), 'error');
    }
  }

}

/**
 * Callback for the content enable command
 */
function drush_aten_dev_content_dev_content_enable() {
  $args = array_slice(drush_get_arguments(), 1);

  $options = [
    'force' => drush_get_option('force', FALSE),
    'debug' => drush_get_option('debug', FALSE),
    'all' => drush_get_option('all', FALSE),
  ];

  if ($options['all']) {
    aten_dev_content_enable_all($options);
    return;
  }

  // uninstall everything
  foreach ($args as $arg) {
    drush_print('Enabling dev content for ' . $arg);
    try {
      aten_dev_content_enable_content($arg, $options);
    }
    catch (Exception $e) {
      drush_log($e->getMessage(), 'error');
    }
  }

}

/**
 * Callback for the content find command
 */
function drush_aten_dev_content_dev_content_find() {
  $args = array_slice(drush_get_arguments(), 1);

  $content = Drupal::database()->select('development_content_map', 'd')
    ->fields('d')
    ->condition('machine_name', $args[0])
    ->execute()
    ->fetchAssoc();
  if (!$content) {
    drush_print('Could not find content with machine name: ' . $args[0]);
    return;
  }

  $max_key_length = 0;
  foreach (array_keys($content) as $key) {
    if (strlen($key) > $max_key_length) {
      $max_key_length = strlen($key);
    }
  }

  foreach ($content as $key => $value) {
    drush_print(sprintf('%' . $max_key_length . 's: %s', $key, $value));
  }
}

/**
 * Find modules that implement dev content.
 */
function drush_aten_dev_content_dev_content_implementations() {
  $handler = Drupal::moduleHandler();
  $implements = $handler->getImplementations('enable_development_content');
  if (!$implements) {
    drush_log('No modules have development content', 'ok');
    return;
  }

  sort($implements);
  foreach ($implements as $module) {
    drush_print($module);
  }
}
