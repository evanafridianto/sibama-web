<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Drainase extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('masterdata_model','master');
	}

	public function index()
	{
		$datacontent = [ 
			'page_title' =>'Data Drainase',
            'jalan' => $this->master->select_jalan(),
			'lajur_drainase' => $this->master->select_lajur_drainase(),
			'arah_aliran' => $this->master->select_arah_aliran(),
			'kondisi_fisik' => $this->master->select_kondisi_fisik(),
			'kondisi_sedimen' => $this->master->select_kondisi_sedimen(),
			'tipe_saluran' => $this->master->select_tipe_saluran(),
			'penanganan' => $this->master->select_penanganan(),
		];
		$data['content']= $this->load->view('admin/masterdata/drainase_view', $datacontent, true);
		// $data['form_peta']= $this->load->view('admin/masterdata/form_peta', $datacontent,true);
		$this->load->view('layouts/html', $data);
		$this->load->view('admin/masterdata/form_peta');
	}

	public function show_all()
	{
		$data_drainase = $this->master->get_drainase();
		$data = array();
		$no = 1;
		foreach ($data_drainase as $value) {
			$row = array();
			$row[] = $no++;
            $row[] = $value['nama_jalan'];
			$row[] = $value['lat_awal'];
			$row[] = $value['long_awal'];
			$row[] = $value['lat_akhir'];
			$row[] = $value['long_akhir'];
			$row[] = $value['lajur_drainase'];
			//add html for action
			$row[] = '<center><button class="table-action-btn btn-primary" onclick="detail_drainase('."'".$value['id']."'".')"><i class="mdi mdi-eye" title="Detail"></i></button>
            <button class="table-action-btn btn-success" onclick="edit_drainase('."'".$value['id']."'".')"><i class="mdi mdi-pencil" title="Edit"></i></button>
            <button class="table-action-btn btn-danger" onclick="delete_drainase('."'".$value['id']."'".')"><i class="mdi mdi-close" title="Delete"></i></button></center>';
			$data[] = $row;
		}
		if ($data_drainase) {
			echo json_encode(array('data' => $data));
		} else {
			echo json_encode(array('data' => 0));
		}
	}

    


	public function add()
	{
		$this->_validate();
		
		$data = array(
            'id_jalan' => $this->input->post('id_jalan'),
			'sta' => $this->input->post('sta'),
			'lat_awal' => $this->input->post('lat_awal'),
			'long_awal' => $this->input->post('long_awal'),
			'lat_akhir' => $this->input->post('lat_akhir'),
			'long_akhir' => $this->input->post('long_akhir'),
			'panjang_saluran' => $this->input->post('panjang_saluran'),
			'slope' => $this->input->post('slope'),
			'catchment_area' => $this->input->post('catchment_area'),
			'tinggi_saluran' => $this->input->post('tinggi_saluran'),
			'lebar_saluran' => $this->input->post('lebar_saluran'),
			'luas_penampung' => $this->input->post('luas_penampung'),
			'keliling_penampung' => $this->input->post('keliling_penampung'),
			'nama_file_dimensi' => $this->input->post('nama_file_dimensi'),
			'nama_file_foto' => $this->input->post('nama_file_foto'),
			'id_arah_aliran' => $this->input->post('id_arah_aliran'),
			'id_kondisi_fisik' => $this->input->post('id_kondisi_fisik'),
			'id_kondisi_sedimen' => $this->input->post('id_kondisi_sedimen'),
			'id_tipe_saluran' => $this->input->post('id_tipe_saluran'),
			'id_penanganan' => $this->input->post('id_penanganan'),
			'id_lajur_drainase' => $this->input->post('id_lajur_drainase'),
			'date' => $this->input->post('date')
        );
        
        if(!empty($_FILES['file_dimensi']['name']))
        {
            $upload_dimensi = $this->do_upload_dimensi();
            $data['file_dimensi'] = $upload_dimensi;
        }
        if(!empty($_FILES['file_foto']['name']))
        {
            $upload_foto = $this->do_upload_foto();
            $data['file_foto'] = $upload_foto;
        }
        $insert = $this->master->insert_drainase($data);
        echo json_encode(array("status" => TRUE));
	}

    public function detail($id)
	{
	  $detail = $this->master->get_drainase_by_id($id);
	  echo json_encode($detail);
	}

	public function edit($id)
	{
		$data = $this->master->get_drainase_by_id($id);
		echo json_encode($data);
	}

	public function update()
	{
		$this->_validate();
		$data = array(
            'id_jalan' => $this->input->post('id_jalan'),
			'sta' => $this->input->post('sta'),
			'lat_awal' => $this->input->post('lat_awal'),
			'long_awal' => $this->input->post('long_awal'),
			'lat_akhir' => $this->input->post('lat_akhir'),
			'long_akhir' => $this->input->post('long_akhir'),
			'panjang_saluran' => $this->input->post('panjang_saluran'),
			'slope' => $this->input->post('slope'),
			'catchment_area' => $this->input->post('catchment_area'),
			'tinggi_saluran' => $this->input->post('tinggi_saluran'),
			'lebar_saluran' => $this->input->post('lebar_saluran'),
			'luas_penampung' => $this->input->post('luas_penampung'),
			'keliling_penampung' => $this->input->post('keliling_penampung'),
			'nama_file_dimensi' => $this->input->post('nama_file_dimensi'),
			'nama_file_foto' => $this->input->post('nama_file_foto'),
			'id_arah_aliran' => $this->input->post('id_arah_aliran'),
			'id_kondisi_fisik' => $this->input->post('id_kondisi_fisik'),
			'id_kondisi_sedimen' => $this->input->post('id_kondisi_sedimen'),
			'id_tipe_saluran' => $this->input->post('id_tipe_saluran'),
			'id_penanganan' => $this->input->post('id_penanganan'),
			'id_lajur_drainase' => $this->input->post('id_lajur_drainase'),
			'date' => $this->input->post('date')
        );
        
        // if remove dimensi checked
        if($this->input->post('remove_dimensi')) 
        {
            if(file_exists('upload/dimensi/'.$this->input->post('remove_dimensi')) && $this->input->post('remove_dimensi')){
                unlink('upload/dimensi/'.$this->input->post('remove_dimensi'));
                $data['file_dimensi'] = '';
            }
        }
        // update dimensi 
        if(!empty($_FILES['file_dimensi']['name']))
        {
            $uploadDimensi = $this->do_upload_dimensi();
            // $drainase_ = $this->master->get_drainase_by_id($this->input->post('id'));
            $data['file_dimensi'] = $uploadDimensi;
        }
        // end
        
        // if remove foto checked
        if($this->input->post('remove_foto')) 
        {
            if(file_exists('upload/foto/'.$this->input->post('remove_foto')) && $this->input->post('remove_foto')){
                unlink('upload/foto/'.$this->input->post('remove_foto'));
                $data['file_foto'] = '';

            }
        }
        // update foto 
        if(!empty($_FILES['file_foto']['name']))
        {
            $uploadFoto = $this->do_upload_foto();
            // $drainase = $this->master->get_drainase_by_id($this->input->post('id'));
            $data['file_foto'] = $uploadFoto;
        }
        // end
        $this->master->update_drainase(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }


	public function delete($id)
	{
		$drainase = $this->master->get_drainase_by_id($id);
        if(file_exists('upload/dimensi/'.$drainase->file_dimensi) && $drainase->file_dimensi)
			unlink('upload/dimensi/'.$drainase->file_dimensi);
            
            $this->master->delete_drainase($id);
		echo json_encode(array("status" => TRUE));
	}

    private function do_upload_dimensi()
	{
		$config['upload_path']          = 'upload/dimensi/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 24000; //set max size allowed in Kilobyte
        $config['max_width']            = 5000; // set max width image allowed
        $config['max_height']           = 5000; // set max height allowed
        $config['file_name']            = 'file_dimensi_'.round(microtime(true) * 1000);

        $this->load->library('upload', $config);
        if(!$this->upload->do_upload('file_dimensi')) //upload and validate
        {
            $data['inputerror'][] = 'file_dimensi';
			$data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
		}
		return $this->upload->data('file_name');
	}
    private function do_upload_foto()
    {
        $configFoto['upload_path']          = 'upload/foto/';
        $configFoto['allowed_types']        = 'gif|jpg|png';
        $configFoto['max_size']             = 24000; //set max size allowed in Kilobyte
        $configFoto['max_width']            = 5000; // set max width image allowed
        $configFoto['max_height']           = 5000; // set max height allowed
        $configFoto['file_name']            = 'file_foto_'.round(microtime(true) * 1000);
        $this->upload->initialize($configFoto);
        $this->load->library('upload', $configFoto);
        if(!$this->upload->do_upload('file_foto')) //upload and validate
        {
            $data['inputerror'][] = 'file_foto';
			$data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
		}
        return $this->upload->data('file_name');
    }

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

        if($this->input->post('id_jalan')=='')
        {
        $data['inputerror'][] = 'id_jalan';
        $data['error_string'][] ='Jalan is required';
        $data['status'] = FALSE;
        }
        
		if($this->input->post('sta')=='')
        {
        $data['inputerror'][] = 'sta';
        $data['error_string'][] ='STA is required';
        $data['status'] = FALSE;
        }
        
		if($this->input->post('lat_awal')=='')
        {
        $data['inputerror'][] = 'lat_awal';
        $data['error_string'][] ='Latitude Awal is required';
        $data['status'] = FALSE;
        }
        
		if($this->input->post('long_awal')=='')
        {
        $data['inputerror'][] = 'long_awal';
        $data['error_string'][] ='Longitude Awal is required';
        $data['status'] = FALSE;
        }
        
		if($this->input->post('lat_akhir')=='')
        {
        $data['inputerror'][] = 'lat_akhir';
        $data['error_string'][] ='Latitude Akhir is required';
        $data['status'] = FALSE;
        }
        
		if($this->input->post('long_akhir')=='')
        {
        $data['inputerror'][] = 'long_akhir';
        $data['error_string'][] ='Longitude Akhir is required';
        $data['status'] = FALSE;
        }
        
		if($this->input->post('panjang_saluran')=='')
        {
        $data['inputerror'][] = 'panjang_saluran';
        $data['error_string'][] ='Panjang Saluran is required';
        $data['status'] = FALSE;
        }
        
		if($this->input->post('slope')=='')
        {
        $data['inputerror'][] = 'slope';
        $data['error_string'][] ='Slope is required';
        $data['status'] = FALSE;
        }
        
		if($this->input->post('catchment_area')=='')
        {
        $data['inputerror'][] = 'catchment_area';
        $data['error_string'][] ='Catchment Area is required';
        $data['status'] = FALSE;
        }
        
		if($this->input->post('tinggi_saluran')=='')
        {
        $data['inputerror'][] = 'tinggi_saluran';
        $data['error_string'][] ='Tinggi Saluran is required';
        $data['status'] = FALSE;
        }
        
		if($this->input->post('lebar_saluran')=='')
        {
        $data['inputerror'][] = 'lebar_saluran';
        $data['error_string'][] ='Lebar Saluran is required';
        $data['status'] = FALSE;
        }
        
		if($this->input->post('luas_penampung')=='')
        {
        $data['inputerror'][] = 'luas_penampung';
        $data['error_string'][] ='Luas Penampung is required';
        $data['status'] = FALSE;
        }
        
		if($this->input->post('keliling_penampung')=='')
        {
        $data['inputerror'][] = 'keliling_penampung';
        $data['error_string'][] ='Keliling Penampung is required';
        $data['status'] = FALSE;
        }
        
		if($this->input->post('id_arah_aliran')=='')
        {
        $data['inputerror'][] = 'id_arah_aliran';
        $data['error_string'][] ='Arah Aliran is required';
        $data['status'] = FALSE;
        }
        
		if($this->input->post('id_kondisi_fisik')=='')
        {
        $data['inputerror'][] = 'id_kondisi_fisik';
        $data['error_string'][] ='Kondisi Fisik is required';
        $data['status'] = FALSE;
        }
        
		if($this->input->post('id_kondisi_sedimen')=='')
        {
        $data['inputerror'][] = 'id_kondisi_sedimen';
        $data['error_string'][] ='Kondisi Sedimen is required';
        $data['status'] = FALSE;
        }
        
		if($this->input->post('id_tipe_saluran')=='')
        {
        $data['inputerror'][] = 'id_tipe_saluran';
        $data['error_string'][] ='Tipe Saluran is required';
        $data['status'] = FALSE;
        }
        
		if($this->input->post('id_penanganan')=='')
        {
        $data['inputerror'][] = 'id_penanganan';
        $data['error_string'][] ='Penanganan is required';
        $data['status'] = FALSE;
        }
        
		if($this->input->post('id_lajur_drainase')=='')
        {
        $data['inputerror'][] = 'id_lajur_drainase';
        $data['error_string'][] ='Lajur Drainase is required';
        $data['status'] = FALSE;
        }
        
		if($this->input->post('nama_file_dimensi')=='')
        {
        $data['inputerror'][] = 'nama_file_dimensi';
        $data['error_string'][] ='Nama File Dimensi is required';
        $data['status'] = FALSE;
        }
        
		if($this->input->post('nama_file_foto')=='')
        {
        $data['inputerror'][] = 'nama_file_foto';
        $data['error_string'][] ='Nama File Foto is required';
        $data['status'] = FALSE;
        }
        
		if($this->input->post('date')=='')
        {
        $data['inputerror'][] = 'date';
        $data['error_string'][] ='Tanggal is required';
        $data['status'] = FALSE;
        }

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}


        
		
    }

}