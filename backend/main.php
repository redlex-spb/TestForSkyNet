<?php
require_once 'rest.php';
require_once 'db.php';
require_once 'users.php';
require_once 'services.php';
require_once 'tarifs.php';

class Main extends Rest
{
    /**
     * Метод GET
     * Просмотр тарифов
     * @return mixed
     */
    public function viewTarifs()
    {
        $userID = array_shift($this->requestUri);

        if($userID){
            $db = (new Db())->getConnect();
            $user = Users::getById($db, $userID);
            if(!empty($user)){
                if(array_shift($this->requestUri) == 'services'){
                    $serviceID = array_shift($this->requestUri);
                    $service = Services::getById($db, $serviceID);
                    if(!empty($service)){
                        if(array_shift($this->requestUri) == 'tarifs'){
                            $tarif = Tarifs::getById($db,$service['tarif_id']);
                            $tarifs = Tarifs::getTarifsByGroupID($db,$tarif['tarif_group_id']);
                            if(!empty($tarif) && !empty($tarifs)){
                                $result = [
                                    "result"=>"ok",
                                    "tarifs"=>[
                                        "title" => $tarif["title"],
                                        "link" => $tarif["link"],
                                        "speed" => $tarif["speed"],
                                        "tarifs" => $tarifs,
                                    ]
                                ];
                                $ans = ["data"=>$result,"code"=>200];
                            }
                        }
                    }else{
                        $ans = ["data"=>'Services not found',"code"=>404];
                    }
                }
            }else{
                $ans = ["data"=>'User not found',"code"=>404];
            }
        }
        Db::closeConnect($db);
        return !empty($ans) ? $this->response($ans['data'], $ans['code']) : $this->response('API Not Found', 404);
    }

    /**
     * Метод POST
     * Создание новой записи
     * @return mixed
     */
    public function createService()
    {
        $userID = array_shift($this->requestUri);

        if($userID){
            $db = (new Db())->getConnect();
            $user = Users::getById($db, $userID);
            if(!empty($user)){
                if(array_shift($this->requestUri) == 'services'){
                    $serviceID = array_shift($this->requestUri);
                    $service = Services::getById($db, $serviceID);
                    if(empty($service)){
                        if(array_shift($this->requestUri) == 'tarif'){
                            $tarifID = $this->requestParams['tarif_id'] ?? '';
                            if(!empty($tarifID)){
                                $service = new Services($db, [
                                    'ID' => $serviceID,
                                    'user_id' => $userID,
                                    'tarif_id' => $tarifID,
                                    'payday' => date('Y-m-d',time())
                                ]);
                                if($service->saveNew()){
                                    $ans = ["data"=>["result"=>"ok"],"code"=>200];
                                }
                            }
                            $ans = ["data"=>["result"=>"error"],"code"=>500];
                        }
                    }else{
                        $ans = ["data"=>'Service already exists',"code"=>404];
                    }
                }
            }else{
                $ans = ["data"=>'User not found',"code"=>404];
            }
        }
        Db::closeConnect($db);
        return !empty($ans) ? $this->response($ans['data'], $ans['code']) : $this->response('API Not Found', 404);
    }

}
