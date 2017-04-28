<?php namespace Talonon\Ooops\Controllers;

use Talonon\Ooops\Contexts\Context;
use Talonon\Ooops\Exceptions\InternalException;

trait ResponseWithView {


  protected $wrapper = 'Layouts.Anonymous';

  /**
   * Server side set settings that can be accessed by the JavaScript.  Key=>Value pair, values will be accessible
   * using Settings.<Key> on the Front-End code.
   *
   * The settings array includes the array of AJAX handlers that are available to the view.
   * @var array
   */
  private $_settings = ['Modules' => [], 'Endpoints' => []];
  /**
   * Data key=>value pairs to add to the view.
   * @var array
   */
  private $_data = [];

  public function GetValue($key, $default = null) {
    return array_key_exists($key, $this->_data) ? $this->_data[$key] : $default;
  }

  /**
   * Adds the key/value pair to the data that is available to the View.
   * @param $key
   * @param $value
   */
  public function addValue($key, $value) {
    $this->_data[$key] = $value;
  }

  public function setMetadata($key, $value) {
    $metadata = $this->GetValue('Metadata');
    $metadata[$key] = $value;
    $this->addValue('Metadata', $metadata);
  }

  /**
   * Renders the view.  Adds the Settings and Handlers to the display variables.
   * @param $view
   * @param array $data
   * @return object
   */
  protected function render($view, $data = array()) {
    $this->_settings['_csrf'] = csrf_token();
    $data['Settings'] = json_encode($this->_settings);
    !isset($data['Layout']) && $data['Layout'] = $this->wrapper;

    $data = array_merge($this->_data, $data);
    return \View::make($view, $data);
  }

  /**
   * Adds the handler name and url to the Settings Handlers array so it can be used in the JavaScript.
   * @param $name
   * @param $url
   */
  protected function addEndpoint($name, $url) {
    $this->_settings['Endpoints'][$name] = $url;
  }

  /**
   * Adds the required js module name Settings Modules array so it can be required by global js.
   * @param $name
   * @param $url
   */
  protected function addModule($name) {
    $this->_settings['Modules'][] = $name;
  }

  /**
   * Adds a key/value pair to the settings array so it can be used in the JavaScript on the frontend.  This is
   * useful for exposing values calculated server side in the view.
   * @param $key
   * @param $value
   */
  protected function addSetting($key, $value) {
    if ($key == 'Endpoints') throw new InternalException('Invalid Setting Key Name');
    $this->_settings[$key] = $value;
  }
}

