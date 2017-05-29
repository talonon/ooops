<?php namespace Talonon\Ooops\Operations\RDBMS;

use Illuminate\Database\Query\Builder;
use Talonon\Ooops\Contexts\DbContext;
use Talonon\Ooops\Models\BaseGetMultipleParams;

class GetCountOperation extends GetMultipleOperation {

  public function __construct(DbContext $context, BaseGetMultipleParams $params) {
    parent::__construct($context, $params);
  }

  /**
   * @return int
   */
  public function GetResult() {
    return $this->result;
  }

  protected function buildQuery(Builder $query) {
    $this->getRepository()->BuildGetMultipleQuery($query, $this->params);
  }

  protected function buildResult() {

  }

  protected function runQuery(Builder $query) {
    $this->result = $query->count();
  }

}
