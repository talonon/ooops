<?php

namespace Talonon\Ooops\Controllers {

  use Carbon\Carbon;
  use Illuminate\Routing\Controller;
  use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
  use Talonon\Ooops\Contexts\Context;

  abstract class BaseController extends Controller {
    public function callAction($method, $parameters) {
      $this->context = tixcontext();
      $this->beforeAction($method);
      return parent::callAction($method, $parameters);
    }

    /**
     * @var Context
     */
    protected $context;
    protected $headers = [];

    public function beforeAction($method) {

    }

    protected function addHeader($key, $value, $replace = false) {
      $key = strtolower($key);
      if ((!$replace && !array_key_exists($key, $this->headers)) || $replace) {
        $this->headers[$key] = $value;
      }
    }
  }

}