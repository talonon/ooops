<?php namespace Talonon\Ooops\Interfaces;

use Talonon\Ooops\Models\Pagination\Pagination;

interface HasPaginationInterface {

  /**
   * @return Pagination
   */
  public function GetPagination();
}