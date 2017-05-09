<?php namespace Talonon\Ooops\Interfaces;

/**
 * Class ResultInterface.  Interface for Operations that return a result.  Ensures that the operation class has a
 * GetResult method defined, without having a base class that constricts the implementation.
 * @package Plasco\Operations
 */
interface ResultInterface {
  function GetResult();

}