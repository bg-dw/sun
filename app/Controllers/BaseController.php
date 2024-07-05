<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */

class BaseController extends Controller
{

	//cek session
	public function is_session_available()
	{
		if (session()->get('passed') != true):
			session()->setFlashdata('warning', 'Silahkan Login!');
			header('Location: ' . base_url() . '/' . bin2hex('login'));
			exit();
		endif;
	}
	public function isSunday($date)
	{
		return (date('N', strtotime($date)) > 6);
	}

	protected $encryption_iv;
	public function enc($str)
	{
		//$str digunakan sebagai string yang akan di encrypt dan sekaligus kunci encrypt
		$ciphering = "AES-128-CTR";

		// Use OpenSSl Encryption method
		$options = 0;
		$key = "Budi";

		// Non-NULL Initialization Vector for encryption
		$this->encryption_iv = '1234567891011121';

		// Use openssl_encrypt() function to encrypt the data
		$encryption = openssl_encrypt(
			$str, //data
			$ciphering,
			$key, //key
			$options,
			$this->encryption_iv
		);

		return $encryption; //return value enc
	}

	public function gen_code()
	{
		//mac addr
		$x = exec('getmac');
		$str = explode(' ', $x);
		$data['in_key'] = $this->enc($str[0]);
		$data['unc'] = $this->enc($str[0] . ".BUDI-UTOMO");

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://raw.githubusercontent.com/bg-dw/key/master/activation_code.json');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch);

		$rec = json_decode($result, true);

		$cek = false;
		$unc = "";
		for ($i = 0; $i < count($rec); $i++) {
			if ($rec[$i]['unc'] === $data['unc']) {
				$unc = $rec[$i]['unc'];
				$cek = true;
			}
		}
		$res["cek"] = $cek;
		$res["unc"] = $unc;

		return $res;
		// return $data;
	}

	public function dir_is_empty()
	{
		$dir = realpath($_SERVER["DOCUMENT_ROOT"]) . '\sun\app\Code';
		$handle = opendir($dir);
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				closedir($handle);
				return false;
			}
		}
		closedir($handle);
		return true;
	}

	public function itr()
	{
		$x = exec('getmac');
		$str = explode(' ', $x);
		$data['key'] = $str[0];
		$auth = $this->enc($str[0]);
		if ($this->dir_is_empty() == 1) {
			return false;
		} else {
			$dir = realpath($_SERVER["DOCUMENT_ROOT"]) . '\sun\app\Code';
			$temp_file = $dir . "\key.txt";
			$cek_file = file_exists($temp_file);
			if ($cek_file) {
				$file = file_get_contents($temp_file, FILE_USE_INCLUDE_PATH);
				$tfile = $this->dec($file);
				$mc = explode('.', $tfile);
				if ($this->enc($mc[0]) === $auth) {
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}
	}

	public function dec($enc_str)
	{
		$ciphering = "AES-128-CTR";
		$options = 0;
		$key = "Budi";
		$this->encryption_iv = '1234567891011121';

		$decryption = openssl_decrypt(
			$enc_str,
			$ciphering,
			$key,
			$options,
			$this->encryption_iv
		);
		return $decryption; //return value dec
	}
	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = ['url'];

	/**
	 * Constructor.
	 *
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param LoggerInterface   $logger
	 */
	protected $validation, $session, $encrypter;
	// protected $session;
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);
		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.: $this->session = \Config\Services::session();
		$this->encrypter = \Config\Services::encrypter();
		$this->session = \Config\Services::session();
		$this->validation = \Config\Services::validation();

	}
}