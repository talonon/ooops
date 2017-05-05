<?php namespace Talonon\Ooops\Traits;

use Talonon\Ooops\Models\Pagination\NoPagination;
use Talonon\Ooops\Models\Pagination\Pagination;

trait HasPagination {
  private $_pagination;

  public function GetPagination() {
    return $this->_pagination = $this->_pagination ?: new NoPagination();
  }

  public function SetPagination(Pagination $pagination) {
    $this->_pagination = $pagination;
    return $this;
  }
}