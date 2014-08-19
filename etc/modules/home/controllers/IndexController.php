<?php
require_once 'Zend/Controller/Action.php';
require_once 'Zend/Session.php';
require_once "service/pengguna/Pengguna_Service.php";
require_once "service/pengguna/Surat_Service.php";
require_once 'Zend/Session/Namespace.php';
class Home_IndexController extends Zend_Controller_Action {
	
    public function init() {
       // Local to this controller only; affects all actions, as loaded in init:
	   //UNTUK SETTING GLOBAL BASE PATH
		$registry = Zend_Registry::getInstance();
		$this->auth = Zend_Auth::getInstance();	   
		$this->view->baseData = $registry->get('baseData');
		$this->view->basePath = $registry->get('basepath');
		$this->view->procPath = $registry->get('procpath');	 
		
		
		$user = new Zend_Session_Namespace('user');
		$this->id_kelurahan = $user->id_kelurahan;
		$this->id_jenis_pengguna = $user->id_jenis_pengguna;
		$this->id_pengguna = $user->id_pengguna;
		
		
		$this->pengguna = Pengguna_Service::getInstance();
		$this->kelurahan_serv = Pengguna_Service::getInstance();
		$this->data_serv = Pengguna_Service::getInstance();
		$this->surat_serv = Surat_Service::getInstance();
	
		
		$this->view->pemberdayaan = $this->data_serv->getPemberdayaan();
		$this->view->tantrib = $this->data_serv->getTantrib();
		$this->view->ekonomipembangunan = $this->data_serv->getEkonomiPembangunan();
		$this->view->pemerintahan = $this->data_serv->getPemerintahan();
		
    }
	public function indexAction() {
	 
    }
	public function logoutAction(){
		$user = new Zend_Session_Namespace('user');
		$user->unsetAll();
		$this->render('index');
		  
	}
	public function homeAction(){
		
		$username = $_POST['username'];
		$password = $_POST['password'];
		$jenispengguna = $_POST['jenispengguna'];
		
			if($username && $password){
				$hasil = $this->data_serv->getDataPengguna($username, $password);
				//echo "jajajjaajalsdfssssssssssssssssssssssssssssss <br>";
				//echo $hasil->id_jenis_pengguna;
				$user = new Zend_Session_Namespace('user');
				$id_jenis_pengguna = $hasil->id_jenis_pengguna;
				$id_kelurahan = $hasil->id_kelurahan;
				$id_pengguna = $hasil->id_pengguna;
				
				$user->id_jenis_pengguna = $hasil->id_jenis_pengguna;
				$user->id_kelurahan = $hasil->id_kelurahan;
				$user->id_pengguna = $hasil->id_pengguna;
				
				$this->id_kelurahan = $user->id_kelurahan;
				$this->id_jenis_pengguna = $user->id_jenis_pengguna;
				$this->id_pengguna = $user->id_pengguna;
				if($hasil){
					
					//Zend_Session::destroy( true );
					
					
					if($hasil->id_jenis_pengguna==1){
						
						$this->homeadminAction();
						$this->render('homeadmin');
					}else if($hasil->id_jenis_pengguna==2){
						$this->view;
						$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
					}else if($hasil->id_jenis_pengguna>2 && $hasil->id_jenis_pengguna<7){
						if($hasil->id_jenis_pengguna==3){
							$this->rumahsakitAction();
							$this->render('rumahsakit');
						}else if($hasil->id_jenis_pengguna==4){
							$this->ikAction();
							$this->render('ik');
						}else if($hasil->id_jenis_pengguna==5){
							$this->domisiliyayasanAction();
							$this->render('domisiliyayasan');
						}else if($hasil->id_jenis_pengguna==6){
						
						}
					}
				}else{
					$this->view->peringatan ="username dan password yang anda masukan tidak sesuai";
					$this->indexAction();
					$this->render('index');
				}
				
				
				
			
			}else{
				$this->view->peringatan ="anda belum mengisi username dan password";
				$this->indexAction();
				$this->render('index');
			}
		
		
		
		
	}
	//admin //pengguna
	public function homeadminAction(){
		// $this->view;
		$this->view->Pengguna = $this->pengguna->getPengguna();	
	}
	
