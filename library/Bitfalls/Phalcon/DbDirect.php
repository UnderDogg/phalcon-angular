<?php

namespace Bitfalls\Phalcon;

use Phalcon\Db;
use \Phalcon\DI;



/**
 * Class DbDirect
 *
 * @package Bitfalls\Phalcon
 */
trait DbDirect
{
  use Injectable;

  /** @var  Db\Adapter\Pdo */
  protected $db;

  /**
   * @return mixed| Db\Adapter\Pdo
   */
  public function getDb() {

    //var_dump(\Phalcon\Di::getDefault()->getDb());
    //exit();

    if (!isset($this->db)) {
      $this->db = \Phalcon\Di::getDefault()->getDb();
    }

    return $this->db;
  }

  /**
   * @param  Db\Adapter\Pdo $db
   *
   * @return $this
   */
  public function setDb(Db\Adapter\Pdo $db) {
    $this->db = $db;

    return $this;
  }
}