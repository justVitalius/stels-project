<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
set_time_limit(0);

/*
 * блок основных настроек
 */
define("USER", "root");//укажите пользователя mysql
define("PASS", ""); //укажите пароль пользователя
define("DATABASE", "social"); //Укажите Базу данных
define("PATH_ROOT_WEB", ""); // Внесите значение $config['path']['root']['web']  из config.php
define("PATH_IMAGES_UPLOADS", "/upload/images"); //путь до папки uploads/images


$conn1 = mysql_connect("localhost", USER, PASS);

if (!$conn1) {
    echo "Unable to connect to DB: " . mysql_error();
    exit;
}

if (!mysql_select_db(DATABASE,$conn1)) {
    echo "Unable to select mydbname: " . mysql_error();
    exit;
}

mysql_query("set character_set_client='utf8'",$conn1);
mysql_query("set character_set_results='utf8'",$conn1);
mysql_query("set collation_connection='utf8_bin'",$conn1);


function buildInsertSql($sTable,$aRow)  {
       // $sql='INSERT INTO '.$sTable.' SET ';
        foreach ($aRow as $row) {
               $sPath=''.PATH_ROOT_WEB.''.PATH_IMAGES_UPLOADS.'/topics/'.$row['topic_id'].'.'.$row['topic_avatar_type'];
               mysql_query("UPDATE `prefix_topic` SET  topic_preview = '{$sPath}' WHERE topic_id = {$row['topic_id']}");
        }
        return;
}

function exportTable($sTable) {
        global $conn1;


        $iAll=0;
        $iExp=0;

        $res = mysql_query("SELECT topic_id, topic_avatar_type FROM `prefix_topic` WHERE 1=1 AND topic_avatar_type IS NOT NULL ",$conn1);
        if ($res) {
                while ($row = mysql_fetch_assoc($res)) {
                        if (buildInsertSql($sTable,$row)) {
                                $iExp++;
                        }
                }
                $iAll=mysql_num_rows($res);
                mysql_free_result($res);
        }
        echo "Export {$sTable}: {$iExp} from {$iAll}\n";
}

exportTable('prefix_topic');


?>