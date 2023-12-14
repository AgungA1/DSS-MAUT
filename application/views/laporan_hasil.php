<!DOCTYPE html>
<html>
<head>
	<title>Sistem Pendukung Keputusan Metode MAUT</title>
</head>
<style>
    table {
        border-collapse: collapse;
    }
    /* table, th, td {
        border: 1px solid black;
    } */
	.line-title {
		border: 0;
		border-style: inset;
		border-top: 1px solid #000;
		margin-top: 15px;
	}
</style>
<body>
	<table style="width: 100%;">
	<tr>
		<td align="center">
			<span style="line-height: 1.7; font-weight: bold;">
				POLITEKNIK NEGERI MALANG
				<br>MALANG, INDONESIA
			</span>
		</td>
	</tr>
</table>

<hr class="line-title">
<p align="center">
	LAPORAN DATA KARYAWAN <br>
</p>

<?php
// Mengurutkan hasil berdasarkan nilai preferensi
usort($hasil, function($a, $b) {
    return ($b->nilai_benefit + $b->nilai_cost) - ($a->nilai_benefit + $a->nilai_cost);
});
?>

<table border="1" width="100%">
	<thead>
		<tr align="center">
			<th>NIK</th>
			<th>Alternatif / Nama Karyawan</th>
			<th>Jabatan</th>
			<th>Nilai Preferensi</th>
			<th width="15%">Ranking</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$no=1;
			foreach ($hasil as $keys): ?>
		<tr align="center">
			<td style="padding-left: 5px;">
				<?php
				$nim_alternatif = $this->Perhitungan_model->get_hasil_alternatif($keys->id_alternatif);
				echo $nim_alternatif['nik'];
				?>
			</td>
			<td align="left" style="padding-left: 5px;">
				<?php
				$nama_alternatif = $this->Perhitungan_model->get_hasil_alternatif($keys->id_alternatif);
				echo $nama_alternatif['nama'];
				?>
			</td>
			<td style="padding-left: 5px;">
				<?php
				$jurusan_alternatif = $this->Perhitungan_model->get_hasil_alternatif($keys->id_alternatif);
				echo $jurusan_alternatif['departemen'];
				?>
			</td>
			<td>
				<?= $keys->nilai_benefit + $keys->nilai_cost; ?>
			</td>
			<td><?= $no; ?></td>
		</tr>
		<?php
			$no++;
			endforeach ?>
	</tbody>
</table>
</body>
</html>
