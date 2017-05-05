<?php namespace Talonon\Ooops\Models\Pagination;

class Pagination {

  protected $offset = 0;
  protected $perPage = 20;
  protected $resultPages = 1;
  protected $resultCount = 0;

  /**
   * @return mixed
   */
  public function GetResultPages(): int {
    return $this->resultPages;
  }

  /**
   * @param mixed $resultPages
   * @return Pagination
   */
  public function SetResultPages($resultPages) {
    $this->resultPages = $resultPages;
    return $this;
  }

  /**
   * @return mixed
   */
  public function GetResultCount(): int {
    return $this->resultCount;
  }

  /**
   * @param mixed $resultCount
   * @return Pagination
   */
  public function SetResultCount(int $resultCount) {
    $this->resultCount = $resultCount;
    return $this;
  }

  /**
   * @return mixed
   */
  public function GetOffset(): int {
    return $this->offset;
  }

  /**
   * @param mixed $pagStructber
   * @return Pagination
   */
  public function SetOffset(int $offset) {
    $this->offset = $offset;
    return $this;
  }

  /**
   * @return mixed
   */
  public function GetPerPage(): int {
    return $this->perPage;
  }

  /**
   * @param mixed $perPage
   * @return Pagination
   */
  public function SetPerPage(int $perPage) {
    $this->perPage = $perPage;
    return $this;
  }
}