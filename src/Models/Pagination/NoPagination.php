<?php namespace Talonon\Ooops\Models\Pagination;

class NoPagination extends Pagination {
  /**
   * This could technically cause a race-condition if query returns more than 2 billion or so records.
   */
  protected $perPage = PHP_INT_MAX;

}