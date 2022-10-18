<?php
namespace App\Utils;

/**
 * AppUtility.
 */
class AppUtility
{
    /*
     * function 
     */
    public static function add($val1, $val2){
        return ($val1 + $val2);
    }


    //

    public static function getPunchdData($date, $user_id = null)
    {
        // $user_idがnullなら、ログイン中のユーザーのIDをセット
        if($user_id == null){
            $user_id = $this->Authentication->getIdentity()->get('id');
        }
        $data = array();
        $identify = array('start_work', 'start_break', 'end_break', 'end_work');
        $this->loadModel('Punches');
        for ($i = 1; $i <= 4; $i++) {
            // 最新のレコードを１つのみ取得
            $res = $this->Punches->find('all')->where([
                'user_id' => $user_id,
                'date' => $date,
                'identify' => $i,
            ])->last();

            // 取得したデータ != null ならば、取得したデータから時間を取得
            if($res != null){
                $data = array_merge($data, [$identify[$i-1] => date('H:i', strtotime($res->time))]);
            }else{
                $data = array_merge($data, [$identify[$i-1] => null]);
            }
        }
        return $data;
    }
    // 配列に年/月/日の情報と、ユーザーの勤怠データを登録して返す
    public static function getMonthlyData($user_id = null, $month = null, $year = null)
    {
        // 指定した年/月の日付＆曜日を格納した配列を作成
        // $month 及び $year がnullの場合、現在の日付を登録する
        if($month == null){$month = (int) date('m');}
        if($year == null){$year = (int) date('Y');}
        // 配列を用意
        $array = [
            'year'  => $year,
            'month' => $month,
            'dates' => array(),
        ];
        // その月の日数のデータを登録する
        for ($i = 1; $i <= date('t', strtotime($year.'-'.$month)); $i++) {
            $a = [
                'date' => $i,
                'day'  => date('w', strtotime($year.'-'.$month.'-'.$i)),
            ];
            array_push($array['dates'], $a);
        }

        // $user_idがnullなら、ログイン中のユーザーのIDをセット
        if($user_id == null){
            $user_id = $this->Authentication->getIdentity()->get('id');
        }
        $i = 0;
        foreach ($array['dates'] as $date){
            $res = $this->getPunchdData($array['year'].'/'.$array['month'].'/'.$date['date'], $user_id);
            $array['dates'][$i] = array_merge($array['dates'][$i], $res);
            $i++;
        }
        return $array;
    }
}