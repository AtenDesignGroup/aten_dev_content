<?php
namespace Drupal\aten_dev_content\Plugins;

/**
 * Find the vocabulary for a taxonomy term when adding term entities.
 */
class TaxonomyVocabularyRowPlugin extends RowPlugin {
  protected $vocabularies = [];

  /**
   * Process the type row.
   */
  public function processRow(array $row, array $tree, array $item) {
    $vocab = NULL;
    if (isset($item['vocabulary'])) {
      $vocab = $item['vocabulary'];
    }
    elseif (isset($tree['vocabulary'])) {
      $vocab = $tree['vocabulary'];
    }
    if (!$vocab) {
      throw new \Drupal\aten_dev_content\Plugins\PluginException('No vocabulary specified');
    }

    if (!isset($this->vocabularies[$vocab])) {
      // find the vocab
      $names = taxonomy_vocabulary_get_names();
      if (!isset($names[$vocab])) {
        throw new \Drupal\aten_dev_content\Plugins\PluginException('Could not find vocabulary: ' . $vocab);
      }
      $this->vocabularies[$vocab] = $names[$vocab];
    }

    $row['vid'] = $vocab;
    return $row;
  }

}
