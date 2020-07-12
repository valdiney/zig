<?php
namespace System\Database;

class Model extends Database
{
  public function __construct()
  {
    $table = $this->getTableName();
    parent::table($table);
  }

  protected function getTableName()
  {
    $table = $this->table ?? '';
    if (!$table) {
      $class = get_class($this);
      $path = explode('\\', $class);
      $table = array_pop($path);
      $table = ltrim(strtolower(preg_replace('/[A-Z]/', '_$0', $table)), '_');
    }
    return $table;
  }
}
