<?php
class Tarifs
{
    public function getById($db,$id)
    {
        $query = $db -> query('SELECT * FROM tarifs WHERE ID='.$id);
        if ($query) {
            $result = $query -> fetch_all(MYSQLI_ASSOC);
            return array_shift($result);
        }
        return [];
    }

    public function getTarifsByGroupID($db,$id)
    {
        $query = $db -> query('SELECT ID,title,price,pay_period,speed FROM tarifs WHERE tarif_group_id='.$id);
        if ($query) {
            $result = $query -> fetch_all(MYSQLI_ASSOC);
            foreach ($result as $key=>$item) {
                $result[$key]['new_payday'] = mktime(0, 0, 0, date("m")  , date("d")+$item['pay_period'], date("Y")).date("O");
            }
            return $result;
        }
        return [];
    }
}
