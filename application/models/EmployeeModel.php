 <?php class EmployeeModel extends CI_Model
    {

        public function insertAll($table, $data)
        {

            $this->db->insert($table, $data);
            return $this->db->insert_id();
        }

        public function getAll($table, $id, $order)
        {
            $this->db->order_by($id, $order);
            $qry = $this->db->get($table);
            return $qry->result();
        }

        public function updateRecord($table, $data, $where)
        {

            $this->db->where($where);
            $qry = $this->db->update($table, $data);
            return $qry;
        }

        public function deleteAll($table, $id)
        {

            $this->db->where($id);
            $q = $this->db->delete($table);
            return $q;
        }

        public function getSingleRowByWhere($table, $where)
        {
            $this->db->where($where);
            $qry = $this->db->get($table);
            //echo $this->db->last_query();die;
            return $qry->row();
        }
    }

    ?>
