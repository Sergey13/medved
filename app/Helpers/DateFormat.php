<?php namespace App\Helpers;

/* 
 * Форматирование даты в читабельное представление
 */

class DateFormat {
    
    public $month = array('января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентяря', 'октября', 'ноября', 'декабря');
    
    public function __construct() {
        $this->month = array('января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентяря', 'октября', 'ноября', 'декабря');
    }
    
    
    public static function formatDate($date, $type = NULL) {
        
        $month = array('января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентяря', 'октября', 'ноября', 'декабря');
        
        $month_1 = array('январь', 'февраль', 'март', 'апрель', 'май', 'июнь', 'июль', 'август', 'сентярь', 'октябрь', 'ноябрь', 'декабрь');
        
        $now_date = date('Y-m-d');
        
        $date_time = explode(" ", $date);
        
        $date = explode('-', $date_time[0]);
        
        if($type == 'short') {
            
            $result_date = (int) $date[2].'.'.(((int) $date[1] > 9) ? (int) $date[1] : '0'.(int) $date[1]).'.'.$date[0];
            
        } else if($type == 'with_month') {
            
            $result_date = $month_1[(int) $date[1]-1].' '.$date[0];
            
        } else {
            
            $result_date = (int) $date[2].' '.$month[(int) $date[1]-1].' '.$date[0];
            
        }
        
        return $result_date;
    }
    
    public static function formatDateForDialog($date) {
        
        $now_date = date('Y-m-d H:i:s');
        
        $now_day = (int)date('d');
        
        $diff = abs(strtotime($now_date) - strtotime($date)) / 60 / 60;
        
        $date_time = explode(" ", $date);
        
        $date = explode('-', $date_time[0]);
        
        $time = explode(':', $date_time[1]);
        
        if(($now_day - (int) $date[2]) == 0) {
            $result_date = 'ceгодня в '.$time[0].':'.$time[1];
        } else if(($now_day - (int) $date[2]) == 1){
            $result_date = 'вчера в '.$time[0].':'.$time[1];
        } else {
            $result_date = (int) $date[2].'.'.(((int) $date[1] > 9) ? (int) $date[1] : '0'.(int) $date[1]).'.'.$date[0].' '.$time[0].':'.$time[1];   
        }
        
        return $result_date;
        
    }
    
    /**
     * Возвращает разницу между настоящим временем и передаваемым в параметре в часах
     * 
     * @param type $time
     * @return type
     */
    public static function difference_time($time) {
        
        $naw_time = date('Y-m-d H:i:s');
        
        return abs(strtotime($naw_time) - strtotime($time)) / 60 / 60;
    } 
    
    
    public static function change_date_for_db($date) {
        
        $date = date_create($date);
        
        
        return date_format($date, 'Y-m-d');
    }
    
    public static function change_date_for_view($date) {
        
        $date = date_create($date);
        
        
        return date_format($date, 'd.m.Y');
    }
}

