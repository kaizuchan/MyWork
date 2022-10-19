<?php
declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Datasource\ModelAwareTrait;
use Punches;

/**
 * PuncheData component
 */
class PuncheDataComponent extends Component
{
    
    // loadModel()を使うために読み込む
    use ModelAwareTrait;

    
    /* 配列に年/月/日の情報と、ユーザーの勤怠データを登録して返す */
    public function getMonthlyData($user_id = null, $month = null, $year = null)
    {
        // $user_id,$month,$year がnullの場合の規定値の登録
        if($user_id == null){$user_id = $this->Authentication->getIdentity()->get('id');}
        if($month == null){$month = (int) date('m');}
        if($year == null){$year = (int) date('Y');}

        /* 指定した年/月の日付＆曜日を格納した配列を作成 */
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

        // 日付の数だけ繰り返す
        foreach ($array['dates'] as $key => $date){
            // その日の勤怠データを取得
            $res = $this->getPunchdData($year.'/'.$month.'/'.$date['date'], $user_id);
            // 上のデータをもとに「労働時間,休憩時間,残業時間,総勤務時間」の計算
            $res = $this->calculateHours($res);
            // 取得したデータをマージ
            $array['dates'][$key] = array_merge($array['dates'][$key], $res);
        }
        $array = calculateMonthlyHours($array);
        return $array;
    }






    /* 配列にユーザーの勤怠データを登録して返す */
    private function getPunchdData($date, $user_id = null)
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

            // 取得したデータ != null ならば、取得したデータから時:分のみを取得
            if($res != null){
                $time = date('H:i', strtotime($res->time));
            }else{
                $time = "";
            }
            $data = array_merge($data, [$identify[$i-1] => $time]);
        }
        return $data;
    }
    /* 各日ごとの総労働時間、労働時間、残業時間、休憩時間の計算 */
    private function calculateHours($data){
        if($data['end_work'] != ""){
            // 総勤務時間 計算
            if(strtotime($data['end_work']) > strtotime($data['start_work'])){
            $total = ((strtotime($data['end_work']) - strtotime($data['start_work'])) / 3600);
            $total = round($total, 1, PHP_ROUND_HALF_DOWN);
            }else{
            $total = ((strtotime($data['end_work']) + 86400 - strtotime($data['start_work'])) / 3600);
            $total = round($total, 1, PHP_ROUND_HALF_DOWN);
            }
            // 休憩時間 計算
            if(strtotime($data['end_work']) > strtotime($data['start_work'])){
            $break = ((strtotime($data['end_break']) - strtotime($data['start_break'])) / 3600);
            $break = round($break, 1, PHP_ROUND_HALF_DOWN);
            }else{
            $break = ((strtotime($data['end_break']) + 86400 - strtotime($data['start_break'])) / 3600);
            $break = round($break, 1, PHP_ROUND_HALF_DOWN);
            }
            // 勤務時間 & 残業時間 計算
            $overtime = 0;
            $work = $total;
            if($work > 8){
            $overtime = $work - 8;
            $work = 8;
            }
            if($total == 0){
                $work = '-';
                $break = '-';
                $overtime = '-';
                $total = '-';
            }
        }else{
            $work = '-';
            $break = '-';
            $overtime = '-';
            $total = '-';
        }
        // 計算結果を配列に格納して返却
        return array_merge($data, array(
        'work' => $work,
        'break' => $break,
        'overtime' => $overtime,
        'total' => $total,
        ));
    }
    /* 月ごとの総労働時間、労働時間、残業時間、出勤日数の計算 */
    private function calculateMonthlyHours($data){
        $work = 0;
        $total = 0;
        $overtime = 0;
        $workday = 0;
        foreach($data['dates'] as $date){
        if($date['end_work'] != null){
            $work += $date['work'];
            $total += $date['total'];
            $overtime += $date['overtime'];
            $workday += 1;
        }
        }
        return array_merge($data, [
            'work' => $work,
            'total' => $total,
            'overtime' => $overtime,
            'workday' => $workday,
        ]);
    }
}
