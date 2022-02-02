<?php

class Model extends CI_Model
{
    private function _get_datatables_query($main_table, $column_select, $column_search, $column_order, $order_by, $group_by, $join_table, $filter_data, $filter_array)
    {

        // Join Tabel
        $this->db->select($column_select);
        $this->db->from($main_table);

        if (!empty($join_table)) {
            foreach ($join_table as $key => $value) {
                if (!empty($value)) {
                    $this->db->join($key, $value);
                }
            }
        }

        // Filter Tabel
        if (!empty($filter_data)) {
            foreach ($filter_data as $key => $value) {
                if (!empty($value)) {
                    $this->db->where($key, $value);
                }
            }
        }

        if (!empty($filter_array)) {
            foreach ($filter_array as $key => $value) {
                if (!empty($value)) {
                    $this->db->where_in($key, $value);
                }
            }
        }

        if (!empty($group_by)) {
            $this->db->group_by($group_by);
        }
        
        // Cari Data
        $i = 0;
        foreach ($column_search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($column_search) - 1 == $i) {
                    $this->db->group_end();
                }
            }
            $i++;
        }

        // Order kolom
        if (isset($_POST['order'])) {
            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } elseif (isset($order_by)) {
            $order = $order_by;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    // Membuat Datatables
    public function make_datatables($main_table, $column_select, $column_search, $column_order, $order_by, $group_by, $join_table,  $filter_data, $filter_array)
    {
        $this->_get_datatables_query($main_table, $column_select, $column_search, $column_order, $order_by, $group_by, $join_table,  $filter_data, $filter_array);
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }

        return $this->db->get()->result();
    }

    // Menghitung Data yang terfilter
    public function count_filtered($main_table, $column_select, $column_search, $column_order, $order_by, $group_by, $join_table,  $filter_data, $filter_array)
    {
        $this->_get_datatables_query($main_table, $column_select, $column_search, $column_order, $order_by, $group_by, $join_table,  $filter_data, $filter_array);
        return $this->db->get()->num_rows();
    }

    // Menghitung Semua Data
    public function count_all($main_table)
    {
        return $this->db->from($main_table)->count_all_results();
    }

        // Menghitung Semua Data
    public function count_where($main_table, $params)
    {
        return $this->db->where($params)->count_all_results($main_table);
    }

    // Mengambil Semua data
    public function get_all($main_table){
        return $this->db->get($main_table);
    }

    // Mengambil data berdasarkan id
    public function get_where($main_table, $params){
        return $this->db->where($params)->get($main_table);
    }

    // Input Data
    public function insert($main_table, $data){
        return $this->db->insert($main_table, $data);
    }

    public function insert_batch($main_table, $data){
        return $this->db->insert_batch($main_table, $data);
    }

    // Update Data
    public function update($main_table, $data, $id){
        return $this->db->where($id)->update($main_table, $data);
    }

    // Hapus Data
    public function delete($main_table, $id){
        return $this->db->where($id)->delete($main_table);
    }
}
