<?php
class Filter {
    static function validate($value){
        return filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
    }
}
?>