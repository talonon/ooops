<?php namespace Talonon\Events;

use Talonon\Ooops\Models\Struct;

abstract class EventKeysStruct extends Struct {

  const BEFORE = 'Before';
  const AFTER = 'After';

}