<?php namespace Talonon\Ooops\Operations\RDBMS;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Talonon\Ooops\Contexts\DbContext;
use Talonon\Ooops\Models\BaseGetMultipleParams;

class GetMultipleOperation extends BaseGetOperation {

  public function __construct(DbContext $context, BaseGetMultipleParams $params) {
    parent::__construct($context, get_class($params));
    $this->params = $params;
  }

  /**
   * @var BaseGetMultipleParams
   */
  protected $params;

  /**
   * @return Collection
   */
  public function GetResult() {
    return $this->result;
  }

  protected function buildQuery(Builder $query) {
    $fields = $this->getRepository()->GetMultipleFields($this->params);
    $query->where($fields);
    parent::buildQuery($query);
  }

  protected function buildResult() {
    $repository = $this->getRepository();
    $this->result = $this->rows->map(
      function ($row) use (&$repository) {
        return $repository->BuildMultiple(is_object($row) ? get_object_vars($row) : $row);
      });
    unset($this->rows);
  }

}
