<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 14.11.19
 * Time: 17:24
 */

namespace DB;


interface DBConnectionInterface
{
    public function readDataFromDB(array $parameters);
}