	public function penggunahapusAction(){
		$id_pengguna= $this->_getParam("id_pengguna");
		$hasil = $this->pengguna->gethapuspengguna($id_pengguna);
		
		$this->homeadminAction();
		$this->render('homeadmin');	
	}
	public function tambahpenggunaAction(){
		$this->view->kelurahan = $this->kelurahan_serv->getKelurahan();
		$this->view->jenis_pengguna = $this->pengguna->getJenisPengguna();
	}
    public function simpanpenggunaAction(){
		$id_jenis_pengguna = $_POST['id_jenis_pengguna'];
		$id_kelurahan = $_POST['id_kelurahan'];
		$nama_pengguna = $_POST['nama_pengguna'];
		$nip_pengguna = $_POST['nip_pengguna'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		$data = array("id_jenis_pengguna" => $id_jenis_pengguna,
							"id_kelurahan" => $id_kelurahan,
							"nama_pengguna" => $nama_pengguna,
							"nip_pengguna" => $nip_pengguna,
							"username" => $username,
							"password" => $password);
									 
		$hasil = $this->pengguna->getsimpanpengguna($data);
		$this->homeadminAction();
		$this->render('homeadmin');	
	}
	public function penggunaeditAction(){
		$this->view;
		$id_pengguna = $this->_getParam('id_pengguna');
		$this->view->jenis_pengguna = $this->pengguna->getJenisPengguna();
		$hasil = $this->data_serv->getPilihPengguna($id_pengguna);
		$this->view->pengguna = $hasil; 
	}
	public function simpanpenggunaeditAction(){
		$id_pengguna = $this->_getParam('id_pengguna');
		$id_jenis_pengguna = $_POST['id_jenis_pengguna'];
		$id_kelurahan = $_POST['id_kelurahan'];
		$nama_pengguna = $_POST['nama_pengguna'];
		$nip_pengguna = $_POST['nip_pengguna'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		$data = array("id_pengguna" => $id_pengguna,
							"id_jenis_pengguna" => $id_jenis_pengguna,
							"id_kelurahan" => $id_kelurahan,
							"nama_pengguna" => $nama_pengguna,
							"nip_pengguna" => $nip_pengguna,
							"username" => $username,
							"password" => $password);
									 
		$hasil = $this->pengguna->getsimpanpenggunaedit($data);
		$this->homeadminAction();
		$this->render('homeadmin');	
	}
	//kelurahan
	public function kelurahanAction(){
		$this->view;
		$this->view->kelurahan = $this->kelurahan_serv->getKelurahan();
	}
	public function tambahkelurahanAction(){
		$this->view;
		//$this->view->kelurahan = $this->kelurahan_serv->getKelurahan();
	}
	public function kelurahanhapusAction(){
		$id_kelurahan= $this->_getParam("id_kelurahan");
		$hasil = $this->pengguna->gethapuskelurahan($id_kelurahan);
		
		$this->kelurahanAction();
		$this->render('kelurahan');	
	}
	
	public function simpankelurahanAction(){
		$kode_kelurahan = $_POST['kode_kelurahana'];
		$nama_kelurahan = $_POST['nama_kelurahan'];
		$nama_lurah= $_POST['nama_lurah'];
		$kecamatan= $_POST['kecamatan'];
		$alamat = $_POST['alamat'];
		$no_telepon = $_POST['no_telepon'];
		$kode_pos = $_POST['kode_pos'];
		
		
		$data = array("nama_kelurahan" => $nama_kelurahan,
						"nama_lurah" => $nama_lurah,
						"kecamatan" => $kecamatan,
						"alamat" => $alamat,
						"no_telepon" => $no_telepon,
						"kode_pos" => $kode_pos,
		);
									 
		$hasil = $this->pengguna->getsimpankelurahan($data);
		$this->kelurahanAction();
		$this->render('kelurahan');	
	}
	public function kelurahaneditAction(){
		$id_kelurahan = $this->_getParam('id_kelurahan');
		$this->view->kelurahan = $this->data_serv->getPilihKelurahan($id_kelurahan);
	}
	public function simpankelurahaneditAction(){
		$id_kelurahan = $this->_getParam('id_kelurahan');
		$nama_kelurahan = $_POST['nama_kelurahan'];
		$nama_lurah= $_POST['nama_lurah'];
		$kecamatan= $_POST['kecamatan'];
		$alamat = $_POST['alamat'];
		$no_telepon = $_POST['no_telepon'];
		$kode_pos = $_POST['kode_pos'];
		
		
		$data = array("nama_kelurahan" => $nama_kelurahan,
						"id_kelurahan" => $id_kelurahan,
						"nama_lurah" => $nama_lurah,
						"kecamatan" => $kecamatan,
						"alamat" => $alamat,
						"no_telepon" => $no_telepon,
						"kode_pos" => $kode_pos,
		);						 
		$hasil = $this->pengguna->getsimpankelurahanedit($data);
		$this->kelurahanAction();
		$this->render('kelurahan');	
	}
	
	//jenis pengguna
	
	public function jenispenggunaAction(){
		$this->view;
		$this->view->jenis_pengguna = $this->pengguna->getJenisPengguna();
	} 
	
	public function jenispenggunahapusAction(){
		$id_jenis_pengguna= $this->_getParam("id_jenis_pengguna");
		$hasil = $this->pengguna->gethapusjenispengguna($id_jenis_pengguna);
		
		$this->jenispenggunaAction();
		$this->render('jenispengguna');	
	}
	public function tambahjenispenggunaAction(){
		//$this view;
	}
	public function jenispenggunaeditAction(){
		$this->view;
		$id_jenis_pengguna = $this->_getParam('id_jenis_pengguna');
		$hasil = $this->data_serv->getPilihJenisPengguna($id_jenis_pengguna);
		$this->view->jenispengguna = $hasil;
	}
	
	
	public function simpanjenispenggunaAction(){
		$nama_jenis_pengguna = $_POST['nama_jenis_pengguna'];
		
		
		$data = array("nama_jenis_pengguna" => $nama_jenis_pengguna);
									 
		$hasil = $this->pengguna->getsimpanjenispengguna($data);
		$this->jenispenggunaAction();
		$this->render('jenispengguna');	
	}
	public function simpanjenispenggunaeditAction(){
		$this->view;
		$id_jenis_pengguna = $this->_getParam('id_jenis_pengguna');
		$nama_jenis_pengguna = $_POST['nama_jenis_pengguna'];
		
		
		$data = array("id_jenis_pengguna" => $id_jenis_pengguna,
					"nama_jenis_pengguna" => $nama_jenis_pengguna);
									 
		$hasil = $this->pengguna->getsimpanjenispenggunaedit($data);
		
		$this->jenispenggunaAction();
		$this->render('jenispengguna');
		
	}
	//menu pengguna umum
	public function penggunaumumAction(){
		$id_surat = $this->_getParam("id_surat");
		$this->view->surat = $this->data_serv->getSurat($id_surat);
		
	}
	//menu Ketua
	public function homeketuaAction(){
		$id_kelurahan = $this->id_kelurahan;
		$id_jenis_pengguna = $this->id_jenis_pengguna;
		$this->view->surat = "Surat Keterangan Tidak Mampu untuk Rumah Sakit";
		
		$this->view->jenispengguna=$this->data_serv->getPilihJenisPengguna($id_jenis_pengguna);
		$this->view->kelurahan=$this->data_serv->getPilihKelurahan($id_kelurahan);
		
		$this->view->permintaan = $this->surat_serv->getPermintaanRumahSakit($this->id_kelurahan,0,30);
	}
	public function rumahsakitAction(){
		$id_kelurahan = $this->id_kelurahan;
		$id_jenis_pengguna = $this->id_jenis_pengguna;
		$this->view->surat = "Surat Keterangan Tidak Mampu untuk Rumah Sakit";
		$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
		$this->view->jenispengguna=$this->data_serv->getPilihJenisPengguna($id_jenis_pengguna);
		$this->view->kelurahan=$this->data_serv->getPilihKelurahan($id_kelurahan);
		
		$this->view->permintaan = $this->surat_serv->getPermintaanRumahSakit($this->id_kelurahan,0,30);
	}
	public function sekolahAction(){
		$id_kelurahan = $this->id_kelurahan;
		$id_jenis_pengguna = $this->id_jenis_pengguna;
		$this->view->surat = "Surat Keterangan Tidak Mampu untuk Sekolah";
		$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
		$this->view->jenispengguna=$this->data_serv->getPilihJenisPengguna($id_jenis_pengguna);
		$this->view->kelurahan=$this->data_serv->getPilihKelurahan($id_kelurahan);
		
		$this->view->permintaan = $this->surat_serv->getPermintaanSekolah($this->id_kelurahan,0,30);
	}
	public function andonnikahAction(){
		$id_kelurahan = $this->id_kelurahan;
		$id_jenis_pengguna = $this->id_jenis_pengguna;
		$this->view->surat = "Surat Andon Nikah";
		$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
		$this->view->jenispengguna=$this->data_serv->getPilihJenisPengguna($id_jenis_pengguna);
		$this->view->kelurahan=$this->data_serv->getPilihKelurahan($id_kelurahan);
		
		$this->view->permintaan = $this->surat_serv->getPermintaanAndonNikah($this->id_kelurahan,0,30);
	}
	public function belummenikahAction(){
		$id_kelurahan = $this->id_kelurahan;
		$id_jenis_pengguna = $this->id_jenis_pengguna;
		$this->view->surat = "Surat Keterangan Belum Menikah";
		$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
		$this->view->jenispengguna=$this->data_serv->getPilihJenisPengguna($id_jenis_pengguna);
		$this->view->kelurahan=$this->data_serv->getPilihKelurahan($id_kelurahan);
		
		$this->view->permintaan = $this->surat_serv->getPermintaanBelumMenikah($this->id_kelurahan,0,30);
	}
	public function bprAction(){
		$id_kelurahan = $this->id_kelurahan;
		$id_jenis_pengguna = $this->id_jenis_pengguna;
		$this->view->surat = "Surat Keterangan Belum Mempunyai Rumah";
		$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
		$this->view->jenispengguna=$this->data_serv->getPilihJenisPengguna($id_jenis_pengguna);
		$this->view->kelurahan=$this->data_serv->getPilihKelurahan($id_kelurahan);
		
		$this->view->permintaan = $this->surat_serv->getPermintaanbpr($this->id_kelurahan,0,30);
	}
	public function ibadahhajiAction(){
		$id_kelurahan = $this->id_kelurahan;
		$id_jenis_pengguna = $this->id_jenis_pengguna;
		$this->view->surat = "Surat Keterangan Menunaikan Ibadah Haji";
		$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
		$this->view->jenispengguna=$this->data_serv->getPilihJenisPengguna($id_jenis_pengguna);
		$this->view->kelurahan=$this->data_serv->getPilihKelurahan($id_kelurahan);
		
		$this->view->permintaan = $this->surat_serv->getPermintaanibadahhaji($this->id_kelurahan,0,30);
	}
	public function jandaAction(){
		$id_kelurahan = $this->id_kelurahan;
		$id_jenis_pengguna = $this->id_jenis_pengguna;
		$this->view->surat = "Surat Keterangan Berstatus Janda";
		$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
		$this->view->jenispengguna=$this->data_serv->getPilihJenisPengguna($id_jenis_pengguna);
		$this->view->kelurahan=$this->data_serv->getPilihKelurahan($id_kelurahan);
		
		$this->view->permintaan = $this->surat_serv->getPermintaanjanda($this->id_kelurahan,0,30);
	}
	public function ikAction(){
		$id_kelurahan = $this->id_kelurahan;
		$id_jenis_pengguna = $this->id_jenis_pengguna;
		$this->view->surat = "Surat Keterangan Ijin Keramain";
		$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
		$this->view->jenispengguna=$this->data_serv->getPilihJenisPengguna($id_jenis_pengguna);
		$this->view->kelurahan=$this->data_serv->getPilihKelurahan($id_kelurahan);
		
		$this->view->permintaan = $this->surat_serv->getPermintaanik($this->id_kelurahan,0,30);
	}
	public function psAction(){
		$id_kelurahan = $this->id_kelurahan;
		$id_jenis_pengguna = $this->id_jenis_pengguna;
		$this->view->surat = "Surat Pengantar SKCK";
		$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
		$this->view->jenispengguna=$this->data_serv->getPilihJenisPengguna($id_jenis_pengguna);
		$this->view->kelurahan=$this->data_serv->getPilihKelurahan($id_kelurahan);
		
		$this->view->permintaan = $this->surat_serv->getPermintaanps($this->id_kelurahan,0,30);
	}
	public function bdAction(){
		$id_kelurahan = $this->id_kelurahan;
		$id_jenis_pengguna = $this->id_jenis_pengguna;
		$this->view->surat = "Surat Keterangan Bersih Diri";
		$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
		$this->view->jenispengguna=$this->data_serv->getPilihJenisPengguna($id_jenis_pengguna);
		$this->view->kelurahan=$this->data_serv->getPilihKelurahan($id_kelurahan);
		
		$this->view->permintaan = $this->surat_serv->getPermintaanbd($this->id_kelurahan,0,30);
	}
	////////////////
	public function homeketuaaccAction(){
		$id_kelurahan = $this->id_kelurahan;
		$id_jenis_pengguna = $this->id_jenis_pengguna;
		$id_kelurahan;
		//echo "jahsdjhasd";
		//$this->view;
		$this->view->jenispengguna=$this->data_serv->getPilihJenisPengguna($id_jenis_pengguna);
		$this->view->kelurahan=$this->data_serv->getPilihKelurahan($id_kelurahan);
		
	}
	public function menubarketuaAction(){
		
	}
	public function sekolahacceditAction(){
			$id_permintaan = $this->_getParam('id_permintaan');
			$hasil = $this->data_serv->getaccsekolah($id_permintaan);
			$this->sekolahAction();
			$this->render('sekolah');
	}
	public function rumahsakitacceditAction(){
			$id_permintaan = $this->_getParam('id_permintaan');
			$hasil = $this->data_serv->getaccrumahsakit($id_permintaan);
			$this->rumahsakitAction();
			$this->render('rumahsakit');
	}
	public function psacceditAction(){
			$id_permintaan = $this->_getParam('id_permintaan');
			$hasil = $this->data_serv->getaccps($id_permintaan);
			$this->psAction();
			$this->render('ps');
	}
	public function jandaacceditAction(){
			$id_permintaan = $this->_getParam('id_permintaan');
			$hasil = $this->data_serv->getaccjanda($id_permintaan);
			$this->jandaAction();
			$this->render('janda');
	}
	public function ikacceditAction(){
			$id_permintaan = $this->_getParam('id_permintaan');
			$hasil = $this->data_serv->getaccik($id_permintaan);
			$this->ikAction();
			$this->render('ik');
	}
	public function ibadahhajiacceditAction(){
			$id_permintaan = $this->_getParam('id_permintaan');
			$hasil = $this->data_serv->getaccibadahhaji($id_permintaan);
			$this->ibadahhajiAction();
			$this->render('ibadahhaji');
	}
	public function bpracceditAction(){
			$id_permintaan = $this->_getParam('id_permintaan');
			$hasil = $this->data_serv->getaccbpr($id_permintaan);
			$this->bprAction();
			$this->render('bpr');
	}
	public function belummenikahacceditAction(){
			$id_permintaan = $this->_getParam('id_permintaan');
			$hasil = $this->data_serv->getaccbelummenikah($id_permintaan);
			$this->belummenikahAction();
			$this->render('belummenikah');
	}
	public function bdacceditAction(){
			$id_permintaan = $this->_getParam('id_permintaan');
			$hasil = $this->data_serv->getaccbd($id_permintaan);
			$this->bdAction();
			$this->render('bd');
	}
	public function andonnikahacceditAction(){
			$id_permintaan = $this->_getParam('id_permintaan');
			$hasil = $this->data_serv->getaccandonnikah($id_permintaan);
			$this->andonnikahAction();
			$this->render('andonnikah');
	}
	//////////////
	public function cabutacceditAction(){
	
	}
	//pejabat
	public function datapejabatAction(){
		$this->view;
		$this->view->pejabat = $this->data_serv->getDataPejabat();
	}
	public function pejabathapusAction(){
		$id_pejabat= $this->_getParam("id_pejabat");
		$hasil = $this->data_serv->gethapuspejabat($id_pejabat);
		
		$this->datapejabatAction();
		$this->render('datapejabat');
	}
	public function tambahpejabatAction(){
		$this->view;
		$this->view->kelurahan = $this->data_serv->getkelurahan();
		$this->view->jabatan = $this->data_serv->getJabatan();
	}
	public function simpanpejabatAction(){
		 $nip_pejabat = $_POST['nip_pejabat'];
		 $nama_pejabat = $_POST['nama_pejabat'];
		 $id_kelurahan = $_POST['id_kelurahan'];
		 $id_jenis_pengguna = $_POST['id_jenis_pengguna'];
		
		
		$data = array("nip_pejabat" => $nip_pejabat,
					"nama_pejabat" => $nama_pejabat,
					"id_kelurahan" => $id_kelurahan,
					"id_jenis_pengguna" => $id_jenis_pengguna);
									 
		$hasil = $this->pengguna->getsimpanpejabat($data);
		$this->datapejabatAction();
		$this->render('datapejabat');	
	}
	public function pejabateditAction(){
		
		$id_pejabat= $this->_getParam("id_pejabat");
		$this->view;
		$this->view->kelurahan = $this->data_serv->getkelurahan();
		$this->view->jabatan = $this->data_serv->getJabatan();
		$hasil= $this->data_serv->getPejabatId($id_pejabat);
		$this->view->hasil  = $hasil;
	}
	public function simpanpejabateditAction(){
		$id_pejabat= $this->_getParam("id_pejabat");
		 $nip_pejabat = $_POST['nip_pejabat'];
		 $nama_pejabat = $_POST['nama_pejabat'];
		 $id_kelurahan = $_POST['id_kelurahan'];
		 $id_jenis_pengguna = $_POST['id_jenis_pengguna'];
		
		
		$data = array("id_pejabat" => $id_pejabat,
					"nip_pejabat" => $nip_pejabat,
					"nama_pejabat" => $nama_pejabat,
					"id_kelurahan" => $id_kelurahan,
					"id_jenis_pengguna" => $id_jenis_pengguna);
									 
		$hasil = $this->pengguna->getsimpanpejabatedit($data);
		$this->datapejabatAction();
		$this->render('datapejabat');	
	}
	//surat
	public function datasuratAction(){
		$this->view;
		$this->view->surat = $this->data_serv->getDataSurat();
	}
	public function tambahsuratAction(){
		$this->view;
		$this->view->jenissurat = $this->data_serv->getJenisSurat();
	}
	 public function simpansuratAction(){
		$nama_surat = $_POST['nama_surat'];
		$id_jenis_surat = $_POST['id_jenis_surat'];
		
		$data = array("nama_surat" => $nama_surat,
					"id_jenis_surat" => $id_jenis_surat);
									 
		$hasil = $this->data_serv->getsimpansurat($data);
		$this->datasuratAction();
		$this->render('datasurat');	
	}
	public function surathapusAction(){
		$id_surat= $this->_getParam("id_surat");
		$hasil = $this->data_serv->gethapussurat($id_surat);
		
		$this->datasuratAction();
		$this->render('datasurat');
	}
	public function surateditAction(){
		$id_surat = $this->_getParam("id_surat");
		$this->view->jenissurat = $this->data_serv->getJenisSurat();
		$this->view->surat = $this->data_serv->getPilihSurat($id_surat);
	}
	public function simpansurateditAction(){
		$id_surat = $this->_getParam('id_surat');
		$nama_surat = $_POST['nama_surat'];
		$id_jenis_surat = $_POST['id_jenis_surat'];
		
		$data = array("id_surat" => $id_surat,
						"nama_surat" => $nama_surat,
					"id_jenis_surat" => $id_jenis_surat);
									 
		$hasil = $this->data_serv->getsimpansuratedit($data);
		$this->datasuratAction();
		$this->render('datasurat');	
	}
	//ekbang
public function domisiliyayasanAction(){
		$id_kelurahan = $this->id_kelurahan;
		$id_jenis_pengguna = $this->id_jenis_pengguna;
		$this->view->surat = "Surat Keterangan Domisili Yayasan";
		$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
		$this->view->jenispengguna=$this->data_serv->getPilihJenisPengguna($id_jenis_pengguna);
		$this->view->kelurahan=$this->data_serv->getPilihKelurahan($id_kelurahan);
		
		$this->view->permintaan = $this->surat_serv->getPermintaandomisiliyayasan($this->id_kelurahan,0,30);
	}
	public function domisiliperusahaanAction(){
		$id_kelurahan = $this->id_kelurahan;
		$id_jenis_pengguna = $this->id_jenis_pengguna;
		$this->view->surat = "Surat Keterangan Domisili Perusahaan";
		$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
		$this->view->jenispengguna=$this->data_serv->getPilihJenisPengguna($id_jenis_pengguna);
		$this->view->kelurahan=$this->data_serv->getPilihKelurahan($id_kelurahan);
		
		$this->view->permintaan = $this->surat_serv->getPermintaandomisiliperusahaan($this->id_kelurahan,0,30);
	}	
	public function domisiliparpolAction(){
		$id_kelurahan = $this->id_kelurahan;
		$id_jenis_pengguna = $this->id_jenis_pengguna;
		$this->view->surat = "Surat Keterangan Domisili Parpol";
		$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
		$this->view->jenispengguna=$this->data_serv->getPilihJenisPengguna($id_jenis_pengguna);
		$this->view->kelurahan=$this->data_serv->getPilihKelurahan($id_kelurahan);
		
		$this->view->permintaan = $this->surat_serv->getPermintaandomisiliparpol($this->id_kelurahan,0,30);
	}
	public function keterangantempatusahaAction(){
		$id_kelurahan = $this->id_kelurahan;
		$id_jenis_pengguna = $this->id_jenis_pengguna;
		$this->view->surat = "Surat Keterangan Tempat Usaha";
		$this->view->pengguna = $this->data_serv->getPilihPengguna($this->id_pengguna);
		$this->view->jenispengguna=$this->data_serv->getPilihJenisPengguna($id_jenis_pengguna);
		$this->view->kelurahan=$this->data_serv->getPilihKelurahan($id_kelurahan);
		
		$this->view->permintaan = $this->surat_serv->getPermintaanketerangantempatusaha($this->id_kelurahan,0,30);
	}
	public function domisiliyayasanacceditAction(){
			echo $id_permintaan = $this->_getParam('id_permintaan');
			$hasil = $this->data_serv->getaccdomisiliyayasan($id_permintaan);
			$this->domisiliyayasanAction();
			$this->render('domisiliyayasan');
	}
	public function domisiliparpolacceditAction(){
			$id_permintaan = $this->_getParam('id_permintaan');
			$hasil = $this->data_serv->getaccdomisiliparpol($id_permintaan);
			$this->domisiliparpolAction();
			$this->render('domisiliparpol');
	}
	public function domisiliperusahaanacceditAction(){
			$id_permintaan = $this->_getParam('id_permintaan');
			$hasil = $this->data_serv->getaccdomisiliperusahaan($id_permintaan);
			$this->domisiliperusahaanAction();
			$this->render('domisiliperusahaan');
	}
	public function keterangantempatusahaacceditAction(){
			$id_permintaan = $this->_getParam('id_permintaan');
			$hasil = $this->data_serv->getaccketerangantempatusaha($id_permintaan);
			$this->keterangantempatusahaAction();
			$this->render('keterangantempatusaha');
	}
}
?>