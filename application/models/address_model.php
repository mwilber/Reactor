<?php

class Address_Model extends CI_Model
{
	var $table = "tblAddress";
	var $pk = "addressId";
	var $ds = "addressTimeStamp";  //Default sortby field 
	var $rq = "addressStreet";		//Required field (you'll need to mod the form validation if there isn't one)
	var $fields = array(
		 'addressStreet' => array('label'=>'Street','type'=>'varchar','constraint'=>50),
		 'addressCity' => array('label'=>'City','type'=>'varchar','constraint'=>50),
		 'addressState' => array('label'=>'State','type'=>'varchar','constraint'=>50),
		 'addressZIP' => array('label'=>'ZIP','type'=>'varchar','constraint'=>5),
		);

	 	 	 	
							
	
	/** Utility Methods **/
	function _required($required, $data)
	{
		foreach($required as $field)
			if(!isset($data[$field])) return false;
			
		return true;
	}
	
	function _default($defaults, $options)
	{
		return array_merge($defaults, $options);
	}
	
	function _fields(){
		return $this->fields;
	}
	
	function _table(){
		return $this->table;
	}
	
	function _pk(){
		return $this->pk;
	}
	// Return default sort field
	function _ds(){
		return $this->ds;
	}
	// Return required field
	function _rq(){
		return $this->rq;
	}
	// Return an array of id and required field
	function _GetRef(){
		$this->db->select($this->pk.",".$this->rq);
		$query = $this->db->get($this->table);
		
		return $query->result_array();
	}
	
	
	/** CRUD Methods **/
	
	function Get($options = array()){
		
		foreach ($this->fields as $key => $value) {
			if(isset($options[$key]))
				$this->db->where($key, $options[$key]);
		}
		if(isset($options[$this->pk]))
				$this->db->where($this->pk, $options[$this->pk]);
		
		// limit / offset
		if(isset($options['limit']) && isset($options['offset']))
			$this->db->limit($options['limit'], $options['offset']);
		else if(isset($options['limit']))
			$this->db->limit($options['limit']);
		
		// sort
		if(isset($options['sortBy']) && isset($options['sortDirection']))
			$this->db->order_by($options['sortBy'], $options['sortDirection']);
		
		$query = $this->db->get($this->table);
		//echo "SQL:".$this->db->last_query();
		
		if(isset($options['count'])) return $query->num_rows();
		
		if(isset($options[$this->pk])) return $query->row(0);
			
		return $query->result();
	}
	
	function Add($options = array())
	{
		// required values
		//if(!$this->_required(
		//	array('userEmail', 'userPassword'),
		//	$options)
		//) return false;
		
		$this->db->insert($this->table, $options);
		
		return $this->db->insert_id();
	}
	
	function Update($options = array())
	{

		foreach ($this->fields as $key => $value) {
			if(isset($options[$key]))
				$this->db->set($key, $options[$key]);
		}

		$this->db->where($this->pk, $options[$this->pk]);
		
		$this->db->update($this->table);
		
		return $this->db->affected_rows();
	}
	
	function Delete($pId)
	{
		$this->db->delete($this->table, array($this->pk => $pId)); 	
	}
	
	
	/** Upload Methods **/
	
	
	function manageFile($pFbId){
		
		$filename = date("U")."_".rand(100, 999).".jpg";
		
		$config['upload_path'] = UPLOAD_DIR;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '1000';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		$config['file_name'] = $pFbId.".jpg";

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());

			//$this->load->view('upload_form', $error);
			return $error;
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());

			//$this->load->view('upload_success', $data);
			return $data;
		}
	}
	
	function manageFile64($pData, $pPath, $pPrefix){
		
		$filename = date("U")."_".rand(100, 999).".jpg";
		
		$file = base64_decode($pData);  //base64_decode
		$fullFilePath = $pPath.'/'.$filename;
		
		//echo "putting file at: ".$fullFilePath;
	
		if (file_put_contents($fullFilePath, $file)) {
			return $filename;
		} else {
			echo "There was an error uploading the file, please try again!";
			return "";
		}
	}
	
	/*
		Function createthumb($name,$filename,$new_w,$new_h)
		creates a resized image
		variables:
		$name		Original filename
		$filename	Filename of the resized image
		$new_w		width of resized image
		$new_h		height of resized image
	*/	
	function createthumb($pName, $pPath, $new_w)
	{
		//echo "name: ".$pName."<br/>";
		$system=explode(".",$pName);
		//echo "system2: ".$system[count($system)-1]."<br/>";
		if (preg_match("/jpg|jpeg|JPG/",$system[count($system)-1])){$im=imagecreatefromjpeg($pPath."/".$pName);}
		if (preg_match("/png|PNG/",$system[count($system)-1])){$im=imagecreatefrompng($pPath."/".$pName);}
		
		list($width, $height) = array(imagesx($im),imagesy($im));
		    
	    // Get the scale based on the requested dimension
	    $scale = $width/$new_w;
	    
	    // X&Y scales remain the same because resizing will always be proportionate
	    $xscale=$scale;
	    $yscale=$scale;
	    
	    // Recalculate new size with default ratio
	    if ($yscale>$xscale){
	        $new_width = round($width * (1/$yscale));
	        $new_height = round($height * (1/$yscale));
	    }
	    else {
	        $new_width = round($width * (1/$xscale));
	        $new_height = round($height * (1/$xscale));
	    }
	
	    // Resize the original image
	    $imageResized = imagecreatetruecolor($new_width, $new_height);
	    imagealphablending( $imageResized, false );
		imagesavealpha( $imageResized, true );
	    
	    $imageTmp     = $im;
	    imagecopyresampled($imageResized, $imageTmp, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
	
		
	/*	$old_x=imageSX($src_img);
		$old_y=imageSY($src_img);
		if ($old_x > $old_y) 
		{
			$thumb_w=$new_w;
			$thumb_h=$old_y*($new_h/$old_x);
		}
		if ($old_x < $old_y) 
		{
			$thumb_w=$old_x*($new_w/$old_y);
			$thumb_h=$new_h;
		}
		if ($old_x == $old_y) 
		{
			$thumb_w=$new_w;
			$thumb_h=$new_h;
		}
		$dst_img=ImageCreateTrueColor($thumb_w,$thumb_h);
		imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y); */
		
		//echo "creating image: ".$system[count($system)-1]." sys1: ".$system[1]." filename: ".$filename;
		
		if (preg_match("/png/",$system[count($system)-1])){
			imagepng($imageResized,$pPath."/thumb_".$pName); 
		} else {
			imagejpeg($imageResized,$pPath."/thumb_".$pName); 
		}
		imagedestroy($im); 
		imagedestroy($imageResized);
		
		return "thumb_".$pName;
	}
}

?>