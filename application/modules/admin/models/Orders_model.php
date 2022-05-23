<?php



class Orders_model extends CI_Model

{



    public function __construct()

    {

        parent::__construct();

    }



    public function ordersCount($onlyNew = false)

    {

        if ($onlyNew == true) {

            $this->db->where('viewed', 0);

        }

        return $this->db->count_all_results('orders');

    }



    public function orders($limit, $page, $order_by)

    {

        if ($order_by != null) {

            $this->db->order_by($order_by, 'DESC');

        } else {

            $this->db->order_by('id', 'DESC');

        }

        $this->db->select('orders.*, orders_clients.first_name,'

                . ' orders_clients.last_name, orders_clients.email, orders_clients.shipping_phone, '

                . 'orders_clients.shipping_address, orders_clients.shipping_city, orders_clients.shipping_state, orders_clients.shipping_post_code,'

                . ' orders_clients.notes, discount_codes.type as discount_type, discount_codes.amount as discount_amount');

        $this->db->join('orders_clients', 'orders_clients.for_id = orders.id', 'inner');

        $this->db->join('discount_codes', 'discount_codes.code = orders.discount_code', 'left');

        $result = $this->db->get('orders', $limit, $page);

        return $result->result_array();

    }



    public function changeOrderStatus($id, $to_status)

    {

        $this->db->where('id', $id);

        $this->db->select('processed');

        $result1 = $this->db->get('orders');

        $res = $result1->row_array();



        $result = true;

        if ($res['processed'] != $to_status) {

            $this->db->where('id', $id);

            $result = $this->db->update('orders', array('processed' => $to_status, 'viewed' => '1'));

            if ($result == true) {

                $this->manageQuantitiesAndProcurement($id, $to_status, $res['processed']);

            }

        }

        return $result;

    }



    private function manageQuantitiesAndProcurement($id, $to_status, $current)

    {

        if (($to_status == 0 || $to_status == 2) && $current == 1) {

            $operator = '+';

            $operator_pro = '-';

        }

        if ($to_status == 1) {

            $operator = '-';

            $operator_pro = '+';

        }

        $this->db->select('products');

        $this->db->where('id', $id);

        $result = $this->db->get('orders');

        $arr = $result->row_array();

        $products = unserialize($arr['products']);

        foreach ($products as $product) {

                if (isset($operator)) {

                    if (!$this->db->query('UPDATE products SET quantity=quantity' . $operator . $product['product_quantity'] . ' WHERE id = ' . $product['product_info']['id'])) {

                        log_message('error', print_r($this->db->error(), true));

                        show_error(lang('database_error'));

                    }

                }

                if (isset($operator_pro)) {

                    if (!$this->db->query('UPDATE products SET procurement=procurement' . $operator_pro . $product['product_quantity'] . ' WHERE id = ' . $product['product_info']['id'])) {

                        log_message('error', print_r($this->db->error(), true));

                        show_error(lang('database_error'));

                    }

                } 

        }

    }



    public function setBankAccountSettings($post)

    {

        $query = $this->db->query('SELECT id FROM bank_accounts');

        if ($query->num_rows() == 0) {

            $id = 1;

        } else {

            $result = $query->row_array();

            $id = $result['id'];

        }

        $post['id'] = $id;

        if (!$this->db->replace('bank_accounts', $post)) {

            log_message('error', print_r($this->db->error(), true));

            show_error(lang('database_error'));

        }

    }



    public function getBankAccountSettings()

    {

        $result = $this->db->query("SELECT * FROM bank_accounts LIMIT 1");

        return $result->row_array();

    }

	

	public function getFurOrders()

    {

		 //$this->db->where('entry_type', 'contact');

        $result = $this->db->get('orders_fur');

        return $result->result_array();

    }

    public function getOrder($id)

    {

        $this->db->select('*');

        $this->db->where('id', $id);

        $query = $this->db->get('orders');

        if ($query->num_rows() > 0) {

            return $query->row_array();

        } else {

            return false;

        }

    }

    public function deleteOrder($id)

    {

        if (!$this->db->where('id', $id)->delete('orders')) {

            log_message('error', print_r($this->db->error(), true));

            show_error(lang('database_error'));

        }

    }

    

	public function getmatcat($product)

    {

        $this->db->select('*');

        $this->db->where('id', $product);

        $result = $this->db->get('material_design_products');

        return $result->row_array();

    }

	public function getProduct($p_id)

    {

        $this->db->select('*');

        $this->db->where('id', $p_id);

        $result = $this->db->get('products');

        return $result->row_array();

    }

	public function getProduct_info($p_id)

    {

        $this->db->select('*');

        $this->db->where('for_id', $p_id);

        $result = $this->db->get('products_translations');

        return $result->row_array();

    }

	

	public function getCats($c_id)

    {

        $this->db->select('*');

        $this->db->where('for_id', $c_id);

        $result = $this->db->get('shop_categories_translations');

        return $result->row_array();

    }

	

	public function getDesigner($designer_id)

    {

        $this->db->select('*');

        $this->db->where('id', $designer_id);

        $result = $this->db->get('designers');

        return $result->row_array();

    }

	

	public function getBrand($brand_id)

    {

        $this->db->select('*');

        $this->db->where('id', $brand_id);

        $result = $this->db->get('brands');

        return $result->row_array();

    }

    function getOrderByJoin($id){

        $this->db->select('*');

        $this->db->from('orders');

        $this->db->join('orders_clients','orders_clients.for_id = orders.id');

        $this->db->where('orders_clients.for_id', $id);

        $result = $this->db->get();

        return $result->row_array();

    }
    
    function getOrderByOrderId($id){

        $this->db->select('*');

        $this->db->from('order_items');

        $this->db->where('order_id', $id);

        $result = $this->db->get();
        return $result->result_array();

    }


}

