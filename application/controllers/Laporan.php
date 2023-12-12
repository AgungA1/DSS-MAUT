<?php
    
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Perhitungan_model');
    }

    public function cetak_laporan_hasil()
    {
        $kriteria = $this->Perhitungan_model->get_kriteria();
        $alternatif = $this->Perhitungan_model->get_alternatif();

        $this->Perhitungan_model->hapus_hasil();

        foreach ($alternatif as $keys) {
            $nilai_total_benefit = 0;
            $nilai_total_cost = 0;

            foreach ($kriteria as $key) {
                $data_pencocokan = $this->Perhitungan_model->data_nilai($keys->id_alternatif, $key->id_kriteria);
                $min_max = $this->Perhitungan_model->get_max_min($key->id_kriteria);

                $bobot = $key->bobot;

                // Keputusan untuk menentukan jenis kriteria
                if ($key->jenis_kriteria == 'benefit') {
                    // Rumus normalisasi untuk kriteria benefit
                    $hasil_normalisasi_benefit = @(round(($data_pencocokan['nilai'] - $min_max['min']) / ($min_max['max'] - $min_max['min']), 4));
                    $nilai_total_benefit += $bobot * $hasil_normalisasi_benefit;
                } elseif ($key->jenis_kriteria == 'cost') {
                    // Rumus normalisasi untuk kriteria cost
                    $hasil_normalisasi_cost = @(round(1 + ($min_max['min'] - $data_pencocokan['nilai']) / ($min_max['max'] - $min_max['min']), 4));
                    $nilai_total_cost += $bobot * $hasil_normalisasi_cost;
                }
            }

            // Gabungkan hasil untuk benefit dan cost
            $hasil_akhir = [
                'id_alternatif' => $keys->id_alternatif,
                'nilai_benefit' => $nilai_total_benefit,
                'nilai_cost' => $nilai_total_cost,
            ];

            $result = $this->Perhitungan_model->insert_nilai_hasil($hasil_akhir);
        }

        $data = [
            'hasil' => $this->Perhitungan_model->get_hasil()
        ];

        $this->load->library('pdf');

        $this->pdf->setPaper('A4', 'portrait');
        $this->pdf->filename = "Laporan_Hasil.pdf";
        $this->pdf->load_view('laporan_hasil', $data);
    } 
}
