<?php

namespace App\Controllers;
use PHPExcel;
use PHPExcel_IOFactory;
use App\Controllers\BaseController;
use App\Models\PenjualanModel;

class Penjualan extends BaseController
{
    public function __construct()
    {
        $this->penjualanModel = new PenjualanModel();
    }
    public function index()
    {
        if (!session()->get('nama')) {
            return redirect()->to(base_url() . "/dashboard");
        }
		$data['data'] = $this->penjualanModel->findAll(50,1);

        return view('penjualan', $data);
    }

    public function datapenjualan(){
        $penjualan = $this->penjualanModel->findAll();
        
        echo json_encode($penjualan);
    }

	public function penjualanbyid($id){
		$data = $this->penjualanModel->find($id);

		if($data){
			$res = array(
				'err'	=> false,
				'data'	=> $data
			);
		}else{
			$res = array(
				'err' => true,
				'data'=> null
			);
		}
		echo json_encode($res);
	}

	public function deletepenjualan($id){
        $penjualan = new PenjualanModel();
        $penjualan->delete($id);
		return redirect()->to(base_url() . "/penjualan");
    }

	public function updatepenjualan($id){
		$data = new PenjualanModel();
        $penjualan = $data->where('id', $id)->first();

		$data->update($id, [
			"id_toko" 	=> $this->request->getPost('id_toko'),
			"alamat" 	=> $this->request->getPost('alamat'),
			"nama_produk"=> $this->request->getPost('nama_produk'),
			"barcode"	=> $this->request->getPost('barcode'),
			"kategori"	=> $this->request->getPost('kategori'),
			"tanggal"	=> $this->request->getPost('tanggal'),
			"terjual"	=> $this->request->getPost('terjual')
		]);

		return redirect()->to(base_url() . "/penjualan");
	}

    public function processExcel(){
        $file_excel = $this->request->getFile('fileexcel');
		$ext = $file_excel->getClientExtension();
		if($ext == 'xls') {
			$render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
		} else {
			$render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		}
		$spreadsheet = $render->load($file_excel);

		$data = $spreadsheet->getActiveSheet()->toArray();
		foreach($data as $x => $row){
			if ($x == 0) {
				continue;
			}
			$id_toko    = $row[1];
			$alamat     = $row[2];
			$nama_produk= $row[3];
			$barcode    = $row[4];
			$kategori   = $row[5];
			$tanggal    = $row[6];
			$terjual    = $row[7];

			// insert data
			$this->penjualanModel->insert([
				'id_toko'       =>$id_toko,
				'alamat'        =>$alamat,
				'nama_produk'   =>$nama_produk,
				'barcode'       =>$barcode,
				'kategori'      =>$kategori,
				'tanggal'       =>date('Y-m-d H:i:s', strtotime($tanggal)),
				'terjual'       =>$terjual,

			]);
		}
		
		return redirect()->to(base_url() . "/penjualan");
    }
}
