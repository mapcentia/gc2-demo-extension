<?php
/**
 * @author     Martin Høgh <mh@mapcentia.com>
 * @copyright  2013-2021 MapCentia ApS
 * @license    http://www.gnu.org/licenses/#AGPL  GNU AFFERO GENERAL PUBLIC LICENSE 3
 *
 */

namespace app\extensions\gc2_demo_extension\model;

use app\inc\Model;
use PDOException;


/**
 * Class Demo
 * @package app\extensions\gc2_demo_extension\model
 */
class Demo extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param int $n
     * @return int
     */
    public function getNumber(int $n): int
    {
        $sql = "SELECT :n::int AS num";
        $res = $this->prepare($sql);
        $res->execute(["n" => $n]);
        $row = $this->fetchRow($res);
        return $row["num"];
    }
}