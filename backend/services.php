<?php
class Services
{
    protected $db;
    public $serviceID;
    public $userID;
    public $tarifID;
    public $payday;

    public function __construct($db,$data)
    {
        $this->db = $db;
        $this->serviceID = (int)$data['ID'];
        $this->userID = (int)$data['user_id'];
        $this->tarifID = (int)$data['tarif_id'];
        $this->payday = (string)$data['payday'];
    }

    public function getById($db,$id)
    {
        $query = $db -> query('SELECT * FROM services WHERE ID='.$id);
        if ($query) {
            $result = $query -> fetch_all(MYSQLI_ASSOC);
            return array_shift($result);
        }
        return [];
    }

    public function saveNew()
    {
        $stmt  = $this->db->prepare("INSERT INTO services (`ID`,`user_id`, `tarif_id`,`payday`) VALUES (?,?,?,?) ");
        $stmt -> bind_param("iiis", $this->serviceID ,$this->userID, $this->tarifID, $this->payday);
        $result = $stmt -> execute();
        $stmt -> close();
        if ($result) return $result;
        return false;
    }
}
