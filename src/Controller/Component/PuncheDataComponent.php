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
    public function getMonthlyData($user_id, $month = null, $year = null)
    {
        // $month,$year がnullの場合の規定値の登録
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
                'start_work' => array(),
                'start_break' => array(),
                'end_break' => array(),
                'end_work' => array(),
                'work' => array(),
                'break' => array(),
                'overtime' => array(),
                'total' => array(),
                'info' => array(),
            ];
            array_push($array['dates'], $a);
        }

        // 日付の数だけ繰り返す
        foreach ($array['dates'] as $key => $date){
            // その日の勤怠データを取得
            $res = $this->getPunchedDatas($year.'/'.$month.'/'.$date['date'], $user_id);
            // 取得したデータをマージ
            $array['dates'][$key] = array_merge($array['dates'][$key], $res);

            // 上のデータをもとに「労働時間,休憩時間,残業時間,総勤務時間」の計算
            $res = $this->calculateHours($res);
            // 取得したデータをマージ
            $array['dates'][$key] = array_merge($array['dates'][$key], $res);
            
            //その日の更新情報を取得
            $res = $this->getPunchedInfo($year.'/'.$month.'/'.$date['date'], $user_id);
            $array['dates'][$key]['info'] = $res;
        }
        $array = $this->calculateMonthlyHours($array);
        return $array;
    }
    /* 配列にユーザーの勤怠データを登録して返す */
    public function getPunchedDatas($date, $user_id)
    {
        $identify = array('start_work', 'start_break', 'end_break', 'end_work');
        $this->loadModel('Punches');
        for ($i = 1; $i <= 4; $i++) {
            $data = array();
            // 対象のレコードを全て取得
            $res = $this->getPunchedData($user_id, $date, $i);
            // 取得したデータ != null ならば、取得したデータから時:分のみを取得
            if($res != null){
                foreach($res as $r){
                    array_push($data, $r->time->i18nFormat('yyyy-MM-dd HH:mm:ss'));
                }
            }
            $return[$identify[$i-1]] = $data;
        }
        return $return;
    }
    /* ユーザーの勤怠データ編集情報を登録して返す */
    public function getPunchedInfo($date, $user_id)
    {
        $info = 1;
        for ($i = 1; $i <= 4; $i++) {
            $data = array();
            // 対象のレコードを全て取得
            $res = $this->getPunchedData($user_id, $date, $i);
            // 取得したデータ != null ならば、取得したデータから時:分のみを取得
            if($res != null){
                foreach($res as $r){
                    array_push($data, $r->time->i18nFormat('yyyy-MM-dd HH:mm:ss'));
                    if($r->info == 2){
                        $info = 2;
                    }
                }
            }
        }
        return $info;
    }
    /* 配列にユーザーの勤怠データを登録して返す */
    public function getPunchedData($user_id, $date, $identify = null)
    {
        $this->loadModel('Punches');
        $where = [
            0 => [
            'user_id' => $user_id,
            'date' => $date,
            ]
            ];
        if($identify != null){
            $where = array_merge($where[0], ['identify' => $identify]);
        }
        $where = array_merge($where, ['not' => ['info' => 9]]);
        // 対象のレコードを全て取得
        $res = $this->Punches->find('all')
        ->where($where)
        ->order([
            'time ASC',
        ]);
        return $res;
    }
    /* 打刻 identify取得 */
    public function getPunchStatement($user_id)
    {
        // 対象ユーザーの最後の打刻情報を取得
        $res = $this->getPunchData($user_id);
        if ($res != null){
            $res = $res->get('identify');
        }
        return $res;
    }
    /* 打刻 date取得 */
    public function getPunchedDate($user_id)
    {
        // 対象ユーザーの最後の打刻情報を取得
        $res = $this->getPunchData($user_id);
        if ($res != null){
            $res = $res->get('date');
        }
        return $res;
    }
    /* 対象ユーザーの最後の打刻情報を取得 */
    private function getPunchData($user_id)
    {
        $this->loadModel('Punches');
        return $this->Punches
            ->find('all')->where([
                [
                    'user_id' => $user_id,
                ],
                'not' => [
                    'info' => 9
                ]
            ])
            ->order([
                'time ASC',
            ])
            ->last();
    }




    
    /* 各日ごとの総労働時間、労働時間、残業時間、休憩時間の計算 */
    public function calculateHours($data){
        $work = 0;
        $break = 0;
        $overtime = 0;
        $total = 0;
        if($data['end_work'] != null){
            /* 休憩時間 計算 */
            // 休憩終了時間と同じだけ繰り返す
            foreach($data['end_break'] as $k => $d){
                $break += (strtotime($d) - strtotime($data['start_break'][$k])) / 3600;
            }
            /* 総勤務時間 計算 */
            // 退勤の数だけ繰り返す
            foreach($data['end_work'] as $k => $d){
                $total += (strtotime($d) - strtotime($data['start_work'][$k])) / 3600;
            }
            $total -= $break;
            // 切り捨て処理
            $total = round($total, 1, PHP_ROUND_HALF_DOWN);
            $break = round($break, 1, PHP_ROUND_HALF_DOWN);
            // 勤務時間 & 残業時間 計算
            $work = $total;
            if($work > 8){
                $overtime = $work - 8;
                $work = 8;
            }
        }
        $res = array(
            'work' => (float) $work,
            'break' => (float) $break,
            'overtime' => (float) $overtime,
            'total' => (float) $total
        );
        // 0 の場合は「-」
        foreach($res as $k => $r){
            if($r == 0){
                $res[$k] = '-';
            }
        }
        return $res;
    }
    /* 月ごとの総労働時間、労働時間、残業時間、出勤日数の計算 */
    private function calculateMonthlyHours($data){
        $work = (float) 0;
        $total = (float) 0;
        $overtime = (float) 0;
        $workday = 0;
        foreach($data['dates'] as $date){
            if($date['end_work'] != null){
                $work += (float) $date['work'];
                $total += (float) $date['total'];
                $overtime += (float) $date['overtime'];
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
