<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('model_home');
		$this->load->library('fpdf_gen');
	}

	function index(){
		$this->load->library('pagination');
		$config['base_url'] = site_url().'home/index/';
		$config['total_rows']= $this->model_home->display_data()->num_rows();
		$config['per_page'] = 10;
		$this->pagination->initialize($config);
		$data_paging = $this->pagination->create_links();
		$halaman = $this->uri->segment(3);
		$halaman = $halaman==''?0:$halaman;
		$data = array(
				'title' => 'Home',
				'paging' => $data_paging,
				'record' => $this->model_home->display_data_paging($halaman,$config['per_page']),
			);
		$this->load->view('page_home', $data);
	}

	function input(){
		if(isset($_POST['btnsimpan']))
		{
			$data_input = array(
				'no_pasien'=> $this->input->post('txtnopasien'),
				'jns_bpjs'=> $this->input->post('txtjnsbpjs'),
				'trf_riil_diatas_satu'=> str_replace(',', '', $this->input->post('value1')),
				'trf_ina_cbg_satu'=> str_replace(',', '', $this->input->post('value2')),
				'trf_ina_cbg_dua'=> str_replace(',', '', $this->input->post('value3')),
				'selisih_riil_ina'=> str_replace(',', '', $this->input->post('value4')),
				'selisih_ina_satu_dua'=> str_replace(',', '', $this->input->post('value5')),
				'selisih_ina_satu'=> str_replace(',', '', $this->input->post('value6')),
				'peserta_bayar'=> str_replace(',', '', $this->input->post('value7')),
			);
			$this->model_home->input($data_input);
			$this->session->set_flashdata('inputValidationT', "<strong>Save Successfully!</strong>");
			redirect(site_url('home'));
		}else {
			redirect(site_url('home'));
		}
	}

	function edit(){
		if(isset($_POST['btnedit'])){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			$this->form_validation->set_rules('txtnama', 'Name', 'required|min_length[5]|max_length[15]');
			$this->form_validation->set_message('txtnama', 'Name must be required min 5-15 letter.');
			$this->form_validation->set_rules('txtemail', 'Email', 'required|valid_email');
			$this->form_validation->set_message('txtemail', 'Email must be valid.');
			$this->form_validation->set_rules('txtpesan', 'Message', 'required|min_length[10]|max_length[250]');
			$this->form_validation->set_message('txtpesan', 'Message must be required 10-250 letter.');
			//$this->form_validation->set_rules('dmobile', 'Mobile No.', 'required|regex_match[/^[0-9]{10}$/]'); //phonenumber

			if ($this->form_validation->run() == FALSE) {
				//echo "Failed!";
        $this->session->set_flashdata('inputValidationF', "<strong>Error!</strong>".validation_errors());
				redirect(site_url('home'));
			} else {
				//echo "Successfully!";
				$data_input = array(
					'nama'=> $this->input->post('txtnama'),
					'email'=> $this->input->post('txtemail'),
					'url'=> $this->input->post('txturl'),
					'pesan'=> $this->input->post('txtpesan'),
				);
				$id = $this->input->post('txtid');
				$this->model_home->edit($data_input,$id);
				$this->session->set_flashdata('inputValidationT', "<strong>Update Successfully!</strong>");
				redirect(site_url('home'));
			}
		}else {
			redirect(site_url('home'));
		}
	}

	function delete(){
		if(isset($_POST['btndelete'])){
			$id = $this->input->post('txtid');
			$this->model_home->delete($id);
			$this->session->set_flashdata('inputValidationT', "<strong>Delete Successfully!</strong>");
			redirect(site_url('home'));
		}else {
			redirect(site_url('home'));
		}
	}

	function excel(){
			header("Content-type=appalication/vnd.ms-excel");
			header("content-disposition:attachment;filename=laporandata.xls");
			$data['record'] = $this->model_home->display_data();
			$this->load->view('page_excel',$data);
	}

	function pdf() {
		$data = $this->model_home->get_data_pdf();

		$mpdf = new \Mpdf\Mpdf();
		$table = '';
		foreach ($data->result() as $r => $value) {
			if ($value->jns_bpjs == 1)
			{
				$jenis_bpjs = "Hak rawat kelas 2 naik ke kelas 1";
			}
			elseif ($value->jns_bpjs == 1)
			{
				$jenis_bpjs = "Hak rawat kelas 1 naik ke kelas di atas 1";
			}
			else
			{
				$jenis_bpjs = "Hak rawat kelas 2 naik ke kelas di atas 1";
			}
			$table .= '
			<tr>
				<td style="text-align: center;">'.($r+1).'</td>
				<td style="text-align: center;">'.$value->no_pasien.'</td>
				<td style="text-align: center;">'.$jenis_bpjs.'</td>
				<td style="text-align: right;">'.number_format($value->trf_riil_diatas_satu).'</td>
				<td style="text-align: right;">'.number_format($value->trf_ina_cbg_satu).'</td>
				<td style="text-align: right;">'.number_format($value->trf_ina_cbg_dua).'</td>
				<td style="text-align: right;">'.number_format($value->selisih_riil_ina).'</td>
				<td style="text-align: right;">'.number_format($value->selisih_ina_satu_dua).'</td>
				<td style="text-align: right;">'.number_format($value->selisih_ina_satu).'</td>
				<td style="text-align: right;">'.number_format($value->peserta_bayar).'</td>
			</tr>
			';	
		}
		$html = '
			<h3 style="text-align: center;">Laporan</h3>
			<table border="1" style="font-size: 11px;">
				<thead>
					<tr style="text-align: center;">
						<th>No</th>
						<th>Nomor Pasien</th>
						<th>Jenis BPJS</th>
						<th>Tarif Riil RS Diatas Kelas 1</th>
						<th>Tarif INA_CBG Kelas 1</th>
						<th>Tarif INA_CBG Kelas 2</th>
						<th>Selisih Tarif Riil RS dgn Tarif INA_CBG</th>
						<th>Selisih INA_CBG Kelas 1-2</th>
						<th>Max 75% INA_CBG Kelas 1</th>
						<th>Peserta Bayar</th>
					</tr>
				</thead>
				<tbody>
					'.$table.'
				</tbody>
			</table>
		';
		$mpdf->WriteHTML($html);
		$mpdf->Output('report.pdf', 'I');
	}

	// function pdf(){

	// 	$pdf = new FPDF();
	// 	$pdf->AddPage();
	// 	$pdf->AliasNbPages();
	// 	$CI =& get_instance();
	// 	$CI->fpdf = $pdf;

	// 	$this->fpdf->SetFont('Arial','B',16);
	// 	$pdf->MultiCell(0,5,"All Data",0);
	// 	$data = $this->model_home->display_data();
	// 	foreach ($data->result() as $r) {
	// 		$pdf->SetFont('Arial','',10);
	// 		$isi = $r->nama." (".$r->time.") - ".$r->email." - ".$r->url."\n".$r->pesan;
	// 		$pdf->MultiCell(0,5,$isi,1);
	// 	}
	// 	$this->fpdf->Output();

	// 	// $this->load->library('cfpdf');
	// 	// $pdf=new FPDF('P','mm','A4');
	// 	// $pdf->AddPage();
	// 	// $pdf->SetFont('Arial','B','L');
	// 	// $pdf->SetFontSize(14);
	// 	// $pdf->Text(10, 10, 'LAPORAN TRANSAKSI');
	// 	// $pdf->SetFont('Arial','B','L');
	// 	// $pdf->SetFontSize(10);
	// 	// $pdf->Cell(10, 10,'','',1);
	// 	// $pdf->Cell(10, 7, 'No', 1,0);
	// 	// $pdf->Cell(27, 7, 'Tanggal', 1,0);
	// 	// $pdf->Cell(30, 7, 'Operator', 1,0);
	// 	// $pdf->Cell(38, 7, 'Total Transaksi', 1,1);
	// 	// // tampilkan dari database
	// 	// $pdf->SetFont('Arial','','L');
	// 	// $data=  $this->model_transaksi->laporan_default();
	// 	// $no=1;
	// 	// $total=0;
	// 	// foreach ($data->result() as $r)
	// 	// {
	// 	// 		$pdf->Cell(10, 7, $no, 1,0);
	// 	// 		$pdf->Cell(27, 7, $r->tanggal_transaksi, 1,0);
	// 	// 		$pdf->Cell(30, 7, $r->nama_lengkap, 1,0);
	// 	// 		$pdf->Cell(38, 7, $r->total, 1,1);
	// 	// 		$no++;
	// 	// 		$total=$total+$r->total;
	// 	// }
	// 	// // end
	// 	// $pdf->Cell(67,7,'Total',1,0,'R');
	// 	// $pdf->Cell(38,7,$total,1,0);
	// 	// $pdf->Output();

	// }


}
