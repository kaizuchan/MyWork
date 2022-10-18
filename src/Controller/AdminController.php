<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\I18n\FrozenTime;
use Migrations\Command\Phinx\Dump;

class AdminController extends AppController
{
    public function index()
    {
        $me = $this->Authentication->getIdentity();

        // ログイン中のユーザー情報取得
        $user = $this->Authentication->getIdentity();
        
        // 使うモデルの選択
        $this->loadModel('Users');
        // データの取り出し
        $users = $this->Users->find('all')->where(['enterprise_id' => $user->enterprise_id, 'not' => ['role' => '9']]);
        //debug($users);
        // データセット
        $this->set(compact('users'));

        // 検索
        if ($this->request->is('post')) {

            if(isset($_POST['find'])){
                // 配列
                $searchUsers = [];
                            
                // 入力値受け取り
                $find = $this->request->getData('find');
                // debug($find);
                // 入力値が条件に合うかどうか検索
                $searchUsers = $this->Users->find('all')->where(['or' => [
                    ['last_name LIKE' => '%'.$find.'%',],
                    ['first_name LIKE' => '%'.$find.'%'],
                ],
                'not' => ['role' => '9']
                ]);

                $count = $this->Users->find('all')->where([
                    'or' => [
                        ['last_name LIKE' => '%'.$find.'%',],
                        ['first_name LIKE' => '%'.$find.'%']
                    ],
                    'not' => ['role' => '9']
                ])->count();
                // 条件にあったデータを渡す
                $this->set('searchUsers', $searchUsers);
                $this->set('count', $count);
            }
            
            // 削除処理
            if(isset($_POST['yesButton'])){
                // データ取得                                                                                                                                                       
                $userId = $this->request->getData('delete');
                if($userId == null){
                    // 何も選択されてない場合　なにもしない
                    header('Location: /admin');
                    exit();
                }else{
                    // 削除処理
                    //debug($userId);
                    // 現在時刻
                    $time = FrozenTime::now();

                    // 書き換える部分
                    $data = array(
                        'users.role' => '9',
                        'users.deleted_at' => $time,
                    );
                    //debug($data);
                    
                    foreach($userId as $i){
                        // 条件
                        $where = array(
                            'users.id' => $i,
                        );
                        //debug($where);
                        $this->Users->updateAll($data, $where);
                    }
                }
            }
        }
    }
    public function adduser()
    {
        /*
         * Users.email の isUniqueを削除
         * ↑ 自動生成のままだと、emailはuniqueとして扱われる
         * 原則同じメールアドレスは使われないはずだが、消しておいたほうがいい
         */
        // ログイン中のユーザー情報取得
        $me = $this->Authentication->getIdentity();
        // データセット
        $this->set(compact('me'));

        $this->loadModel('Users');
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            // 3.4.0 より前は $this->request->data() が使われました。
            $user = $this->Users->patchEntity($user, $this->request->getData());

            // 誕生日のみ連結処理が必要
            $year = $this->request->getData("birthday_year");
            $month = $this->request->getData("birthday_month");
            $date = $this->request->getData("birthday_date");
            $user->birthday = mktime(0,0,0,$month,$date,$year);

            if ($this->Users->save($user)) {
                $this->Flash->success(__('登録しました'));
                return $this->redirect(['controller' => 'admin', 'action' => 'index']);
            }
            $this->Flash->error(__('社員登録に失敗しました'));
        }
    }

    public function edituser($id)
    {
        // ログイン中のユーザー情報取得
        $me = $this->Authentication->getIdentity();
        // データセット
        $this->set(compact('me'));

        $this->loadModel('Users');
        $user = $this->Users->get($id);
        if ($this->request->is('post')) {
            // 3.4.0 より前は $this->request->data() が使われました。
            $user = $this->Users->patchEntity($user, $this->request->getData());

            // 誕生日のみ連結処理が必要
            $year = $this->request->getData("birthday_year");
            $month = $this->request->getData("birthday_month");
            $date = $this->request->getData("birthday_date");

            $user->birthday = mktime(0,0,0,$month,$date,$year);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('更新しました'));
                return $this->redirect(['controller' => 'admin', 'action' => 'index']);
            }
            $this->Flash->error(__('社員更新に失敗しました'));
        }else{
            // 初めに動く処理
            // idが合致するユーザー情報を取得
            $user = $this->Users->find('all')->where(['id' => $id])->first();
            $this->set(compact('user'));
        }
    }

    public function works($id)
    {
        $dates = $this->getMonthlyData($id);
        $this->set(compact('dates'));
    }

    public function workedit($id, $date)
    {
        // 該当する打刻データを取得して、Viewに送信
        $times = $this->getPunchdData($date, $id); 
        $this->set(compact('times'));

        // データベース登録処理
        //debug($times);
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            //debug($data);
            $this->loadModel('Punches');

            $identify = array('start_work', 'start_break', 'end_break', 'end_work');
            
            $stmt = false;
            for ($i = 1; $i <= 4; $i++) {
                // 更新されたデータを特定し、そのデータのみ登録処理を行う
                if($times[$identify[$i-1]] != $data[$identify[$i-1]]){
                    $punche = $this->Punches->newEmptyEntity();
                    $punche->user_id = $id;
                    $punche->date = $date;
                    $punche->time = $data[$identify[$i-1]];
                    $punche->identify = $i;
                    $punche->modified_info = 1;
                    $stmt = $this->Punches->save($punche);
                }
            }

            if ($stmt) {
                $this->Flash->success(__('更新しました'));
                return $this->redirect(['controller' => 'admin', 'action' => 'works', $id]);
            }else{
                $this->Flash->error(__('更新に失敗しました'));
            }
        }
        // 
    }


    // 自作関数
    // 配列にユーザーの勤怠データを登録して返す
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
    private function getMonthlyData($user_id = null, $month = null, $year = null)
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
