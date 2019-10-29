<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 2019/9/29
 * Time: 12:13
 */

namespace app\api\controller\v1;


use think\Db;
use app\api\model\Pjaauc_t as PjaaucModel;
use app\api\model\Product as ProductModel;
class project
{
    public function getProjectList(){
//        $db = '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 172.16.100.187)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = topprd)))';
//        $conn = oci_connect('dsdemo','dsdemo',$db);
//        if(!$conn){
//            $e = oci_error();
//            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
//        }
//        $stid = oci_parse($conn, 'SELECT * FROM employees');
//        oci_execute($stid);
//        echo "<table border='1'>\n";
//        while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
//            echo "<tr>\n";
//            foreach ($row as $item) {
//                echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
//            }
//            echo "</tr>\n";
//        }
//        echo "</table>\n";
//        return config('database.DB_PROJECT');
//        以下这段可行（不用模型的独立代码）：
//        $ora = Db::connect(config('database.DB_PROJECT'));
//        $result = $ora->query('select * from pjaauc_t where pjaauc001 like ?',['%君禾%']);
//        $where['pjaauc001'] = ['like','%君禾%'];
//        $result = $ora->table('pjaauc_t')->where($where)->select();
//        return var_dump($result);
//        以下为模拟的方式
//        $result = PjaaucModel::find()->visible(['PJAAUC001','PJAAUC002']);
        $result = PjaaucModel::find();
//        $result = ProductModel::getProductDetail(2);
//        return var_dump($result);
        return $result;

    }
}