<?php namespace Talonon\Ooops\Operations\RDBMS;

use Talonon\Ooops\Contexts\DbContext;
use Talonon\Ooops\Operations\BaseOperation;

abstract class BaseDbOperation extends BaseOperation {

  public function __construct(DbContext $context) {
    $this->context = $context;
  }

  /**
   * @var DbContext
   */
  protected $context;

  /**
   * @return \Illuminate\Database\Connection
   */
  protected function getDatabase() {
    return $this->context->GetDatabase();
  }
}