<?php
/**
 * @author     Martin Høgh <mh@mapcentia.com>
 * @copyright  2013-2021 MapCentia ApS
 * @license    http://www.gnu.org/licenses/#AGPL  GNU AFFERO GENERAL PUBLIC LICENSE 3
 *
 */

namespace app\extensions\gc2_demo_extension\controller;

use app\conf\App;
use app\inc\Controller;
use app\extensions\gc2_demo_extension\model\Demo as ModelDemo;
use app\inc\Input;
use app\inc\Route;
use app\models\Database;
use Exception;
use PDOException;
use TypeError;
use Postmark\PostmarkClient;
use Postmark\Models\PostmarkException;


/**
 * Class Demo
 * @package app\extensions\gc2_demo_extension\controller
 */
class Demo extends Controller
{
    /**
     * @return array<string|int|bool>
     */
    public function post_index(): array
    {
        Database::setDb(Route::getParam("db"));
        $body = Input::getBody();
        $m = new ModelDemo();
        // Try for TypeError, because it's user input and try for PDOException in case of SQL error
        try {
            $res = $m->getNumber(json_decode($body, true)["num"]);
        } catch (TypeError | PDOException $err) {
            return [
                "code" => "500",
                "success" => false,
                "message" => $err->getMessage(),
            ];
        }

        // Try to send a mail
        try {
            $client = new PostmarkClient(App::$param["Postmark"]["key"]);
            $client->sendEmail("info@mapcentia.com", "mh@mapcentia.com", "Hello!", "<h1>Heeellooo</h1>");
        } catch (PostmarkException $err) {
            return [
                "code" => "500",
                "success" => false,
                "message" => $err->getMessage(),
            ];

        } catch (Exception $generalException) {
            return [
                "code" => "500",
                "success" => false,
                "message" => $generalException->getMessage(),
            ];
        }

        // Everything is OK - sending 200 with result
        return [
            "code" => "200",
            "success" => true,
            "number" => $res,
        ];
    }
}