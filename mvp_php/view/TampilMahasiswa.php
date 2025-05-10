<?php

/******************************************
 Asisten Pemrogaman 13 & 14
******************************************/

include("KontrakView.php");
include("presenter/ProsesMahasiswa.php");

class TampilMahasiswa implements KontrakView
{
	private $prosesmahasiswa; // Presenter yang dapat berinteraksi langsung dengan view
	private $tpl;

	function __construct()
	{
		//konstruktor
		$this->prosesmahasiswa = new ProsesMahasiswa();
	}

	function tampil()
	{
		// Proses delete jika ada parameter GET 'delete'
		if (isset($_GET['delete'])) {
			$id = $_GET['delete'];
			$this->prosesmahasiswa->deleteDataMahasiswa($id);
			header("Location: index.php");
			exit();
		}

		// Proses update jika ada data POST dan id_edit
		if (
			isset($_POST['id_edit']) && isset($_POST['nim']) && isset($_POST['nama']) && isset($_POST['tempat']) &&
			isset($_POST['tl']) && isset($_POST['gender']) && isset($_POST['email']) && isset($_POST['telp'])
		) {
			$this->prosesmahasiswa->updateDataMahasiswa(
				$_POST['id_edit'],
				$_POST['nim'],
				$_POST['nama'],
				$_POST['tempat'],
				$_POST['tl'],
				$_POST['gender'],
				$_POST['email'],
				$_POST['telp']
			);
			header("Location: index.php");
			exit();
		}

		// Proses insert jika ada data POST tanpa id_edit
		if (
			!isset($_POST['id_edit']) && isset($_POST['nim']) && isset($_POST['nama']) && isset($_POST['tempat']) &&
			isset($_POST['tl']) && isset($_POST['gender']) && isset($_POST['email']) && isset($_POST['telp'])
		) {
			$this->prosesmahasiswa->insertDataMahasiswa(
				$_POST['nim'],
				$_POST['nama'],
				$_POST['tempat'],
				$_POST['tl'],
				$_POST['gender'],
				$_POST['email'],
				$_POST['telp']
			);
			header("Location: index.php");
			exit();
		}

		$this->prosesmahasiswa->prosesDataMahasiswa();
		$data = null;

		// Cek jika ada parameter GET 'edit' untuk form edit
		$editData = null;
		if (isset($_GET['edit'])) {
			$editId = $_GET['edit'];
			for ($i = 0; $i < $this->prosesmahasiswa->getSize(); $i++) {
				if ($this->prosesmahasiswa->getId($i) == $editId) {
					$editData = [
						'id' => $this->prosesmahasiswa->getId($i),
						'nim' => $this->prosesmahasiswa->getNim($i),
						'nama' => $this->prosesmahasiswa->getNama($i),
						'tempat' => $this->prosesmahasiswa->getTempat($i),
						'tl' => $this->prosesmahasiswa->getTl($i),
						'gender' => $this->prosesmahasiswa->getGender($i),
						'email' => $this->prosesmahasiswa->getEmail($i),
						'telp' => $this->prosesmahasiswa->getTelp($i)
					];
					break;
				}
			}
		}

		// Tabel data mahasiswa + tombol aksi
		for ($i = 0; $i < $this->prosesmahasiswa->getSize(); $i++) {
			$no = $i + 1;
			$data .= "<tr>
			<td>" . $no . "</td>
			<td>" . $this->prosesmahasiswa->getNim($i) . "</td>
			<td>" . $this->prosesmahasiswa->getNama($i) . "</td>
			<td>" . $this->prosesmahasiswa->getTempat($i) . "</td>
			<td>" . $this->prosesmahasiswa->getTl($i) . "</td>
			<td>" . $this->prosesmahasiswa->getGender($i) . "</td>
			<td>" . $this->prosesmahasiswa->getEmail($i) . "</td>
			<td>" . $this->prosesmahasiswa->getTelp($i) . "</td>
			<td>
				<a href='?edit=" . $this->prosesmahasiswa->getId($i) . "' class='btn btn-warning btn-sm'>Edit</a>
				<a href='?delete=" . $this->prosesmahasiswa->getId($i) . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin hapus data?\")'>Delete</a>
			</td>
			</tr>";
		}

		// Membaca template skin.html
		$this->tpl = new Template("templates/skin.html");

		// Ganti form jika mode edit
		$formHtml = '';
		if ($editData) {
			$formHtml = '<form method="post" action="">
			<input type="hidden" name="id_edit" value="' . $editData['id'] . '">
			<div class="form-row">';
			$formHtml .= '<div class="form-group col-md-2"><input type="text" class="form-control" name="nim" value="' . $editData['nim'] . '" required></div>';
			$formHtml .= '<div class="form-group col-md-2"><input type="text" class="form-control" name="nama" value="' . $editData['nama'] . '" required></div>';
			$formHtml .= '<div class="form-group col-md-2"><input type="text" class="form-control" name="tempat" value="' . $editData['tempat'] . '" required></div>';
			$formHtml .= '<div class="form-group col-md-2"><input type="date" class="form-control" name="tl" value="' . $editData['tl'] . '" required></div>';
			$formHtml .= '<div class="form-group col-md-1"><select class="form-control" name="gender" required>';
			$formHtml .= '<option value="">Gender</option>';
			$formHtml .= '<option value="Laki-laki"' . ($editData['gender'] == 'Laki-laki' ? ' selected' : '') . '>Laki-laki</option>';
			$formHtml .= '<option value="Perempuan"' . ($editData['gender'] == 'Perempuan' ? ' selected' : '') . '>Perempuan</option>';
			$formHtml .= '</select></div>';
			$formHtml .= '<div class="form-group col-md-2"><input type="email" class="form-control" name="email" value="' . $editData['email'] . '" required></div>';
			$formHtml .= '<div class="form-group col-md-1"><input type="text" class="form-control" name="telp" value="' . $editData['telp'] . '" required></div>';
			$formHtml .= '</div><button type="submit" class="btn btn-primary">Update</button> <a href="index.php" class="btn btn-secondary">Batal</a></form>';
		} else {
			// Form tambah (default dari template)
			$formHtml = null;
		}

		// Ganti placeholder FORM_MHS jika ada
		$this->tpl->replace("FORM_MHS", $formHtml);
		// Mengganti kode Data_Tabel dengan data yang sudah diproses
		$this->tpl->replace("DATA_TABEL", $data);

		// Menampilkan ke layar
		$this->tpl->write();
	}
}
