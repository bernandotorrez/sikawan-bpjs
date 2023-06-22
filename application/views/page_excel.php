
<?php
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="laporan.xlsx"');
?>

<table border="1">
   <tr style="text-align: center;">
      <th>No</th>
      <th>Nomor Pasien</th>
      <th>Jenis Hak Kelas Rawat Peserta JKN</th>
      <th>Tarif Riil RS Diatas Kelas 1</th>
      <th>Tarif INA_CBG Kelas 1</th>
      <th>Tarif INA_CBG Kelas 2</th>
      <th>Selisih Tarif Riil RS dgn Tarif INA_CBG</th>
      <th>Selisih INA_CBG Kelas 1-2</th>
      <th>Max 75% INA_CBG Kelas 1</th>
      <th>Peserta Bayar</th>
    </tr>
    <?php
    $no=1;
    foreach ($record->result() as $r => $value) {
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
    ?>

      <tr>
				<td style="text-align: center;"><?=($r+1);?></td>
				<td style="text-align: center;"><?=$value->no_pasien;?></td>
				<td style="text-align: center;"><?=$jenis_bpjs;?></td>
				<td style="text-align: right;"><?=number_format($value->trf_riil_diatas_satu);?></td>
				<td style="text-align: right;"><?=number_format($value->trf_ina_cbg_satu);?></td>
				<td style="text-align: right;"><?=number_format($value->trf_ina_cbg_dua);?></td>
				<td style="text-align: right;"><?=number_format($value->selisih_riil_ina);?></td>
				<td style="text-align: right;"><?=number_format($value->selisih_ina_satu_dua);?></td>
				<td style="text-align: right;"><?=number_format($value->selisih_ina_satu);?></td>
				<td style="text-align: right;"><?=number_format($value->peserta_bayar);?></td>
			</tr>

    <?php } ?>
</table>
