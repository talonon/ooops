<?php namespace Talonon\Ooops\Exceptions;

class EntityNotFoundException extends InternalException {

  public function __construct($entityType, $id = null) {
    $parts = explode('\\', $entityType);
    $entityType = array_pop($parts);
    $idMessage = $id ? (' with id ' . (is_array($id) ? print_r($id, true) : $id)) : '';
    parent::__construct($entityType . ' not found' . $idMessage);
  }

}

