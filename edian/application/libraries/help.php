<?php
/**
 * 一些工具类的函数，没有具体的用处，用完即删的
 * @name        libraries/help.php
 * @author      unasm < 1264310280@qq.com >
 * @since       2013-12-06 22:31:13
 * @package     libraries
 */
/**
 *
 */
class CI_Help
{

     function __construct()
    {
        //连个构造都没有，成和体统
    }
     /**
      * 以一种更优雅的方式显示数组
      */
     public function showArr($arr , $tab = "")
     {
         $cnt = 0;
         foreach ($arr as $key => $value) {
             echo $tab;
             if(is_array($value)){
                 echo $key." => (<br/>" ;
                 $this->showArr($value , " - - - " . $tab);
                 echo ")<br/>";
             }else{
                echo $key . "=> " .$value ."<br/>";
             }
         }
     }

    /**
     * 显示post中所有的数值和value
     */
    protected function showPost()
    {
        foreach ($_POST as $key => $value) {
            var_dump($key);
            echo "=>";
            echo var_dump($value);
            echo "<br/>";
        }
    }
}
?>
