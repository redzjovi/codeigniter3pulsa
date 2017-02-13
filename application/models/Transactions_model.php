<?php

class Transactions_model extends CI_Model {
    var $primary_key = 'transaction_id';
    var $table_name = 'transactions';

	public function add($param)
    {
        $format_datetime_php = $this->Settings_model->setting_value_by_code('format_datetime_php')->setting_value;

        $transaction_date = DateTime::createFromFormat($format_datetime_php, $param['transaction_date']);
		$transaction_date = $transaction_date->format('Y-m-d H:i:s');

		$data = $this->Prices_model->edit_by_param(array(
			'price_id' => $param['price_id'],
			'admin_id' => $param['admin_id']
		));

		$array_insert = array(
			'transaction_date' => $transaction_date,
			'admin_id' => $param['admin_id'],
			'name' => $param['name'],
			'phone_number' => $param['phone_number'],
			'operator_id' => $param['operator_id'],
			'price_id' => $param['price_id'],
			'price' => $data->price,
			'buy_price' => $data->buy_price,
			'sell_price' => $param['sell_price'],
			'status' => $param['status']
		);
		$this->db->insert($this->table_name, $array_insert);
    }

	public function edit($param)
    {
		$format_datetime_php = $this->Settings_model->setting_value_by_code('format_datetime_php')->setting_value;

        $date = DateTime::createFromFormat($format_datetime_php, $param['transaction_date']);
        $transaction_date = $date->format('Y-m-d H:i:s');

		$data = $this->Prices_model->edit_by_param(array(
			'price_id' => $param['price_id'],
			'admin_id' => $param['admin_id']
		));

		$array_update = array(
			'transaction_date' => $transaction_date,
			'admin_id' => $param['admin_id'],
			'name' => $param['name'],
			'phone_number' => $param['phone_number'],
			'operator_id' => $param['operator_id'],
			'price_id' => $param['price_id'],
			'price' => $data->price,
			'buy_price' => $data->buy_price,
			'sell_price' => $param['sell_price'],
			'status' => $param['status']
		);
		// debugvar($param);
		// debugvar($array_update); die;

        $this->db->set($array_update);
		$this->db->where($this->primary_key, $param['transaction_id']);
		$this->db->where($this->Admins_model->primary_key, $param['admin_id']);
        $this->db->update($this->table_name);
    }

    public function edit_by_param($data)
	{
		return $this->db->get_where($this->table_name, array(
			$this->primary_key => $data['transaction_id'],
			$this->Admins_model->primary_key => $data['admin_id']
		) )->row();
	}

	public function get_stats($id)
	{
		$data = $this->Settings_model->setting_value_by_code('transactions_label_status_paid');
		$paid = $data->setting_value;
		$data = $this->Settings_model->setting_value_by_code('transactions_label_status_unpaid');
		$unpaid = $data->setting_value;

		$this->db->select('count(if(t.status = '.$paid.', t.'.$this->primary_key.', null)) as count_paid');
		$this->db->select('sum(if(t.status = '.$paid.', t.sell_price, 0)) as total_paid');
		$this->db->select('count(if(t.status = '.$unpaid.', t.'.$this->primary_key.', null)) as count_unpaid');
		$this->db->select('sum(if(t.status = '.$unpaid.', t.sell_price, 0)) as total_unpaid');
		$this->db->select('count(t.'.$this->primary_key.') as count_total');
		$this->db->select('sum(t.sell_price) as total');
		$this->db->select('count(if(t.status = '.$paid.', t.'.$this->primary_key.', null)) as count_profit');
		$this->db->select('sum(if(t.status = '.$paid.', (t.sell_price) - (t.buy_price), 0)) as total_profit');
		$this->db->where('admin_id', $id);
		$data = $this->db->get($this->table_name.' as t')->row();

		return $data;
	}

	public function get_transaction_history_chart($id)
	{
		$format_datetime_sql = $this->Settings_model->setting_value_by_code('format_date_sql')->setting_value;
		$paid = $this->Settings_model->setting_value_by_code('transactions_label_status_paid')->setting_value;

		// $this->db->select('DATE_FORMAT(transaction_date, "'.$format_datetime_sql.'") as date');
        $this->db->select('DATE(transaction_date) as transaction_date');
		$this->db->select('sum(sell_price) as value');
		$this->db->select('count(sell_price) as count_paid');
		$this->db->select('sum(sell_price) as total_paid');
		$this->db->select('sum(sell_price - buy_price) as total_profit');
		$this->db->where('date(transaction_date) >=', '(DATE_FORMAT(CURDATE(), "%Y-%m-01") - INTERVAL 3 MONTH)');
		$this->db->where('admin_id', $id);
		$this->db->where('status', $paid);
		$this->db->group_by('date(transaction_date)');
		$data = $this->db->get($this->table_name)->result_array();

		return $data;
	}

	public function list_all($param)
    {
		if (!empty($param['transaction_date']))
		{
			$format_datetime_php = $this->Settings_model->setting_value_by_code('format_datetime_php')->setting_value;
            $transaction_date = explode(' - ', $param['transaction_date']);

            $date = DateTime::createFromFormat($format_datetime_php, $transaction_date[0]);
		    $transaction_date_from = $date->format('Y-m-d H:i:s');

			$date = DateTime::createFromFormat($format_datetime_php, $transaction_date[1]);
		    $transaction_date_to = $date->format('Y-m-d H:i:s');
		}

        $this->db->select('o.operator_name, t.*');
        $this->db->from($this->table_name.' as t');
		$this->db->join($this->Operators_model->table_name.' as o', 'o.'.$this->Operators_model->primary_key.' = t.operator_id', 'left');
		if (!empty($param['transaction_date']))
		{
			$this->db->where('transaction_date >=', $transaction_date_from);
			$this->db->where('transaction_date <=', $transaction_date_to);
		}
		$this->db->where('t.admin_id', $param['admin_id']);
		$this->db->like('t.name', $param['name']);
		$this->db->like('o.operator_name', $param['operator_name']);
		$this->db->like('t.price', $param['price']);
		$this->db->like('t.status', $param['status']);
		$data['total'] = $this->db->count_all_results();

		$this->db->select('o.operator_name, t.*');
        $this->db->from($this->table_name.' as t');
		$this->db->join($this->Operators_model->table_name.' as o', 'o.'.$this->Operators_model->primary_key.' = t.operator_id', 'left');
		if (!empty($param['transaction_date']))
		{
			$this->db->where('transaction_date >=', $transaction_date_from);
			$this->db->where('transaction_date <=', $transaction_date_to);
		}
		$this->db->where('t.admin_id', $param['admin_id']);
		$this->db->like('t.name', $param['name']);
		$this->db->like('o.operator_name', $param['operator_name']);
		$this->db->like('t.price', $param['price']);
		$this->db->like('t.status', $param['status']);
        $this->db->order_by($param['sort'], $param['order']);
        if (isset($param['limit']))
		{
			$param['offset'] = ( ($param['offset'] >= $data['total'] && $data['total'] > 0) ? ($param['offset'] - $param['limit']) : $param['offset']);
			$this->db->limit($param['limit'], $param['offset']);
		}
        $data['rows'] = $this->db->get()->result();

		return $data;
    }

    public function remove($data)
	{
		$this->db->where($this->primary_key, $data['id']);
		$this->db->where($this->Admins_model->primary_key, $data['admin_id']);
		$this->db->delete($this->table_name);
	}

}

?>