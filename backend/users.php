<?php
class Users
{
    public function getById($db,$id)
    {
        $query = $db -> query('SELECT * FROM users WHERE ID='.$id);
        if ($query) {
            $result = $query -> fetch_all(MYSQLI_ASSOC);
            return array_shift($result);
        }
        return [];
    }
}
