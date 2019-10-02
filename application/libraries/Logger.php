<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Logger {

  private $tableName    = 'logger';
  private $table_fields = array(
		'item_id'              => 'item_id',
		'user_id'              => 'user_id',
		'created_by'           => 'created_by',
		'transaction_date'     => 'transaction_date',
		'transaction_id'       => 'transaction_id',
		'supplier_customer_id' => 'supplier_customer_id',
		'warehouse_id'         => 'warehouse_id',
		'type'                 => 'type',
		'stock_in'             => 'stock_in',
		'stock_out'            => 'stock_out',
		'remarks'              => 'remarks',
		'quantity'             => 'quantity',
		'discount'             => 'discount',
		'balance'              => 'balance',
    'unit_cost'            => 'unit_cost',
  );

	
  private $ci; //Codeigniter Instance
	private $item_id;
  private $user_id              = 0;
	private $created_by           = '';
	private $transaction_id       = 0;
	private $supplier_customer_id = 0;
	private $warehouse_id         = 0;
	private $type                 = '';
	private $stock_in             = 0;
	private $stock_out            = 0;
	private $remarks              = '';
	private $quantity             = 0;
	private $discount             = 0;
	private $balance              = 0;
  private $unit_cost              = 0;
	private $transaction_date;

  /**
   * Intilize Codeigniter
   */

  public function __construct() {
    $this->ci = &get_instance();
  }
  
  public function item($item_id) {
    $this->item_id = $item_id;
    return $this;
  }
  public function user($user_id) {
    $this->user_id = $user_id;
    return $this;
  }
  public function user_name($created_by) {
    $this->created_by = $created_by;
    return $this;
  }
  public function transaction_id($transaction_id) {
    $this->transaction_id = $transaction_id;
    return $this;
  }
	public function supplier_customer($supplier_customer_id) {
    $this->supplier_customer_id = $supplier_customer_id;
    return $this;
  }
	public function warehouse($warehouse_id) {
    $this->warehouse_id = $warehouse_id;
    return $this;
  }
  public function type($type) {
    $this->type = $type;
    return $this;
  }
  public function stock_in($stock_in) {
    $this->stock_in = $stock_in;
    return $this;
  }
  public function stock_out($stock_out) {
    $this->stock_out = $stock_out;
    return $this;
  }
  public function remarks($remarks) {
    $this->remarks = $remarks;
    return $this;
  }
  public function quantity($quantity) {
    $this->quantity = $quantity;
    return $this;
  }
  public function discount($discount) {
    $this->discount = $discount;
    return $this;
  }
  public function transaction_date($transaction_date) {
    $this->transaction_date = $transaction_date;
    return $this;
  }
  public function balance($balance) {
    $this->balance = $balance;
    return $this;
  }
  public function unit_cost($unit_cost) {
    $this->unit_cost = $unit_cost;
    return $this;
  }
  /**
   * Add Log, as Database Entry
   * @param void
   * @return void
   */
  public function log() {
    $data        = array(
				$this->table_fields['item_id']              => $this->item_id,
				$this->table_fields['user_id']              => $this->user_id,
				$this->table_fields['created_by']           => $this->created_by,
				$this->table_fields['transaction_date']     => $this->transaction_date,
				$this->table_fields['transaction_id']       => $this->transaction_id,
				$this->table_fields['supplier_customer_id'] => $this->supplier_customer_id,
				$this->table_fields['warehouse_id']         => $this->warehouse_id,
				$this->table_fields['type']                 => $this->type,
				$this->table_fields['stock_in']             => $this->stock_in,
				$this->table_fields['stock_out']            => $this->stock_out,
				$this->table_fields['remarks']              => $this->remarks,
				$this->table_fields['quantity']             => $this->quantity,
				$this->table_fields['discount']             => $this->discount,
				$this->table_fields['balance']              => $this->balance,
        $this->table_fields['unit_cost']            => $this->unit_cost,
    );
    $this->ci->db->insert($this->tableName, $data);
    $this->logid = $this->ci->db->insert_id();
    $this->flush_parameter();
  }

  /**
   * Get last Log
   * @return array
   */
  public function last_log() {
    return $this->ci->db->where('id', $this->logid)->get($this->tableName)->row();
  }

  public function item_logs() {
    return $this->ci->db->where('item_id', $this->logid)->get($this->tableName)->results();
  }

  protected function _getQueryMaker() {
    if ($this->created_by)
      $this->ci->db->where($this->table_fields['created_by'], $this->created_by);
    if ($this->type)
      $this->ci->db->where($this->table_fields['type'], $this->type);
    if ($this->type_id)
      $this->ci->db->where($this->table_fields['type_id'], $this->type_id);
    if ($this->token)
      $this->ci->db->where($this->table_fields['token'], $this->token);
    if ($this->logid)
      $this->ci->db->where($this->table_fields['id'], $this->logid);
    if ($this->from_date)
      $this->ci->db->where("{$this->table_fields['timestamp']} >", $this->from_date);
    if ($this->to_date)
      $this->ci->db->where("{$this->table_fields['created_at']} <=", $this->to_date);
  }

  public function get_num() {
    $this->_getQueryMaker();
    return $this->ci->db->from($this->tableName)->count_all_results();
  }

  public function get() {
    $this->_getQueryMaker();
    $result = $this->ci->db->get($this->tableName);
    return $this->_dbcleanresult($result);
  }

  public function remove_log() {
    $this->_getQueryMaker();
    $this->ci->db->delete($this->tableName);
  }

  public function get_ids() {
    $this->_getQueryMaker();
    $ids = $this->ci->db->select('type_id')->get($this->tableName)->result_array();
    return array_column($ids, 'type_id');
  }

  protected function _dbcleanresult($result) {
    if ($result->num_rows() > 1)
      return $result->result();
    if ($result->num_rows() == 1)
      return $result->row();
    else
      return false;
  }

  /**
   * Reset Parameter
   */
  public function flush_parameter() {
		$this->item_id              = 0;
  	$this->user_id              = 0;
		$this->created_by           = '';
		$this->transaction_id       = 0;
		$this->supplier_customer_id = 0;
		$this->warehouse_id         = 0;
		$this->type                 = '';
		$this->stock_in             = 0;
		$this->stock_out            = 0;
		$this->remarks              = '';
		$this->quantity             = 0;
		$this->discount             = 0;
		$this->balance              = 0;
    $this->unit_cost            = 0;
  }

}

?>