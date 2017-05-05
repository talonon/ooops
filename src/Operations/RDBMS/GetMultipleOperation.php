<?php namespace Talonon\Ooops\Operations\RDBMS;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Talonon\Ooops\Contexts\DbContext;
use Talonon\Ooops\Interfaces\HasPaginationInterface;
use Talonon\Ooops\Models\BaseGetMultipleParams;

class GetMultipleOperation extends BaseGetOperation {

  public function __construct(DbContext $context, BaseGetMultipleParams $params) {
    parent::__construct($context, get_class($params));
    $this->params = $params;
  }

  /**
   * @var BaseGetMultipleParams|HasPaginationInterface
   */
  protected $params;

  /**
   * @return Collection
   */
  public function GetResult() {
    return $this->result;
  }

  protected function buildQuery(Builder $query) {
    parent::buildQuery($query);
    $this->getRepository()->BuildGetMultipleQuery($query);
    $this->buildPagination($query);
  }

  protected function buildResult() {
    $repository = $this->getRepository();
    $this->result = $this->rows->map(
      function ($row) use (&$repository) {
        return $repository->BuildMultiple(is_object($row) ? get_object_vars($row) : $row);
      });
    unset($this->rows);
    $this->hydratePaginationResponse();
  }

  protected function buildPagination(Builder $builder) {
    if ($this->params instanceof HasPaginationInterface && $this->params->GetPagination()) {
      $builder->offset($this->params->GetPagination()->GetOffset());
      $builder->limit($this->params->GetPagination()->GetPerPage());
    }
  }

  protected function hydratePaginationResponse() {
    if ($this->params instanceof HasPaginationInterface && $this->params->GetPagination()) {
      $select = $this->getTable();
      $this->buildQuery($select);
      // Remove the limit and offset from the query because we have a paginator.   This will get us all of the records.
      $select->limit = null;
      $select->offset = null;
      // Get just the record counts we don't want the records themselves.
      $results = $select->count($this->getRepository()->GetTableName() . '.' . $this->getRepository()->GetPrimaryKey());

      $pages = ceil($results / $this->params->GetPagination()->GetPerPage());
      $this->params->GetPagination()->SetResultPages($pages)->SetResultCount($results);
    }
  }

}
