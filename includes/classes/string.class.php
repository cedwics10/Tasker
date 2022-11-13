<?php 
class StringTodo
{
    // private statoc $pdo = monSQL::getPdo();

    public static function map_args_set($k, $v)
    {
        print_r($v);
        exit();
    }

    public static function make_list_set_update_with(array $args)
    {
        $args = array_map('self::map_args_set', $args);
        $texte_set = implode(',', $args);
    }
}
?>