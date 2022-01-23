<?php

namespace System\NativeQuery;

class NativeQuery
{
    protected $db;

    public function __construct(\PDO $pdo)
    {
        $this->db = $pdo;
    }

    public function query($query, $return = true)
    {
        $sql = $this->db->query($query);

        if ($return) {
            $sql->execute();
            return $sql->fetchAll(\PDO::FETCH_OBJ);
        }
    }

    public function prepare($query, $data = [], $return = true)
    {
        $sql = $this->db->prepare($query);
        $sql->execute($data);

        if ($return) {
            return $sql->fetchAll(\PDO::FETCH_OBJ);
        }
    }

    public function insert($query, $data = [])
    {
        $sql = $this->db->prepare($query);
        $sql->execute($data);
        return $sql;
    }

    public function queryGetOne($query)
    {
        $sql = $this->db->query($query);
        $sql->execute();

        return (object) $sql->fetch(\PDO::FETCH_OBJ);
    }

    public function all()
    {
        $sql = $this->db->prepare("SELECT * FROM {$this->table}");
        $sql->execute();
        return (object) $sql->fetchAll(\PDO::FETCH_OBJ);
    }

    public function save(array $data)
    {
        if ($this->timestamps) {
            $data['created_at'] = date('Y/m/d H:i:s');
        }

        foreach ($data as $key => $list) {
            $fields[] = $key;
            $values[] = $list;
        }

        $fields = implode(", ", $fields);
        $values = "'" . implode("','", $values) . "'";

        if ($this->db->query("INSERT INTO {$this->table} ({$fields}) VALUES ({$values})")) {
            return $this->lastId();
        }

        return false;
    }

    public function update(array $data, $id, $field_name = false)
    {
        if ($this->timestamps) {
            $data['updated_at'] = date('Y/m/d H:i:s');
        }

        $id = (int) $id;
        $primary_key_name = 'id';

        if ($field_name) {
            $primary_key_name = $field_name;
        }

        # Prepare the fields
        $set = "set";
        foreach ($data as $key => $item) {
            $set .= " " . $key . " = " . "?" . ", ";
        }

        $set_size = strlen($set);
        $token = substr($set, -$set_size, -2);
        $token .= " WHERE {$primary_key_name} = " . "?";

        # prepare the values
        $values = "";
        foreach ($data as $item) {
            $values .= $item . ", ";
        }

        $values .= $id;
        $data[] = $id;

        $comma_explode = array();
        foreach ($data as $item) {
            $comma_explode[] = $item;
        }

        # Execute the update
        $edit = $this->db->prepare("UPDATE {$this->table} {$token}");
        return $edit->execute($comma_explode);
    }

    /**
     * Find an archive in database by field id
     *
     * @param id : int : Id of the archive in the database
     * @return mixed or an boolean
     */

    public function find($id = 0)
    {
        $id = (int) $id;
        $query = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $query->execute(array($id));
        return $query->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * Find an archive in database by field of the archive and compare with value
     *
     * @param field : mixed : Field of the archive in the database
     * @param value : mixed : Value that i want compare with value in the database
     * @return stdClass or an boolean
     */

    public function findBy($field = null, $value = null)
    {
        $query = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$field} = ?");
        $query->execute(array($value));
        return $query->fetch(\PDO::FETCH_OBJ);
    }

    public function lastId()
    {
        return $this->db->lastInsertId();
    }
}
