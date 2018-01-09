<?php namespace Talonon\Ooops\Operations\RDBMS;

use Illuminate\Database\Query\Builder;
use Talonon\Ooops\Contexts\DbContext;
use Talonon\Ooops\Exceptions\EntityNotFoundException;
use Talonon\Ooops\Exceptions\InternalException;
use Talonon\Ooops\Interfaces\AllowSoftDeletedInterface;
use Talonon\Ooops\Models\BaseGetSingleParams;

class GetSingleOperation extends BaseGetOperation {

  public function __construct(DbContext $context, BaseGetSingleParams $params) {
    parent::__construct($context, get_class($params));
    $this->params = $params;
  }
  /**
   * @var BaseGetSingleParams
   */
  protected $params;


  protected function buildQuery(Builder $select) {
    if (!($this->params instanceof AllowSoftDeletedInterface) || !$this->params->GetAllowSoftDeleted()) {
      $this->addWhereSoftDeleted($select);
    }
    $this->getRepository()->BuildGetSingleQuery($select, $this->params);
  }

  protected function buildResult() {
    if (count($this->rows) === 0) {
      throw new EntityNotFoundException($this->entityType);
    } else if (count($this->rows) > 1) {
      throw new InternalException('Result returned too many rows, expected 1 got ' . count($this->rows));
    }
    $row = $this->rows[0];
    $this->result = $this->getRepository()->BuildSingle(is_object($row) ? get_object_vars($row) : $row);
    unset($this->rows);
  }
}