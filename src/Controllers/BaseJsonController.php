<?php

  namespace Talonon\Ooops\Controllers {

    /**
     * Sets up the basic most methods used by all of the Ajax controllers.
     */
    abstract class BaseJsonController extends BaseController {

      use ResponseWithJson;

      public function __construct() {
        $this->_isXHR = \Request::ajax();
      }

    }
  }
