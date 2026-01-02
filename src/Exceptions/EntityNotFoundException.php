<?php namespace Talonon\Ooops\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class EntityNotFoundException extends InternalException implements HttpExceptionInterface{

  public function __construct($entityType, $id = null) {
    $parts = explode('\\', $entityType);
    $entityType = array_pop($parts);
    $idMessage = $id ? (' with id ' . (is_array($id) ? print_r($id, true) : $id)) : '';
    parent::__construct($entityType . ' not found' . $idMessage);
  }

  /**
   * Returns the status code.
   */
  public function getStatusCode(): int {
    return 404;
  }

  /**
   * Returns response headers.
   */
  public function getHeaders(): array {
    return [];
  }
}

