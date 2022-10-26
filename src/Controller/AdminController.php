<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\I18n\FrozenTime;
use Migrations\Command\Phinx\Dump;

class AdminController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        // コンポーネントの読み込み
        $this->loadComponent("PuncheData");
        $this->loadComponent("SerchUser");
        // モデルの読み込み
        $this->loadModel('Users');
        $this->loadModel('Enterprises');
    }

    public function index()
    {
        // 自分の情報と企業情報をViewに送信
        $me = $this->Authentication->getIdentity();
        $enterprise = $this->Enterprises->find('all')->where(['id'=>$me->enterprise_id])->first()->get('name');
        $this->set(compact('me', 'enterprise'));
        // アクセス制限
        $user = $this->Users->get($me->id);
        $this->Authorization->authorize($user, 'view');
        

        // 社員全員の情報を取り出す
        $users = $this->SerchUser->getEmployee($me->enterprise_id);

        if ($this->request->is('post')) {

            // 検索
            if(isset($_POST['find'])){
                // 入力値受け取り
                $find = $this->request->getData('find');
                // 条件に一致する社員の情報を取り出す
                $users = $this->SerchUser->getEmployee($me->enterprise_id, null, $find);
                // 取り出した社員の人数を数える
                $count = $users->count();
                // 人数を渡す
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
                        'users.employee_id' => '',
                        'users.role' => '9',
                        'users.deleted_at' => $time,
                    );
                    
                    foreach($userId as $i){
                        // 条件
                        $where = array(
                            'users.id' => $i,
                        );
                        $this->Users->updateAll($data, $where);
                    }
                }
            }
        }
        
        // データセット
        $this->set(compact('users'));
    }

    public function adduser()
    {
        // 自分の情報と企業情報をViewに送信
        $me = $this->Authentication->getIdentity();
        $enterprise = $this->Enterprises->find('all')->where(['id'=>$me->enterprise_id])->first()->get('name');
        $this->set(compact('me', 'enterprise'));
        // アクセス制限
        $user = $this->Users->get($me->id);
        $this->Authorization->authorize($user, 'view');
        /*
         * Users.email の isUniqueを削除
         * ↑ 自動生成のままだと、emailはuniqueとして扱われる
         * 原則同じメールアドレスは使われないはずだが、消しておいたほうがいい
         */
        if ($this->request->is('post')) {
            // 同じ社員IDを持ったユーザーがいないかの確認
            $employee_id = $this->request->getData('employee_id');
            $res = $this->Users->find('all')->where([
                'enterprise_id' => $me->enterprise_id,
                'employee_id'   => $employee_id
            ])->first();
            if($res == null){
                $user = $this->Users->newEmptyEntity();
                // 送信されたデータを登録
                $user = $this->Users->patchEntity($user, $this->request->getData());
    
                // 誕生日のみ連結処理が必要
                $year = $this->request->getData("birthday-year");
                $month = $this->request->getData("birthday-month");
                $date = $this->request->getData("birthday-date");
                $user->birthday = $year.'-'.$month.'-'.$date;
    
                if ($this->Users->save($user)) {
                    // 登録成功
                    $this->Flash->success(__('登録しました'));
                    return $this->redirect(['controller' => 'admin', 'action' => 'index']);
                }
                    // 登録失敗
                $this->Flash->error(__('社員登録に失敗しました'));
            }else{
                $this->Flash->error(__('同じ社員IDが既に存在します'));
            }
        }
    }

    public function edituser($id)
    {
        // 自分の情報と企業情報をViewに送信
        $me = $this->Authentication->getIdentity();
        $enterprise = $this->Enterprises->find('all')->where(['id'=>$me->enterprise_id])->first()->get('name');
        $this->set(compact('me', 'enterprise'));
        // アクセス制限
        $user = $this->Users->get($id);
        $this->Authorization->authorize($user, 'view');

        if ($this->request->is('post')) {
            // 同じ社員IDを持ったユーザーがいないかの確認
            $employee_id = $this->request->getData('employee_id');
            $res = $this->Users->find('all')->where([
                'enterprise_id' => $me->enterprise_id,
                'employee_id'   => $employee_id,
                'not' => ['id' => $id],
            ])->first();
            if($res == null){


                $user = $this->Users->get($id);
                // 3.4.0 より前は $this->request->data() が使われました。
                $user = $this->Users->patchEntity($user, $this->request->getData());

                // 誕生日のみ連結処理が必要
                $year = $this->request->getData("birthday-year");
                $month = $this->request->getData("birthday-month");
                $date = $this->request->getData("birthday-date");
                $user->birthday = $year.'-'.$month.'-'.$date;

                if ($this->Users->save($user)) {
                    $this->Flash->success(__('更新しました'));
                    return $this->redirect(['controller' => 'admin', 'action' => 'index']);
                }
                $this->Flash->error(__('社員更新に失敗しました'));
            }else{
                $this->Flash->error(__('同じ社員IDが既に存在します'));
            }
        }else{
            // 初めに動く処理
            // idが合致するユーザー情報を取得
            $user = $this->Users->find('all')->where(['id' => $id])->first();
            $this->set(compact('user'));
        }
    }

    public function works($id, $month = null, $year = null)
    {
        // 自分の情報と企業情報をViewに送信
        $me = $this->Authentication->getIdentity();
        $enterprise = $this->Enterprises->find('all')->where(['id'=>$me->enterprise_id])->first()->get('name');
        $this->set(compact('me', 'enterprise'));
        // アクセス制限
        $this->loadModel('Users');
        $user = $this->Users->get($id);
        $this->Authorization->authorize($user, 'view');
        
        $this->loadModel('Users');
        $user = $this->Users->find('all')->where(['id'=> $id])->first();
        $dates = $this->PuncheData->getMonthlyData($id, $month, $year);
        $this->set(compact('dates', 'id', 'user'));

    }

    public function editwork($id, $date)
    {
        // 自分の情報と企業情報をViewに送信
        $me = $this->Authentication->getIdentity();
        $enterprise = $this->Enterprises->find('all')->where(['id'=>$me->enterprise_id])->first()->get('name');
        $this->set(compact('me', 'enterprise'));
        // アクセス制限
        $this->loadModel('Users');
        $user = $this->Users->get($id);
        $this->Authorization->authorize($user, 'view');
        
        // データベース登録処理
        if ($this->request->is('post')) {
            $this->loadModel('Punches');
            $data = $this->request->getData();
            $times = $this->PuncheData->getPunchedData($id, $date);

            // 削除処理
            if(isset($data['delete'])){
                /* --------------- 追加機能 エスケープ処理 (1/3) ここから --------------- */
                    // 休憩開始 又は 出勤 レコードを削除する場合
                    // 休憩終了 及び 退勤 レコードのほうが多くならないことを確認
                    if($data['identify'] == 1){
                        $start_work = $this->PuncheData->getPunchedData($id, $date, 1)->count();
                        $end_work = $this->PuncheData->getPunchedData($id, $date, 4)->count();
                        if(($start_work - 1) < $end_work){
                            $this->Flash->error(__('出勤レコードよりも退勤レコードが多くなるため削除できません'));
                            return $this->redirect('/admin/works/'.$id.'/edit/'.$date);
                            exit();
                        }
                    }
                    if($data['identify'] == 2){
                        $start_break = $this->PuncheData->getPunchedData($id, $date, 2)->count();
                        $end_break = $this->PuncheData->getPunchedData($id, $date, 3)->count();
                        if(($start_break - 1) < $end_break){
                            $this->Flash->error(__('休憩開始レコードよりも休憩終了レコードが多くなるため削除できません'));
                            return $this->redirect('/admin/works/'.$id.'/edit/'.$date);
                            exit();
                        }
                    }
                /* --------------- 追加機能 エスケープ処理 (1/3) ここまで --------------- */

                // 削除処理
                $punch = $this->Punches->get($data['id']);
                $punch->info = 9;
                if ($this->Punches->save($punch)) {
                    $this->Flash->success(__('削除しました'));
                    return $this->redirect('/admin/works/'.$id.'/edit/'.$date);
                }else{
                    $this->Flash->error(__('削除に失敗しました'));
                }
            }
            // 更新処理
            if(isset($data['update'])){
                /* --------------- 追加機能 エスケープ処理 (2/3) ここから --------------- */
                    // 更新後のデータの数を調べる
                    $array = [
                        1 => $this->PuncheData->getPunchedData($id, $date, 1)->count(),
                        2 => $this->PuncheData->getPunchedData($id, $date, 2)->count(),
                        3 => $this->PuncheData->getPunchedData($id, $date, 3)->count(),
                        4 => $this->PuncheData->getPunchedData($id, $date, 4)->count(),
                    ];
                    $array[$data['old_identify']] -= 1;
                    $array[$data['identify']] += 1;
                    // 休憩開始 又は 出勤 レコードを削除する場合
                    // 休憩終了 及び 退勤 レコードのほうが多くならないことを確認
                    if($array[1] < $array[4]){
                        $this->Flash->error(__('出勤レコードよりも退勤レコードが多くなるため更新できません'));
                        return $this->redirect('/admin/works/'.$id.'/edit/'.$date);
                        exit();
                    }
                    if($array[2] < $array[3]){
                        $this->Flash->error(__('休憩開始レコードよりも休憩終了レコードが多くなるため更新できません'));
                        return $this->redirect('/admin/works/'.$id.'/edit/'.$date);
                        exit();
                    }
                    // 休憩終了 及び 退勤 レコードの登録時に
                    // 休憩終了 及び 退勤 レコードの数が
                    // 休憩開始 及び 出勤 レコードの数を上回る事がないように
                    if($array[1] < $array[4]){
                        $this->Flash->error(__('出勤レコードよりも退勤レコードが多くなるためレコードを更新できません'));
                        return $this->redirect('/admin/works/'.$id.'/edit/'.$date);
                        exit();
                    }
                    if($array[2] < $array[3]){
                        $this->Flash->error(__('休憩開始レコードよりも休憩終了レコードが多くなるためレコードを更新できません'));
                        return $this->redirect('/admin/works/'.$id.'/edit/'.$date);
                        exit();
                    }
                    // 出勤日は編集中の日限定
                    //if($data['date'])
                    if($data['identify'] == 1){
                        if(strtotime($data['date']) != strtotime($data['date'])){
                            $this->Flash->error(__('日付が適切ではありません'));
                            return $this->redirect('/admin/works/'.$id.'/edit/'.$date);
                        }
                    }
                    // 未来のデータ登録を拒否
                    if(strtotime($data['date'].' '.$data['time']) >= strtotime(date('Y-m-d H:i:s'))){
                        $this->Flash->error(__('現在時刻より先のデータは設定できません'));
                        return $this->redirect('/admin/works/'.$id.'/edit/'.$date);
                    }
                /* --------------- 追加機能 エスケープ処理 (2/3) ここまで --------------- */
                // 元データを削除済みに変更
                $punche_old = $this->Punches->get($data['id']);
                $punche_old->info = 9;
                if ($this->Punches->save($punche_old)) {
                    $this->Flash->success(__('削除しました'));
                }else{
                    $this->Flash->error(__('削除に失敗しました'));
                }
                // 更新データの登録
                $punch_date = substr($date, 0, 4).'/'.substr($date, 4, 2).'/'.substr($date, 6, 2);
                $punche_new = $this->Punches->newEmptyEntity();
                $punche_new->user_id = $id;
                $punche_new->date = $punch_date;
                $punche_new->time = $data['date'].' '.$data['time'];
                $punche_new->identify = $data['identify'];
                $punche_new->info = 2;
                if ($this->Punches->save($punche_new)) {
                    $this->Flash->success(__('更新しました'));
                    return $this->redirect('/admin/works/'.$id.'/edit/'.$date);
                }else{
                    $this->Flash->error(__('更新に失敗しました'));
                }
            }
            // レコード追加処理
            if(isset($data['insert'])){
                /* --------------- 追加機能 エスケープ処理 (3/3) ここから --------------- */
                    // 休憩終了 及び 退勤 レコードの登録時に
                    // 休憩終了 及び 退勤 レコードの数が
                    // 休憩開始 及び 出勤 レコードの数を上回る事がないように
                    if($data['identify'] == 4){
                        $start_work = $this->PuncheData->getPunchedData($id, $date, 1)->count();
                        $end_work = $this->PuncheData->getPunchedData($id, $date, 4)->count();
                        if(($start_work - 1) < $end_work){
                            $this->Flash->error(__('出勤レコードよりも退勤レコードが多くなるためレコードを追加できません'));
                            return $this->redirect('/admin/works/'.$id.'/edit/'.$date);
                            exit();
                        }
                    }
                    if($data['identify'] == 3){
                        $start_break = $this->PuncheData->getPunchedData($id, $date, 2)->count();
                        $end_break = $this->PuncheData->getPunchedData($id, $date, 3)->count();
                        if(($start_break - 1) < $end_break){
                            $this->Flash->error(__('休憩開始レコードよりも休憩終了レコードが多くなるためレコードを追加できません'));
                            return $this->redirect('/admin/works/'.$id.'/edit/'.$date);
                            exit();
                        }
                    }
                    // 出勤日は編集中の日限定
                    //if($data['date'])
                    if($data['identify'] == 1){
                        if(strtotime($data['date']) != strtotime($data['date'])){
                            $this->Flash->error(__('日付が適切ではありません'));
                            return $this->redirect('/admin/works/'.$id.'/edit/'.$date);
                        }
                    }
                    // 未来のデータ登録を拒否
                    if(strtotime($data['date'].' '.$data['time']) >= strtotime(date('Y-m-d H:i:s'))){
                        $this->Flash->error(__('現在時刻より先のデータは設定できません'));
                        return $this->redirect('/admin/works/'.$id.'/edit/'.$date);
                    }
                /* --------------- 追加機能 エスケープ処理 (3/3) ここまで --------------- */
                // 新規レコードの追加
                $punch_date = substr($date, 0, 4).'/'.substr($date, 4, 2).'/'.substr($date, 6, 2);
                $punche_new = $this->Punches->newEmptyEntity();
                $punche_new->user_id = $id;
                $punche_new->date = $punch_date;
                $punche_new->time = $data['date'].' '.$data['time'];
                $punche_new->identify = $data['identify'];
                $punche_new->info = 2;
                if ($this->Punches->save($punche_new)) {
                    $this->Flash->success(__('追加しました'));
                    return $this->redirect('/admin/works/'.$id.'/edit/'.$date);
                }else{
                    $this->Flash->error(__('追加に失敗しました'));
                }
            }
        }



        // 該当する打刻データを取得して、Viewに送信
        $user = $this->Users->find('all')->where(['id'=> $id])->first();
        $times = $this->PuncheData->getPunchedData($id, $date);
        
        $this->set(compact('times', 'date', 'user'));

    }

}