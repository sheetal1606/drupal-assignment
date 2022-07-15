<?php

namespace Drupal\custom_location_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\custom_location_block\CurrentTime;
use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Provides a block to show location with time.
 * 
 * @Block(
 *   id = "site_location",
 *   admin_label = @Translation("Site Location")
 * )
 */

class Location extends BlockBase implements ContainerFactoryPluginInterface {
  // CurrentTime service
  protected $time = NULL;
  
  /*
   * static create function provided by the ContainerFactoryPluginInterface.
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('custom_location_block.time'),
      $container->get('config.factory')
    );
  }
  
  /*
   * BlockBase plugin constructor that's expecting the CurrentTime object provided by create().
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, CurrentTime $time, ConfigFactoryInterface $config_factory) {
    // instantiate the BlockBase parent first
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->time = $time;
    $this->config_factory = $config_factory;
  }
  
  /**
   * {@inheritdoc}
   */
  public function build() {

    $time =  $this->time->getData();
    $config = $this->config_factory->get('custom_location_block.settings');
    return [
      '#theme' => 'custom_location_block_loc',
      '#data' => ['Country' => $config->get('country'), 'City' => $config->get('city'), 'Time' => [
          '#markup' => $time,
          '#cache' => [
            'tags' => ['config:custom_location_block.settings'],
          ]
        ],
      ],
    ];
  }
}