<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?php echo $title;?></title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="shortcut icon" type="image/ico" href="<?php echo base_url('assets/img/bpjs.png')?>">
		<link href="<?php echo base_url('assets/css/bootstrap.min.css')?>" rel="stylesheet">
		<link href="<?php echo base_url('assets/css/navbar-fixed-top.css')?>" rel="stylesheet">
		<link href="<?php echo base_url('assets/datatables.css')?>" rel="stylesheet">
	</head>
	<body>

		<!-- Fixed navbar -->
		<nav class="navbar navbar-default navbar-fixed-top" style="background-color:#ffffff;color:#000000;">
			<div class="row">
				<div class="text-center" style="background-color:#2C317C;color:#ffffff;padding-top:10px; padding-bottom:10px; font-size:1.2em;">
					SI KAWAN (Selisih bIaya Kelas rAWAt iNap)
				</div>
			</div>
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="index.php"><img width="70%" src="<?php echo base_url('assets/img/bpjs2.png')?>"></a>
				</div>
				<div id="navbar" class="navbar-collapse collapse">
					<ul class="nav navbar-nav navbar-right">
						<?php if($this->session->userdata('level') == 'Admin') { ?>
						<li><a href="<?php echo site_url('home');?>">Home</a></li>
						<li><a href="<?php echo site_url('master');?>">Data Master</a></li>
						<?php } ?>
						<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Report <span class="caret"></span></a>
					<ul class="dropdown-menu">
										<li class="dropdown-header">Export to:</li>
						<li><a href="<?php echo site_url('home/excel');?>" target="_blank">Excel</a></li>
						<li><a href="<?php echo site_url('home/pdf');?>" target="_blank">PDF</a></li>
						<li role="separator" class="divider"></li>
					</ul>
					</li>
					</ul>
				</div>
			</div>
		</nav>
		<!-- Fixed navbar -->

		<br/><br/><br/>

		<div class="container">
			<!--Search-->
			<div class="row">
				<div class="col-xs-12 col-md-6 col-lg-8">
				</div>
				<div class="col-xs-12 col-md-6 col-lg-4">
					<form class="form" method="get" action="cari.php"> <!-- form-inline -->
						<div class="form-group">
							<div class="input-group">
								<!-- <input type="text" class="form-control" id="txtcari" name="txtcari" value="" placeholder="Type here and press Enter"> -->
								<!-- <div class="input-group-addon"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></div> -->
							</div>
						</div>
					</form>
				</div>
			</div>
			<!--Search-->

			<!-- Modal Add-->
      <div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <form method="post" action="<?php echo site_url('home/input');?>">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Tambah Data</h4>
              </div>
              <div class="modal-body">
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label for="txtnopasien">Nomor Pasien</label>
								<input type="text" class="form-control" id="txtnopasien" name="txtnopasien" placeholder="Nomor Pasien" required="required">
							</div>
							<div class="form-group">
							<label for="txtjnsbpjs">Jenis Hak Kelas Rawat Peserta JKN</label>
								<select class="form-control" id="txtjnsbpjs" name="txtjnsbpjs" required="required">
									<option value="" selected>Pilih Jenis Hak Kelas Rawat Peserta JKN</option>
									<option value="1">Hak rawat kelas 2 naik ke kelas 1</option>
									<option value="2">Hak rawat kelas 1 naik ke kelas di atas 1</option>
									<option value="3">Hak rawat kelas 2 naik ke kelas di atas 1</option>
								</select>
							</div>
							<div class="form-group">
								<label for="value1">Tarif Riil RS Diatas Kelas 1</label>
								<input type="text" name="value1" id="value1" class="form-control hitung" 
									min="0" placeholder="Masukkan Nilai" 
									onkeypress="return onlyNumberKey(event)"
									onkeyup="return numberWithCommas(this)"
									required />
							</div>
							<div class="form-group">
								<label for="value2">Tarif INA_CBG Kelas 1</label>
								<input type="text" name="value2" id="value2" class="form-control hitung" 
									min="0" placeholder="Masukkan Nilai" 
									onkeypress="return onlyNumberKey(event)"
									onkeyup="return numberWithCommas(this)"
									required />
							</div>
							<div class="form-group">
								<label for="value3">Tarif INA_CBG Kelas 2</label>
								<input type="text" name="value3" id="value3" class="form-control hitung" 
									min="0" placeholder="Masukkan Nilai" 
									onkeypress="return onlyNumberKey(event)"
									onkeyup="return numberWithCommas(this)"
									required />
								<input type="hidden" id="tvalue3" name="tvalue3">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label for="value4">Selisih Tarif Riil RS dengan Tarif INA_CBG</label>
								<input type="text" name="value4" id="value4" class="form-control" readonly />
							</div>
							<div class="form-group">
								<label for="value5">Selisih INA-CBG Kelas 1-2</label>
								<input type="text" name="value5" id="value5" class="form-control" readonly />
							</div>
							<div class="form-group">
								<label for="value6">Max 75% INA-CBG Kelas 1</label>
								<input type="text" name="value6" id="value6" class="form-control" readonly />
							</div>
							<div class="form-group">
								<label for="value7">Peserta Bayar</label>
								<input type="text" name="value7" id="value7" class="form-control" readonly />
							</div>
						</div>
					</div>
				</div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" id="btnsimpan" name="btnsimpan" class="btn btn-success">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- Modal Add-->

			<?php
			if ($this->session->flashdata('inputValidationF')==TRUE) {
				echo '<div class="alert alert-danger">
								<a class="close" data-dismiss="alert">&times;</a>
								'.$this->session->flashdata('inputValidationF').'
							</div>';
			}else if ($this->session->flashdata('inputValidationT')==TRUE){
				echo '<div class="alert alert-success">
								<a class="close" data-dismiss="alert">&times;</a>
								'.$this->session->flashdata('inputValidationT').'
							</div>';
			}?>

			<div class="row">
				<table class="table table-striped table-bordered table-hover" id="datatable">
	        <thead>
	          <tr>
	              <td class="text-center"><b>No</b></td>
	              <td class="text-center"><b>Nomor Pasien</b></td>
				  <td class="text-center"><b>Jenis Hak Kelas Rawat Peserta JKN</b></td>
	              <td class="text-center"><b>Tarif Riil RS Diatas Kelas 1</b></td>
	              <td class="text-center"><b>Tarif INA_CBG Kelas 1</b></td>
	              <td class="text-center"><b>Tarif INA_CBG Kelas 2</b></td>
				  <td class="text-center"><b>Selisih Tarif Riil RS dgn Tarif INA_CBG</b></td>
	              <td class="text-center"><b>Selisih INA_CBG Kelas 1-2</b></td>
				  <td class="text-center"><b>Max 75% INA_CBG Kelas 1</b></td>
				  <td class="text-center"><b>Peserta Bayar</b></td>
	              <td class="text-center">
	                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ModalAdd"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
	              </td>
	          </tr>
	        </thead>
	        <tbody>
						<?php
		          $no=1+$this->uri->segment(3);
	            foreach ($record->result() as $r){
		        ?>
				        <tr>
				          <td class="text-center"><?php echo $no; ?></td>
				          <td class="text-center"><?php echo $r->no_pasien; ?></td>
				          <td class="text-center">
							<?php 
							if ($r->jns_bpjs == 1)
							{
								echo "Hak rawat kelas 2 naik ke kelas 1";
							}
							elseif ($r->jns_bpjs == 1)
							{
								echo "Hak rawat kelas 1 naik ke kelas di atas 1";
							}
							else
							{
								echo "Hak rawat kelas 2 naik ke kelas di atas 1";
							}
							?>
						  </td>
				          <td class="text-center"><?php echo number_format($r->trf_riil_diatas_satu); ?></td>
				          <td class="text-center"><?php echo number_format($r->trf_ina_cbg_satu); ?></td>
				          <td class="text-center"><?php echo number_format($r->trf_ina_cbg_dua); ?></td>
						  <td class="text-center"><?php echo number_format($r->selisih_riil_ina); ?></td>
						  <td class="text-center"><?php echo number_format($r->selisih_ina_satu_dua); ?></td>
						  <td class="text-center"><?php echo number_format($r->selisih_ina_satu); ?></td>
						  <td class="text-center"><?php echo number_format($r->peserta_bayar); ?></td>
							<td>
								<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalEdit<?php echo $r->id; ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button> -->
								<!-- Modal Edit-->
							      <!-- <div class="modal fade" id="ModalEdit<?php echo $r->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							        <div class="modal-dialog" role="document">
							          <div class="modal-content">
							            <form method="post" action="<?php echo site_url('home/edit');?>">
							              <div class="modal-header">
							                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							                <h4 class="modal-title" id="myModalLabel">Edit Data</h4>
							              </div>
							              <div class="modal-body">
							                <div class="form-group">
							                  <label for="txtnopasien">Name</label>
											  <input type="hidden" id="txtid" name="txtid" value="<?php echo $r->id; ?>">
							                  <input type="text" class="form-control" id="txtnopasien" name="txtnopasien" placeholder="Name" required="required" value="<?php echo $r->nama; ?>">
							                </div>
							                <div class="form-group">
							                  <label for="txtemail">Email</label>
							                  <input type="email" class="form-control" id="txtemail" name="txtemail" placeholder="Email" required="required" value="<?php echo $r->email; ?>">
							                </div>
							                <div class="form-group">
							                  <label for="txturl">Website</label>
							                  <input type="text" class="form-control" id="txturl" name="txturl" placeholder="Website/Url" value="<?php echo $r->url; ?>">
							                </div>
							                <div class="form-group">
							                  <label for="txtpesan">Message</label>
							                  <textarea id="txtpesan" name="txtpesan" class="form-control" rows="3" placeholder="Message" required="required"><?php echo $r->pesan; ?></textarea>
							                </div>
							              </div>
							              <div class="modal-footer">
							                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							                <button type="submit" id="btnedit" name="btnedit" class="btn btn-success">Save Changed</button>
							              </div>
							            </form>
							          </div>
							        </div>
							      </div> -->
							      <!-- Modal Edit-->

								<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ModalDelete<?php echo $r->id; ?>"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
								<!-- Modal Delete-->
							      <div class="modal fade" id="ModalDelete<?php echo $r->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							        <div class="modal-dialog" role="document">
							          <div class="modal-content">
							            <form method="post" action="<?php echo site_url('home/delete');?>">
							              <div class="modal-header">
							                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							                <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
							              </div>
							              <div class="modal-body">
							                <div class="form-group">
																<input type="hidden" id="txtid" name="txtid" value="<?php echo $r->id; ?>">
							                  <label>Are you sure delete this data (<?php echo "ID : ".$r->id;?>)?</label>
							                </div>
							              </div>
							              <div class="modal-footer">
							                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							                <button type="submit" id="btndelete" name="btndelete" class="btn btn-danger">Yes, Delete it !</button>
							              </div>
							            </form>
							          </div>
							        </div>
							      </div>
							      <!-- Modal Delete-->
							</td>
				        </tr>
		        <?php
		          	$no++;
		          }
		        ?>
					</tbody>
	      </table>
				<?php echo $paging; ?>
			</div>
		</div>

		<script src="<?php echo base_url('assets/js/jquery.min.js')?>"></script>
		<script src="<?php echo base_url('assets/js/bootstrap.min.js')?>"></script>
		<script src="<?php echo base_url('assets/datatables.js')?>"></script>
		<script>
			$(document).ready(function () {
				$('#datatable').DataTable({
					responsive: true,
					columnDefs: [ {
						'targets': [0,10],
						'orderable': false,
					}],
					order: [[1, 'desc']],
				});
			});

			function numberWithCommas(element) {
				var value = (element.value).replaceAll(',', '');
				var newValue = value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
				element.value = newValue;
			}

			function numberWithCommasValue(value) {
				var value = value ?? '';
				var newValue = value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
				return newValue;
			}

			function onlyNumberKey(evt) {
				var ASCIICode = (evt.which) ? evt.which : evt.keyCode
				if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
					return false;
				return true;
			}

			$('.hitung').keyup(function() {
				hitung()
			});

			$('#txtjnsbpjs').change(function() {
				hitung()
			});

			function hitung() {
				var txtjnsbpjs = $('#txtjnsbpjs').val();
				
				var value1 = $('#value1').val().replaceAll(',', '');
				var value2 = $('#value2').val().replaceAll(',', '');
				var value3 = $('#value3').val().replaceAll(',', '');

				if(txtjnsbpjs == '1') {
					$('#value3').prop("disabled", false);

					// Selisih Tarif Riil RS dgn Tarif INACBG
					var value4 = numberWithCommasValue(value1 - value3);
					$('#value4').val(value4);

					// Selisih INA-CBG Kelas 1-2
					var value5 = numberWithCommasValue(value2 - value3);
					$('#value5').val(value5);

					// Max 75% INA-CBG Kelas 1
					var value6 = numberWithCommasValue(0.75 * value2);
					$('#value6').val(value6);

					// Peserta Bayar
					var value7 = numberWithCommasValue(value2 - value3);
					$('#value7').val(value7);
				} else if(txtjnsbpjs == '2') {
					$('#value3').val(0).prop("disabled", true);

					// Selisih Tarif Riil RS dgn Tarif INACBG
					var value4 = numberWithCommasValue(value1 - value2)
					$('#value4').val(value4);

					// Selisih INA-CBG Kelas 1-2
					$('#value5').val(0);

					// Max 75% INA-CBG Kelas 1
					var value6 = numberWithCommasValue(0.75 * value2)
					$('#value6').val(value6);
					
					// Peserta Bayar
					if (parseInt(value2.replaceAll(',', '')) > parseInt(value1.replaceAll(',', ''))){
						$('#value7').val(0);
					} else {
						if(parseInt(value4.replaceAll(',', '')) > parseInt(value6.replaceAll(',', ''))) {
							$('#value7').val(numberWithCommasValue(value6));
						} else {
							$('#value7').val(numberWithCommasValue(value4));
						}
					}
				} else {
					$('#value3').prop("disabled", false);

					// Selisih Tarif Riil RS dgn Tarif INACBG
					var value4 = numberWithCommasValue(value1 - value3);
					$('#value4').val(value4);

					// Selisih INA-CBG Kelas 1-2
					var value5 = numberWithCommasValue(value2 - value3);
					$('#value5').val(value5);

					// Max 75% INA-CBG Kelas 1
					var value6 = numberWithCommasValue(0.75 * value2);
					$('#value6').val(value6);
					
					if (parseInt(value3.replaceAll(',', '')) > parseInt(value1.replaceAll(',', ''))){
						$('#value7').val(0);
					} else {
						if ((parseInt(value6.replaceAll(',', '')) + parseInt(value5.replaceAll(',', ''))) < parseInt(value4.replaceAll(',', '')))
						{
							var value7 = numberWithCommasValue(parseInt(value6.replaceAll(',', '')) + parseInt(value5.replaceAll(',', '')))
							$('#value7').val(value7);
						} else {
							$('#value7').val(value4);
						}
					}
					
					
				}
				
			}
		</script>
	</body>
</html>
