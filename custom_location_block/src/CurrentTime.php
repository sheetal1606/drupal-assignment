<?php

/**
* @file providing the service that show location and time according to selected timezon in ACF.
*
*/

namespace Drupal\custom_location_block;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Datetime\DateFormatter;
use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Class CurrentTime
 * @package Drupal\custom_location_block\Services
 */
class CurrentTime {

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory')
    );
  }


  /**
   * CurrentTime constructor.
   * @param DateFormatter $date_formatter
   *
   * @param ConfigFactoryInterface $config_factory
   *
   */
  public function __construct(DateFormatter $date_formatter, ConfigFactoryInterface $config_factory) {
    $this->date_formatter = $date_formatter;
    $this->config_factory = $config_factory;
  }

 
  /**
   * @return  current time according to selected timezone
   */
  public function getData() {
  	$current_time = time();
  	$config = $this->config_factory->get('custom_location_block.settings');
    $timezone = $config->get('timezone');
    $time =  $this->date_formatter->format( $current_time, 'custom', 'jS  F Y - h:i A', $timezone);
    return $time;

  }

}
