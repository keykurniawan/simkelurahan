<?php
class pengguna_Service {
    private static $instance;
  
    private function __construct() {
    }

    public static function getInstance() {
       if (!isset(self::$instance)) {
           $c = __CLASS__;
           self::$instance = new $c;
       }
       return self::$instance;
    }
	//kelurahan
	public function getKelurahan(){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select * from kelurahan");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	
	}
	
	public function getPilihKelurahan($id_kelurahan){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("select * from kelurahan where id_kelurahan = '$id_kelurahan'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	
	}
	
	public function gethapuskelurahan($id_kelurahan) {
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$where[] = " id_kelurahan = '".$id_kelurahan."'";
			
			$db->delete('kelurahan', $where);
			$db->commit();
			
			return 'sukses';
		} catch (Exception $e) {
			$db->rollBack();
			$errmsgArr = explode(":",$e->getMessage());
			
			$errMsg = $errmsgArr[0];

			if($errMsg == "SQLSTATE[23000]")
			{
				return "gagal.Data Sudah Ada.";
			}
			else
			{
				return "sukses";
			}
	   }
	}
	
	public function getsimpankelurahan	(array $data) {
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("nama_kelurahan" => $data['nama_kelurahan'],
								"nama_lurah" => $data['nama_lurah'],
								"kecamatan" => $data['kecamatan'],
								"alamat" => $data['alamat'],
								"no_telepon" => $data['no_telepon'],
								"kode_pos" => $data['kode_pos'],
			
			);
			
			$db->insert('kelurahan',$paramInput);
			$db->commit();
			return 'sukses';
		} catch (Exception $e) {
			 $db->rollBack();
			 echo $e->getMessage().'<br>';
			 return 'gagal';
		}
	}
	
	public function getsimpankelurahanedit(array $data) {
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("id_kelurahan" => $data['id_kelurahan'],
								"nama_kelurahan" => $data['nama_kelurahan'],
								"nama_lurah" => $data['nama_lurah'],
								"kecamatan" => $data['kecamatan'],
								"alamat" => $data['alamat'],
								"no_telepon" => $data['no_telepon'],
								"kode_pos" => $data['kode_pos'],
			
			);
			$where[] = " id_kelurahan = '".$data['id_kelurahan']."'";
			
			$db->update('kelurahan',$paramInput, $where);
			$db->commit();			
			return 'sukses';
		} catch (Exception $e) {
			$db->rollBack();
			$errmsgArr = explode(":",$e->getMessage());
			
			$errMsg = $errmsgArr[0];

			if($errMsg == "SQLSTATE[23000]")
			{
				return "gagal.Data Sudah Ada.";
			}
			else
			{
				return "sukses";
			}
	   }
	 }  
	//jenispengguna
	public function gethapusjenispengguna($id_jenis_pengguna) {
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$where[] = " id_jenis_pengguna = '".$id_jenis_pengguna."'";
			
			$db->delete('jenis_pengguna', $where);
			$db->commit();
			
			return 'sukses';
		} catch (Exception $e) {
			$db->rollBack();
			$errmsgArr = explode(":",$e->getMessage());
			
			$errMsg = $errmsgArr[0];

			if($errMsg == "SQLSTATE[23000]")
			{
				return "gagal.Data Sudah Ada.";
			}
			else
			{
				return "sukses";
			}
	   }
	}
	
	public function getsimpanjenispengguna	(array $data) {
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("nama_jenis_pengguna" => $data['nama_jenis_pengguna']);
			
			$db->insert('jenis_pengguna',$paramInput);
			$db->commit();
			return 'sukses';
		} catch (Exception $e) {
			 $db->rollBack();
			 echo $e->getMessage().'<br>';
			 return 'gagal';
		}
	}
	public function getsimpanjenispenggunaedit(array $data) {
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("id_jenis_pengguna" => $data['id_jenis_pengguna'],
								"nama_jenis_pengguna" => $data['nama_jenis_pengguna']);
			
			$where[] = " id_jenis_pengguna = '".$data['id_jenis_pengguna']."'";
			
			$db->update('jenis_pengguna',$paramInput, $where);
			$db->commit();			
			return 'sukses';
		} catch (Exception $e) {
			$db->rollBack();
			$errmsgArr = explode(":",$e->getMessage());
			
			$errMsg = $errmsgArr[0];

			if($errMsg == "SQLSTATE[23000]")
			{
				return "gagal.Data Sudah Ada.";
			}
			else
			{
				return "sukses";
			}
	   }
	}
	
	public function getJenisPengguna(){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select * from jenis_pengguna ");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	
	}
	
	public function getPilihJenisPengguna($id_jenis_pengguna){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("select * from jenis_pengguna where id_jenis_pengguna = '$id_jenis_pengguna' ");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	
	}
	//pengguna
	public function getDataPengguna($username, $password){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("select * from pengguna where username='$username' && password='$password'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	
	
	public function getPengguna(){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("SELECT c.id_pengguna, a.nama_jenis_pengguna, b.nama_kelurahan, c.nama_pengguna, c.nip_pengguna, c.username, c.password FROM jenis_pengguna a, kelurahan b, pengguna c WHERE a.id_jenis_pengguna = c.id_jenis_pengguna && b.id_kelurahan = c.id_kelurahan LIMIT 0 , 30");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	
	public function getPilihPengguna($id_pengguna){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("SELECT c.id_pengguna,c.id_jenis_pengguna,c.id_kelurahan, a.nama_jenis_pengguna, b.nama_kelurahan, c.nama_pengguna, c.nip_pengguna, c.username, c.password FROM jenis_pengguna a, kelurahan b, pengguna c WHERE a.id_jenis_pengguna = c.id_jenis_pengguna && b.id_kelurahan = c.id_kelurahan && c.id_pengguna='$id_pengguna' LIMIT 0 , 30");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	public function gethapuspengguna($id_pengguna) {
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$where[] = " id_pengguna = '".$id_pengguna."'";
			
			$db->delete('pengguna', $where);
			$db->commit();
			
			return 'sukses';
		} catch (Exception $e) {
			$db->rollBack();
			$errmsgArr = explode(":",$e->getMessage());
			
			$errMsg = $errmsgArr[0];

			if($errMsg == "SQLSTATE[23000]")
			{
				return "gagal.Data Sudah Ada.";
			}
			else
			{
				return "sukses";
			}
	   }
	}
	
	public function getsimpanpengguna(array $data) {
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("id_jenis_pengguna" => $data['id_jenis_pengguna'],
								"id_kelurahan" => $data['id_kelurahan'],
								"nama_pengguna" => $data['nama_pengguna'],
								"nip_pengguna" => $data['nip_pengguna'],
								"username" => $data['username'],
								"password" => $data['password']);
			
			$db->insert('pengguna',$paramInput);
			$db->commit();
			return 'sukses';
		} catch (Exception $e) {
			 $db->rollBack();
			 echo $e->getMessage().'<br>';
			 return 'gagal';
		}
	}
	
	public function getsimpanpenggunaedit(array $data) {
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("id_pengguna"=>$data['id_pengguna'],
								"id_jenis_pengguna" => $data['id_jenis_pengguna'],
								"id_kelurahan" => $data['id_kelurahan'],
								"nama_pengguna" => $data['nama_pengguna'],
								"nip_pengguna" => $data['nip_pengguna'],
								"username" => $data['username'],
								"password" => $data['password']);
			
			$where[] = " id_pengguna = '".$data['id_pengguna']."'";
			
			$db->update('pengguna',$paramInput, $where);
			$db->commit();			
			return 'sukses';
		} catch (Exception $e) {
			$db->rollBack();
			$errmsgArr = explode(":",$e->getMessage());
			
			$errMsg = $errmsgArr[0];

			if($errMsg == "SQLSTATE[23000]")
			{
				return "gagal.Data Sudah Ada.";
			}
			else
			{
				return "sukses";
			}
	   }
	}
	//surat
	public function getSurat($id_surat){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select nama_surat from surat where id_surat = '$id_surat'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	public function getPilihSurat($id_surat){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("select a.id_jenis_surat, a.id_surat, a.nama_surat, b.nama_jenis_surat from  surat a, jenis_surat b where a.id_jenis_surat = b.id_jenis_surat && id_surat = '$id_surat'");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	public function gethapussurat($id_surat) {
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$where[] = " id_surat = '".$id_surat."'";
			
			$db->delete('surat', $where);
			$db->commit();
			
			return 'sukses';
		} catch (Exception $e) {
			$db->rollBack();
			$errmsgArr = explode(":",$e->getMessage());
			
			$errMsg = $errmsgArr[0];

			if($errMsg == "SQLSTATE[23000]")
			{
				return "gagal.Data Sudah Ada.";
			}
			else
			{
				return "sukses";
			}
	   }
	}
	public function getsimpansurat(array $data) {
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("nama_surat" => $data['nama_surat'],
						"id_jenis_surat" => $data['id_jenis_surat']);
			
			$db->insert('surat',$paramInput);
			$db->commit();
			return 'sukses';
		} catch (Exception $e) {
			 $db->rollBack();
			 echo $e->getMessage().'<br>';
			 return 'gagal';
		}
	}
	public function getsimpansuratedit(array $data) {
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("id_surat" => $data['id_surat'],
			"nama_surat" => $data['nama_surat'],
						"id_jenis_surat" => $data['id_jenis_surat']);
			
			$where[] = " id_surat = '".$data['id_surat']."'";
			
			$db->update('surat',$paramInput, $where);
			$db->commit();			
			return 'sukses';
		} catch (Exception $e) {
			$db->rollBack();
			$errmsgArr = explode(":",$e->getMessage());
			
			$errMsg = $errmsgArr[0];

			if($errMsg == "SQLSTATE[23000]")
			{
				return "gagal.Data Sudah Ada.";
			}
			else
			{
				return "sukses";
			}
	   }
	 }
	//permintaan
	public function getPermintaan($id_surat){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("SELECT  a.nomor_surat, a.tgl_surat, b.nik, b.nama_lengkap, b.rt, b.rw
										FROM permintaan a, data_penduduk b WHERE a.nik_penduduk = b.nik LIMIT 0 , 30");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	public function getDataPermintaanAcc($id_jenis_pengguna,$id_kelurahan){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("SELECT a.id_permintaan , a.nomor_surat, a.tgl_surat, b.nik, 		b.nama_lengkap, b.rt, b.rw, c.nama_surat, d.nama_kelurahan
										FROM permintaan a, data_penduduk b, surat c, kelurahan d WHERE a.id_kelurahan=d.id_kelurahan && a.id_surat = c.id_surat && a.nik_penduduk = b.nik && a.id_kelurahan='$id_kelurahan' 
										&& a.id_jenis_pengguna='$id_jenis_pengguna' && status_nya=1 LIMIT 0 , 30");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	public function getDataPermintaan($id_jenis_pengguna,$id_kelurahan){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("SELECT a.id_permintaan , a.nomor_surat, a.tgl_surat, b.nik, 		b.nama_lengkap, b.rt, b.rw, c.nama_surat, d.nama_kelurahan
										FROM permintaan a, data_penduduk b, surat c, kelurahan d WHERE a.id_kelurahan=d.id_kelurahan && a.id_surat = c.id_surat && a.nik_penduduk = b.nik && a.id_kelurahan='$id_kelurahan' 
										&& a.id_jenis_pengguna='$id_jenis_pengguna' && status_nya=0 LIMIT 0 , 30");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	//////////////////////////////permintaaan acc
	public function getaccsekolah($id_permintaan){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("id_permintaan_sekolah" => $id_permintaan,
								"status" => 1);
			
			$where[] = " id_permintaan_sekolah = '".$id_permintaan."'";
			
			$db->update('permintaan_sekolah',$paramInput, $where);
			$db->commit();			
			return 'sukses';
		} catch (Exception $e) {
			$db->rollBack();
			$errmsgArr = explode(":",$e->getMessage());
			
			$errMsg = $errmsgArr[0];

			if($errMsg == "SQLSTATE[23000]")
			{
				return "gagal.Data Sudah Ada.";
			}
			else
			{
				return "sukses";
			}
	   }
	
	}
		public function getaccrumahsakit($id_permintaan){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("id_permintaan_rumahsakit" => $id_permintaan,
								"status" => 1);
			
			$where[] = " id_permintaan_rumahsakit = '".$id_permintaan."'";
			
			$db->update('permintaan_rumahsakit',$paramInput, $where);
			$db->commit();			
			return 'sukses';
		} catch (Exception $e) {
			$db->rollBack();
			$errmsgArr = explode(":",$e->getMessage());
			
			$errMsg = $errmsgArr[0];

			if($errMsg == "SQLSTATE[23000]")
			{
				return "gagal.Data Sudah Ada.";
			}
			else
			{
				return "sukses";
			}
	   }
	
	}
		public function getaccps($id_permintaan){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("id_permintaan_ps" => $id_permintaan,
								"status" => 1);
			
			$where[] = " id_permintaan_ps = '".$id_permintaan."'";
			
			$db->update('permintaan_ps',$paramInput, $where);
			$db->commit();			
			return 'sukses';
		} catch (Exception $e) {
			$db->rollBack();
			$errmsgArr = explode(":",$e->getMessage());
			
			$errMsg = $errmsgArr[0];

			if($errMsg == "SQLSTATE[23000]")
			{
				return "gagal.Data Sudah Ada.";
			}
			else
			{
				return "sukses";
			}
	   }
	
	}	
	public function getaccjanda($id_permintaan){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("id_permintaan_janda" => $id_permintaan,
								"status" => 1);
			
			$where[] = " id_permintaan_janda = '".$id_permintaan."'";
			
			$db->update('permintaan_janda',$paramInput, $where);
			$db->commit();			
			return 'sukses';
		} catch (Exception $e) {
			$db->rollBack();
			$errmsgArr = explode(":",$e->getMessage());
			
			$errMsg = $errmsgArr[0];

			if($errMsg == "SQLSTATE[23000]")
			{
				return "gagal.Data Sudah Ada.";
			}
			else
			{
				return "sukses";
			}
	   }
	
	}	
	public function getaccik($id_permintaan){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("id_permintaan_ik" => $id_permintaan,
								"status" => 1);
			
			$where[] = " id_permintaan_ik = '".$id_permintaan."'";
			
			$db->update('permintaan_ik',$paramInput, $where);
			$db->commit();			
			return 'sukses';
		} catch (Exception $e) {
			$db->rollBack();
			$errmsgArr = explode(":",$e->getMessage());
			
			$errMsg = $errmsgArr[0];

			if($errMsg == "SQLSTATE[23000]")
			{
				return "gagal.Data Sudah Ada.";
			}
			else
			{
				return "sukses";
			}
	   }
	
	}
		public function getaccibadahhaji($id_permintaan){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("id_permintaan_ibadahhaji" => $id_permintaan,
								"status" => 1);
			
			$where[] = " id_permintaan_ibadahhaji = '".$id_permintaan."'";
			
			$db->update('permintaan_ibadahhaji',$paramInput, $where);
			$db->commit();			
			return 'sukses';
		} catch (Exception $e) {
			$db->rollBack();
			$errmsgArr = explode(":",$e->getMessage());
			
			$errMsg = $errmsgArr[0];

			if($errMsg == "SQLSTATE[23000]")
			{
				return "gagal.Data Sudah Ada.";
			}
			else
			{
				return "sukses";
			}
	   }
	
	}
		public function getaccbpr($id_permintaan){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("id_permintaan_bpr" => $id_permintaan,
								"status" => 1);
			
			$where[] = " id_permintaan_bpr = '".$id_permintaan."'";
			
			$db->update('permintaan_bpr',$paramInput, $where);
			$db->commit();			
			return 'sukses';
		} catch (Exception $e) {
			$db->rollBack();
			$errmsgArr = explode(":",$e->getMessage());
			
			$errMsg = $errmsgArr[0];

			if($errMsg == "SQLSTATE[23000]")
			{
				return "gagal.Data Sudah Ada.";
			}
			else
			{
				return "sukses";
			}
	   }
	
	}
		public function getaccbelummenikah($id_permintaan){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("id_permintaan_belummenikah" => $id_permintaan,
								"status" => 1);
			
			$where[] = " id_permintaan_belummenikah = '".$id_permintaan."'";
			
			$db->update('permintaan_belummenikah',$paramInput, $where);
			$db->commit();			
			return 'sukses';
		} catch (Exception $e) {
			$db->rollBack();
			$errmsgArr = explode(":",$e->getMessage());
			
			$errMsg = $errmsgArr[0];

			if($errMsg == "SQLSTATE[23000]")
			{
				return "gagal.Data Sudah Ada.";
			}
			else
			{
				return "sukses";
			}
	   }
	
	}
		public function getaccbd($id_permintaan){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("id_permintaan_bd" => $id_permintaan,
								"status" => 1);
			
			$where[] = " id_permintaan_bd = '".$id_permintaan."'";
			
			$db->update('permintaan_bd',$paramInput, $where);
			$db->commit();			
			return 'sukses';
		} catch (Exception $e) {
			$db->rollBack();
			$errmsgArr = explode(":",$e->getMessage());
			
			$errMsg = $errmsgArr[0];

			if($errMsg == "SQLSTATE[23000]")
			{
				return "gagal.Data Sudah Ada.";
			}
			else
			{
				return "sukses";
			}
	   }
	
	}
		public function getaccandonnikah($id_permintaan){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("id_permintaan_andonnikah" => $id_permintaan,
								"status" => 1);
			
			$where[] = " id_permintaan_andonnikah = '".$id_permintaan."'";
			
			$db->update('permintaan_andonnikah',$paramInput, $where);
			$db->commit();			
			return 'sukses';
		} catch (Exception $e) {
			$db->rollBack();
			$errmsgArr = explode(":",$e->getMessage());
			
			$errMsg = $errmsgArr[0];

			if($errMsg == "SQLSTATE[23000]")
			{
				return "gagal.Data Sudah Ada.";
			}
			else
			{
				return "sukses";
			}
	   }
	
	}
	
	//pejabat
	public function getJabatan(){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select * from jenis_pengguna where id_jenis_pengguna != 1 && id_jenis_pengguna !=2");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	public function getDataPejabat(){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select a.id_pejabat, a.nama_pejabat, a.nip_pejabat, b.nama_kelurahan, c.nama_jenis_pengguna from pejabat_kelurahan a, kelurahan b, jenis_pengguna c where a.id_kelurahan = b.id_kelurahan && a.id_jenis_pengguna = c.id_jenis_pengguna");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	public function gethapuspejabat($id_pejabat) {
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$where[] = " id_pejabat = '".$id_pejabat."'";
			
			$db->delete('pejabat_kelurahan', $where);
			$db->commit();
			
			return 'sukses';
		} catch (Exception $e) {
			$db->rollBack();
			$errmsgArr = explode(":",$e->getMessage());
			
			$errMsg = $errmsgArr[0];

			if($errMsg == "SQLSTATE[23000]")
			{
				return "gagal.Data Sudah Ada.";
			}
			else
			{
				return "sukses";
			}
	   }
	}
	public function getsimpanpejabat(array $data) {
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("nip_pejabat" => $data['nip_pejabat'],
							"nama_pejabat" => $data['nama_pejabat'],
							"id_kelurahan" => $data['id_kelurahan'],
						"id_jenis_pengguna" => $data['id_jenis_pengguna']);
			
			$db->insert('pejabat_kelurahan',$paramInput);
			$db->commit();
			return 'sukses';
		} catch (Exception $e) {
			 $db->rollBack();
			 echo $e->getMessage().'<br>';
			 return 'gagal';
		}
	}
	public function getPejabatId($id_pejabat){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchRow("select * from pejabat_kelurahan where id_pejabat = $id_pejabat");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	public function getsimpanpejabatedit(array $data) {
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("id_pejabat" => $data['id_pejabat'],
							"nip_pejabat" => $data['nip_pejabat'],
							"nama_pejabat" => $data['nama_pejabat'],
							"id_kelurahan" => $data['id_kelurahan'],
						"id_jenis_pengguna" => $data['id_jenis_pengguna']);
			
			$where[] = " id_pejabat = '".$data['id_pejabat']."'";
			
			$db->update('pejabat_kelurahan',$paramInput, $where);
			$db->commit();			
			return 'sukses';
		} catch (Exception $e) {
			$db->rollBack();
			$errmsgArr = explode(":",$e->getMessage());
			
			$errMsg = $errmsgArr[0];

			if($errMsg == "SQLSTATE[23000]")
			{
				return "gagal.Data Sudah Ada.";
			}
			else
			{
				return "sukses";
			}
	   }
	 }
	//jenis surat
	public function getDataSurat(){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select a.id_surat, a.nama_surat, b.nama_jenis_surat from  surat a, jenis_surat b where a.id_jenis_surat = b.id_jenis_surat");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	public function getJenisSurat(){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select *from jenis_surat");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	
	//menu umum
	public function getPemberdayaan(){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select * from surat where id_jenis_surat = 1");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	public function getTantrib(){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select * from surat where id_jenis_surat = 2");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	public function getEkonomiPembangunan(){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select * from surat where id_jenis_surat = 3");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	public function getPemerintahan(){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->setFetchMode(Zend_Db::FETCH_OBJ); 		
				$result = $db->fetchAll("select *from surat where id_jenis_surat = 4");
				return $result;
		   } catch (Exception $e) {
	         echo $e->getMessage().'<br>';
		     return 'Data tidak ada <br>';
		   }
	}
	//ekbang acc
	public function getaccdomisiliyayasan($id_permintaan){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("id_permintaan_domisili_yayasan" => $id_permintaan,
								"status" => 1);
			
			$where[] = " id_permintaan_domisili_yayasan = '".$id_permintaan."'";
			
			$db->update('permintaan_domisili_yayasan',$paramInput, $where);
			$db->commit();			
			return 'sukses';
		} catch (Exception $e) {
			$db->rollBack();
			$errmsgArr = explode(":",$e->getMessage());
			
			$errMsg = $errmsgArr[0];

			if($errMsg == "SQLSTATE[23000]")
			{
				return "gagal.Data Sudah Ada.";
			}
			else
			{
				return "sukses";
			}
	   }
	}
	public function getaccdomisiliparpol($id_permintaan){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("id_permintaan_domisili_parpol" => $id_permintaan,
								"status" => 1);
			
			$where[] = " id_permintaan_domisili_parpol = '".$id_permintaan."'";
			
			$db->update('permintaan_domisili_parpol',$paramInput, $where);
			$db->commit();			
			return 'sukses';
		} catch (Exception $e) {
			$db->rollBack();
			$errmsgArr = explode(":",$e->getMessage());
			
			$errMsg = $errmsgArr[0];

			if($errMsg == "SQLSTATE[23000]")
			{
				return "gagal.Data Sudah Ada.";
			}
			else
			{
				return "sukses";
			}
	   }
	}	
	public function getaccdomisiliperusahaan($id_permintaan){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("id_permintaan_domisili_perusahaan" => $id_permintaan,
								"status" => 1);
			
			$where[] = " id_permintaan_domisili_perusahaan = '".$id_permintaan."'";
			
			$db->update('permintaan_domisili_perusahaan',$paramInput, $where);
			$db->commit();			
			return 'sukses';
		} catch (Exception $e) {
			$db->rollBack();
			$errmsgArr = explode(":",$e->getMessage());
			
			$errMsg = $errmsgArr[0];

			if($errMsg == "SQLSTATE[23000]")
			{
				return "gagal.Data Sudah Ada.";
			}
			else
			{
				return "sukses";
			}
	   }
	}
	public function getaccketerangantempatusaha($id_permintaan){
		$registry = Zend_Registry::getInstance();
		$db = $registry->get('db');
		try {
			$db->beginTransaction();
			$paramInput = array("id_permintaan_keterangan_tempat_usaha" => $id_permintaan,
								"status" => 1);
			
			$where[] = " id_permintaan_keterangan_tempat_usaha = '".$id_permintaan."'";
			
			$db->update('permintaan_keterangan_tempat_usaha',$paramInput, $where);
			$db->commit();			
			return 'sukses';
		} catch (Exception $e) {
			$db->rollBack();
			$errmsgArr = explode(":",$e->getMessage());
			
			$errMsg = $errmsgArr[0];

			if($errMsg == "SQLSTATE[23000]")
			{
				return "gagal.Data Sudah Ada.";
			}
			else
			{
				return "sukses";
			}
	   }
	}
	
}
?>
