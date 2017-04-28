<?php namespace Talonon\Ooops\Operations\RDBMS;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Talonon\Ooops\Interfaces\ResultInterface;
use Talonon\Ooops\Models\BaseGetMultipleParams;
use Talonon\Ooops\Models\BaseGetSingleParams;

abstract class BaseGetOperation extends BaseEntityOperation implements ResultInterface {

  /**
   * The result holder
   * @var mixed
   */
  protected $result;
  /**
   * @var Collection
   */
  protected $rows;

  /**
   * @var BaseGetSingleParams|BaseGetMultipleParams
   */
  protected $params;

  public function GetResult() {
    return $this->result;
  }

  protected function afterEvent() {
    $this->fireEvent('After', $this->result);
  }

  protected function beforeEvent() {
    $this->fireEvent('Before', $this->params);
  }

  protected function doExecute() {
    $select = $this->getTable();
    $this->buildQuery($select);
    $this->runQuery($select);
    $this->buildResult();
  }

  protected function runQuery(Builder $query) {
    $this->rows = $query->get();
  }

  protected function buildQuery(Builder $select) {
    $this->addWhereSoftDeleted($select);
  }

  protected abstract function buildResult();
}
