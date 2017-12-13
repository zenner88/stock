<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/*
| -----------------------------------------------------
| PRODUCT NAME: 	SIMPLE POS
| -----------------------------------------------------
| AUTHER:			MIAN SALEEM 
| -----------------------------------------------------
| EMAIL:			saleem@tecdiary.com 
| -----------------------------------------------------
| COPYRIGHTS:		RESERVED BY TECDIARY IT SOLUTIONS
| -----------------------------------------------------
| WEBSITE:			http://tecdiary.net
| -----------------------------------------------------
|
| MODULE: 			POS
| -----------------------------------------------------
| This is inventories module's model file.
| -----------------------------------------------------
*/


class Pos_model extends CI_Model
{
	
	
	public function __construct()
	{
		parent::__construct();

	}
	
	function getSetting() 
	{
		
		
		$q = $this->db->get('pos_settings'); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}
	
	public function getAllCategories() 
	{
		$q = $this->db->get('categories');
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}

	public function getAllSubCategories() 
	{
		$q = $this->db->get('subcategories');
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}	
			return $data;
		}
	}
	
	public function getNextAI() 
	{
		$this->db->select_max('id');
		$q = $this->db->get('sales');
		if( $q->num_rows() > 0 )
		  {
			$row = $q->row();
			//return SALES_REF."-".date('Y')."-".sprintf("%03s", $row->id+1);
			return SALES_REF."-".sprintf("%04s", $row->id+1);
			
		  } 
				
			return FALSE;

	}
	
	public function updateSetting($data)
	{

			$settingData = array(
				'pro_limit' 				=> $data['pro_limit'],
				'default_category' 			=> $data['category'],
				'default_customer' 		=> $data['customer'],
				'default_biller' 			=> $data['biller'],
				'display_time' 			=> $data['display_time'],
				'cf_title1' 			=> $data['cf_title1'],
				'cf_title2' 			=> $data['cf_title2'],
				'cf_value1' 			=> $data['cf_value1'],
				'cf_value2' 			=> $data['cf_value2']
			);
		
		$this->db->where('pos_id', '1');
		if($this->db->update('pos_settings', $settingData)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function products_count($category_id) {
		$this->db->where('category_id', $category_id)->from('products');

		
        return $this->db->count_all_results();
    }

    public function fetch_products($category_id, $limit, $start) {
        $this->db->limit($limit, $start);
		$this->db->where('category_id', $category_id);
		$this->db->where('menu', 1);
		
		$this->db->order_by("name", "asc"); 
		$query = $this->db->get("products");
		
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
			return $data;
			
		} else{
		
		$this->db->limit($limit, $start);
		$this->db->where('subcategory_id', $category_id);
		$this->db->where('menu', 1);
		
		$this->db->order_by("name", "asc"); 
		$query1 = $this->db->get("products");
		if ($query1->num_rows() > 0) {
            foreach ($query1->result() as $row) {
                $data[] = $row;
            }
            return $data;
		}
	}
        return false;
   }
   
   public function categories_count() {
        return $this->db->count_all("categories");
    }

    public function fetch_categories($limit, $start) {
        $this->db->limit($limit, $start);
		$this->db->order_by("id", "asc"); 
        $query = $this->db->get("categories");

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }
	
	public function getProductsByCode($code) 
	{
		$q = $this->db->query("SELECT * FROM products WHERE code LIKE '%{$code}%' ORDER BY code");
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	
	public function getProductByCode($code) 
	{

		$q = $this->db->get_where('products', array('code' => $code), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}
	
	public function getProductByName($name) 
	{
		$q = $this->db->get_where('products', array('name' => $name), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;
	}
	
	public function getCustomerByName($name) 
	{
		$q = $this->db->get_where('customers', array('name' => $name), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;
	}
	
	public function getAllBillers() 
	{
		$q = $this->db->get('billers');
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	
	public function getBillerByID($id) 
	{

		$q = $this->db->get_where('billers', array('id' => $id), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}
	
	
	public function getAllCustomers() 
	{
		$q = $this->db->get('customers');
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	public function getAllDiscounts() 
	{
		$q = $this->db->get('discounts');
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	public function getDiscountByID($id) 
	{

		$q = $this->db->get_where('discounts', array('id' => $id), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}
	
	public function getCustomerByID($id) 
	{

		$q = $this->db->get_where('customers', array('id' => $id), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}
	
	public function getAllProducts() 
	{
		$q = $this->db->query('SELECT * FROM products ORDER BY id');
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	public function getProductByID($id) 
	{

		$q = $this->db->get_where('products', array('code' => $id), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}

	public function getProductByCf1ID($cf1) 
	{

		// $q = $this->db->get_where('bom', array('idProduk' => $cf1)); 
		//   if( $q->num_rows() > 0 )
		//   {
		// 	return $q->row();
		//   } 
		
		//   return FALSE;

		// $q = $this->db->query('SELECT * FROM bom' );
		// if($q->num_rows() > 0) {
		// 	foreach (($q->result()) as $row) {
		// 		$data[] = $row;
		// 	}
				
		// 	return $data;
		// }
		$this->db->where('idProduk',$cf1);
		$result = $this->db->get('bom');
		return $result->result_array();
	}

	public function getProductByCf2ID($cf2) 
	{

		$q = $this->db->get_where('products', array('id' => $cf2), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}

	public function getProductByCf3ID($cf3) 
	{

		$q = $this->db->get_where('products', array('id' => $cf3), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}
	public function getProductByCf4ID($cf4) 
	{

		$q = $this->db->get_where('products', array('id' => $cf4), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}

	public function getProductByCf5ID($cf5) 
	{

		$q = $this->db->get_where('products', array('id' => $cf5), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}
	
	public function getProductByCf6ID($cf6) 
	{

		$q = $this->db->get_where('products', array('id' => $cf6), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}
	public function getAllTaxRates() 
	{
		$q = $this->db->get('tax_rates');
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	public function getTaxRateByID($id) 
	{

		$q = $this->db->get_where('tax_rates', array('id' => $id), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}
	
	
	public function getAllInvoiceTypes() 
	{
		$q = $this->db->get('invoice_types');
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	public function getAllInvoiceTypesFor() 
	{
		$q = $this->db->get_where('invoice_types', array('type' => 'real'));
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	public function getInvoiceTypeByID($id) 
	{

		$q = $this->db->get_where('invoice_types', array('id' => $id), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}
	
	public function updateProductQuantity($product_id, $warehouse_id, $quantity)
	{

		// update the product with new details
		if($this->addQuantity($product_id, $warehouse_id, $quantity))
		{
			return true;
		} 
			
			return false;
	}
	
	public function calculateAndUpdateQuantity($item_id, $product_id, $quantity, $warehouse_id)
	{
		//check if entry exist then update else inster
		if($this->getProductQuantity($product_id, $warehouse_id)) {
			
			//get product details to calculate quantity
			$warehouse_quantity = $this->getProductQuantity($product_id, $warehouse_id);	
			$warehouse_quantity = $warehouse_quantity['quantity'];
			$item_details = $this->getItemByID($item_id);
			$item_quantity = $item_details->quantity;
			$after_quantity = $warehouse_quantity + $item_quantity;
			$new_quantity = $after_quantity - $quantity;
			
			if($this->updateQuantity($product_id, $warehouse_id, $new_quantity)){
					return TRUE;
			}
			
		} else {
						
			if($this->insertQuantity($product_id, $warehouse_id, -$quantity)){
				return TRUE;
			}
		}
		
		return FALSE;
	}
	
	public function CalculateOldQuantity($item_id, $product_id, $quantity, $warehouse_id)
	{

			
			//get product details to calculate quantity
			$warehouse_quantity = $this->getProductQuantity($product_id, $warehouse_id);	
			$warehouse_quantity = $warehouse_quantity['quantity'];
			$item_details = $this->getItemByID($item_id);
			$item_quantity = $item_details->quantity;
			$after_quantity = $warehouse_quantity + $item_quantity;
			
			
			if($this->updateQuantity($product_id, $warehouse_id, $after_quantity)){
					return TRUE;
			}
			

		
		return FALSE;
	}
	public function addQuantity($product_id, $warehouse_id, $quantity) 
	{

		//check if entry exist then update else inster
		if($this->getProductQuantity($product_id, $warehouse_id)) {
			
		$warehouse_quantity = $this->getProductQuantity($product_id, $warehouse_id);	
		$old_quantity = $warehouse_quantity['quantity'];		
		$new_quantity = $old_quantity - $quantity;
					
			if($this->updateQuantity($product_id, $warehouse_id, $new_quantity)){
				return TRUE;
			}
			
		} else {
						
			if($this->insertQuantity($product_id, $warehouse_id, -$quantity)){
				return TRUE;
			}
		}
		
		return FALSE;

	}
	
	public function insertQuantity($product_id, $warehouse_id, $quantity)
	{	

			// Product data
			$productData = array(
				'product_id'	     		=> $product_id,
				'warehouse_id'   			=> $warehouse_id,
				'quantity' 					=> $quantity
			);

		if($this->db->insert('warehouses_products', $productData)) {
			return true;
		} else {
			return false;
		}
	}
	
	
	public function updateQuantity($product_id, $warehouse_id, $quantity)
	{	

			$productData = array(
				'quantity'	     			=> $quantity
			);
		
		//$this->db->where('product_id', $id);		
		if($this->db->update('warehouses_products', $productData, array('product_id' => $product_id, 'warehouse_id' => $warehouse_id))) {
			return true;
		} else {
			return false;
		}
	}
	public function getProductQuantity($product_id, $warehouse) 
	{
		$q = $this->db->get_where('warehouses_products', array('product_id' => $product_id, 'warehouse_id' => $warehouse), 1); 
		
		  if( $q->num_rows() > 0 )
		  {
			return $q->row_array(); //$q->row();
		  } 
		
		  return FALSE;
		
	}
	
	
	public function getItemByID($id)
	{

		$q = $this->db->get_where('sale_items', array('id' => $id), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}
	
	public function getAllSales() 
	{
		$q = $this->db->get('sales');
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	public function sales_count() {
        return $this->db->count_all("sales");
    }

    public function fetch_sales($limit, $start) {
        $this->db->limit($limit, $start);
		$this->db->order_by("id", "desc"); 
        $query = $this->db->get("sales");

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }
	
	
	public function getAllInvoiceItems($sale_id) 
	{
		$q = $this->db->get_where('sale_items', array('sale_id' => $sale_id));
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	public function getAllSaleItems($id) 
	{
		$q = $this->db->get_where('suspended_items', array('suspend_id' => $id));
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	public function getSaleByID($id)
	{

		$q = $this->db->get_where('suspended_bills', array('id' => $id), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}
	
	public function getInvoiceByID($id)
	{

		$q = $this->db->get_where('sales', array('id' => $id), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}

	
	public function getInvoiceBySaleID($sale_id)
	{

		$q = $this->db->get_where('sales', array('id' => $sale_id), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}
	
	public function getQuoteByID($id)
	{

		$q = $this->db->get_where('quotes', array('id' => $id), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}
	
	public function getAllUser() 
	{
		$q = $this->db->get('users');
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}

	public function getQuoteByQID($id)
	{
		$this->db->select("reference_no, warehouse_id, biller_id, biller_name, customer_id, customer_name, date, note, inv_total, total_tax, total");
		$this->db->from('quotes');
		$this->db->where('id', $id);
		$this->db->limit(1);
		$q = $this->db->get(); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row_array();
		  } 
		
		  return FALSE;

	}

	public function getAllQuoteItems($quote_id) 
	{
		$q = $this->db->get_where('quote_items', array('quote_id' => $quote_id));
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	public function addSale($saleDetails = array(), $items = array(), $warehouse_id, $sid = NULL)
	{
		$this->form_validation->set_rules('noMeja', 'noMeja', 'required|trim|xss_clean');
		$this->form_validation->set_rules('user', 'user', 'required|trim|xss_clean');
		
		// sale data
		$saleData = array(
			'reference_no'			=> $saleDetails['reference_no'],
			'warehouse_id'			=> $warehouse_id,
		    'biller_id'				=> $saleDetails['biller_id'],
			'biller_name'			=> $saleDetails['biller_name'],
			'customer_id'			=> $saleDetails['customer_id'],
			'customer_name'			=> $saleDetails['customer_name'],
			'date'					=> $saleDetails['date'],
			'inv_total'				=> $saleDetails['inv_total'],
			'total_tax'				=> $saleDetails['total_tax'],
			'total'					=> $saleDetails['total'],
			'total_tax2'			=> $saleDetails['total_tax2'],
			'tax_rate2_id'			=> $saleDetails['tax_rate2_id'],
			'inv_discount'			=> $saleDetails['inv_discount'],
			'discount_id'			=> $saleDetails['discount_id'],
			'user'					=> $saleDetails['user'],
			'paid_by'				=> $saleDetails['paid_by'],
			'count'					=> $saleDetails['count'],
                        'pos'                           => '1',
                        'paid'				=> $saleDetails['paid_val'],
			'cc_no'				=> $saleDetails['cc_no_val'],
			'cc_holder'				=> $saleDetails['cc_holder_val'],
			'cheque_no'				=> $saleDetails['cheque_no_val'],
			'noMeja'				=> $_POST['noMeja'],
			'pelayan'				=> $_POST['user'],
		);

		

		if($this->db->insert('sales', $saleData)) {
			$sale_id = $this->db->insert_id();
			
			
			foreach($items as $idata){
				$this->nsQTY($idata['product_code'], $idata['quantity']);
				$this->updateProductQuantity($idata['product_id'], $warehouse_id, $idata['quantity']);
				$logPenjualan = array(
					'idProduk' => $idata['product_code'],
					'namaTransaksi'			=> "Penjualan Produk",
					'qty' => $idata['quantity']
				);
		
				$this->db->insert('log', $logPenjualan);
			}
			
			$addOn = array('sale_id' => $sale_id);
					end($addOn);
					foreach ( $items as &$var ) {
						$var = array_merge($addOn, $var);
			}
				
			if($this->db->insert_batch('sale_items', $items)) {
				if($sid) { $this->deleteSale($sid); }
				return $sale_id;
			}
		}
		
		return false;
	}
	
	public function nsQTY($product_id, $quantity) {
				
		$pr1 = $this ->getProductByCf1ID($product_id);

		foreach($pr1 as $row) {
			//echo $row['field'];
			$idBahan= $row['idBahanBaku'];
			$prD = $this->getProductByID($idBahan);
			$pengurangan=$row['qty']*$quantity;
			$cf1QTY =$prD->quantity - ($row['qty'] *$quantity) ;
			$this->db->update('products', array('quantity' => $cf1QTY), array('code' => $idBahan));
			$logPengurangan = array(
				'idProduk' => $idBahan,
				'namaTransaksi'			=> "Pengurangan Data Produk (Penjualan)",
				'qty' => $pengurangan
			);
	
			$this->db->insert('log', $logPengurangan);
		}

		
				
		// $cf2 = $prD->cf2;
		// $pr2 = $this ->getProductByCf2ID($cf2);
		// $cf2QTY =$pr2->quantity - ($prD->jml_cf2 *$quantity) ;
		// $this->db->update('products', array('quantity' => $cf2QTY), array('id' => $cf2));

		// $cf3 = $prD->cf3;
		// $pr3 = $this ->getProductByCf3ID($cf3);
		// $cf3QTY =$pr3->quantity - ($prD->jml_cf3 *$quantity) ;
		// $this->db->update('products', array('quantity' => $cf3QTY), array('id' => $cf3));

		// $cf4 = $prD->cf4;
		// $pr4 = $this ->getProductByCf4ID($cf4);
		// $cf4QTY =$pr4->quantity - ($prD->jml_cf4 *$quantity) ;
		// $this->db->update('products', array('quantity' => $cf4QTY), array('id' => $cf4));

		// $cf5 = $prD->cf5;
		// $pr5 = $this ->getProductByCf5ID($cf5);
		// $cf5QTY =$pr5->quantity - ($prD->jml_cf5 *$quantity) ;
		// $this->db->update('products', array('quantity' => $cf5QTY), array('id' => $cf5));

		// $cf6 = $prD->cf6;
		// $pr6 = $this ->getProductByCf6ID($cf6);
		// $cf6QTY =$pr6->quantity - ($prD->jml_cf6 *$quantity) ;
		// $this->db->update('products', array('quantity' => $cf6QTY), array('id' => $cf6));
 
		

		// $nQTY = $prD->quantity - $quantity;
		// $this->db->update('products', array('quantity' => $nQTY), array('id' => $product_id));
	}
	
	
	/*
	
	public function addSale($invoice_type, $saleDetails = array(), $items = array(), $warehouse_id, $sid = NULL)
	{
		if($invoice_type == "real") {
			foreach($items as $data){
				$product_id = $data['product_id'];
				$product_quantity = $data['quantity'];
					$this->updateProductQuantity($product_id, $warehouse_id, $product_quantity);
			}
			
		// sale data
		$saleData = array(
			'reference_no'			=> $saleDetails['reference_no'],
			'warehouse_id'			=> $warehouse_id,
		    'biller_id'				=> $saleDetails['biller_id'],
			'biller_name'			=> $saleDetails['biller_name'],
			'customer_id'			=> $saleDetails['customer_id'],
			'customer_name'			=> $saleDetails['customer_name'],
			'date'					=> $saleDetails['date'],
			'inv_total'				=> $saleDetails['inv_total'],
			'total_tax'				=> $saleDetails['total_tax'],
			'total'					=> $saleDetails['total'],
			'invoice_type'			=> $saleDetails['invoice_type'],
			'in_type'				=> $saleDetails['in_type'],
			'total_tax2'			=> $saleDetails['total_tax2'],
			'tax_rate2_id'			=> $saleDetails['tax_rate2_id'],
			'paid_by'			=> $saleDetails['paid_by']
		);

		if($this->db->insert('sales', $saleData)) {
			$sale_id = $this->db->insert_id();
			
			$addOn = array('sale_id' => $sale_id);
					end($addOn);
					foreach ( $items as &$var ) {
						$var = array_merge($addOn, $var);
			}
				
			if($this->db->insert_batch('sale_items', $items)) {
				if($sid !== NULL) { $this->deleteSale($sid); }
				return $sale_id;
			}
		}
		
		} else {
			// sale data
			$saleData = array(
			'reference_no'			=> $saleDetails['reference_no'],
			'warehouse_id'			=> $warehouse_id,
		    'biller_id'				=> $saleDetails['biller_id'],
			'biller_name'			=> $saleDetails['biller_name'],
			'customer_id'			=> $saleDetails['customer_id'],
			'customer_name'			=> $saleDetails['customer_name'],
			'date'					=> $saleDetails['date'],
			'inv_total'				=> $saleDetails['inv_total'],
			'total_tax'				=> $saleDetails['total_tax'],
			'total'					=> $saleDetails['total'],
			'invoice_type'			=> $saleDetails['invoice_type'],
			'in_type'			=> $saleDetails['in_type'],
			'total_tax2'			=> $saleDetails['total_tax2'],
			'tax_rate2_id'			=> $saleDetails['tax_rate2_id']
		);

		if($this->db->insert('quotes', $saleData)) {
			$sale_id = $this->db->insert_id();
			
			$addOn = array('quote_id' => $sale_id);
					end($addOn);
					foreach ( $items as &$var ) {
						$var = array_merge($addOn, $var);
			}
				
			if($this->db->insert_batch('quote_items', $items)) {
				
				 return $sale_id;
			}
		} else {
			return false;
		}
		
		} 
	}
	*/
	
	public function getAllWarehouses() 
	{
		$q = $this->db->get('warehouses');
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}


	public function getTodaySales() 
	{
		$date = date('Y-m-d');	

		$myQuery = "SELECT DATE_FORMAT( date,  '%W, %D %M %Y' ) AS date, SUM( COALESCE( total, 0 ) ) AS total
			FROM sales
			WHERE DATE(date) LIKE '{$date}'";
		$q = $this->db->query($myQuery, false);
		if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
	}
	
	public function getTodayCCSales() 
	{
		$date = date('Y-m-d');	
		$myQuery = "SELECT SUM( COALESCE( total, 0 ) ) AS total
			FROM sales
			WHERE DATE(date) =  '{$date}' AND paid_by = 'CC'
			GROUP BY date";
		$q = $this->db->query($myQuery, false);
		if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
	}
	
	public function getTodayCashSales() 
	{
		$date = date('Y-m-d');	
		$myQuery = "SELECT SUM( COALESCE( total, 0 ) ) AS total
			FROM sales
			WHERE DATE(date) =  '{$date}' AND paid_by = 'cash'
			GROUP BY date";
		$q = $this->db->query($myQuery, false);
		if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
	}
	public function getTodayChSales() 
	{
		$date = date('Y-m-d');	
		$myQuery = "SELECT SUM( COALESCE( total, 0 ) ) AS total
			FROM sales
			WHERE DATE(date) =  '{$date}' AND paid_by = 'Cheque'
			GROUP BY date";
		$q = $this->db->query($myQuery, false);
		if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
	}
	public function getDailySales($year, $month) 
	{
		
		$myQuery = "SELECT DATE_FORMAT( date,  '%e' ) AS date, SUM( COALESCE( total, 0 ) ) AS total
			FROM sales
			WHERE DATE_FORMAT( date,  '%Y-%m' ) =  '{$year}-{$month}'
			GROUP BY DATE_FORMAT( date,  '%e' )";
		$q = $this->db->query($myQuery, false);
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	

	
	public function getMonthlySales($year) 
	{
		
		$myQuery = "SELECT DATE_FORMAT( date,  '%c' ) AS date, SUM( COALESCE( total, 0 ) ) AS total
			FROM sales
			WHERE DATE_FORMAT( date,  '%Y' ) =  '{$year}' 
			GROUP BY date_format( date, '%c' ) ORDER BY date_format( date, '%c' ) ASC";
		$q = $this->db->query($myQuery, false);
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	public function getSuspendedBillByID($id) 
	{

		$q = $this->db->get_where('suspended_bills', array('id' => $id)); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}
	
	public function suspendBill($customer_id, $saleData, $count, $tax1, $tax2, $total)
	{
		// bill data
		$billData = array(
			'customer_id'		=> $customer_id,
			'sale_data'			=> $saleData,
			'count'		=> $count,
			'tax1' 	=> $tax1,
			'tax2' 	=> $tax2,
			'total'	=> $total
			
		);
		
		
			if( $this->db->insert('suspended_bills', $billData) ) {
				return true;
			}
		
		  return FALSE;

	}
	
	public function suspendSale($saleDetails = array(), $items = array(), $count, $did = NULL)
	{

		if($did) {
			
			// sale data
			$saleData = array(
				'count'					=> $count,
				'customer_id'			=> $saleDetails['customer_id'],
				'date'					=> $saleDetails['date'],
				'total'					=> $saleDetails['inv_total'],
				'tax1'					=> $saleDetails['total_tax'],
				'total'					=> $saleDetails['total'],
				'inv_total'				=> $saleDetails['inv_total'],
				'tax2'					=> $saleDetails['total_tax2'],
				'discount'				=> $saleDetails['inv_discount']			
			);
	
			if($this->db->update('suspended_bills', $saleData, array('id' => $did)) && $this->db->delete('suspended_items', array('suspend_id' => $did))) {
				
				$addOn = array('suspend_id' => $did);
						end($addOn);
						foreach ( $items as &$var ) {
							$var = array_merge($addOn, $var);
				}
					
				if($this->db->insert_batch('suspended_items', $items)) {
					return TRUE;
				}
			}
			
		} else {
			// sale data
			$saleData = array(
				'count'					=> $count,
				'customer_id'			=> $saleDetails['customer_id'],
				'date'					=> $saleDetails['date'],
				'total'					=> $saleDetails['inv_total'],
				'tax1'					=> $saleDetails['total_tax'],
				'total'					=> $saleDetails['total'],
				'inv_total'				=> $saleDetails['inv_total'],
				'tax2'					=> $saleDetails['total_tax2'],
				'discount'				=> $saleDetails['inv_discount']			
			);
	
			if($this->db->insert('suspended_bills', $saleData)) {
				$suspend_id = $this->db->insert_id();
				
				$addOn = array('suspend_id' => $suspend_id);
						end($addOn);
						foreach ( $items as &$var ) {
							$var = array_merge($addOn, $var);
				}
					
				if($this->db->insert_batch('suspended_items', $items)) {
					return TRUE;
				}
			}
		}
		return FALSE;
	}
	
	public function deleteSale($id)
	    {
	       
	     if($this->db->delete('suspended_items', array('suspend_id' => $id)) && $this->db->delete('suspended_bills', array('id' => $id))) 
		 {	
	        return true;
	     }
			
	    return FALSE;
	    } 
		
	public function addCustomer($data)
	{

		if($this->db->insert('customers', $data)) {
			return true;
		}
		return false;
	}
	
	public function getWarehouseProductQuantity($warehouse_id, $product_id)
	{

		$q = $this->db->get_where('warehouses_products', array('warehouse_id' => $warehouse_id, 'product_id' => $product_id), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}  
	
}
