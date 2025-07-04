<?php if ( ! defined('BASEPATH')) exit('No se permite el acceso directo al script');

class Tokens{

	Public function deftoken($id){
		$data = array();

		switch ($id) {
			case '1':
    			$data['ruta'] = "https://api.pse.pe/api/v1/fdab1bd14b6849f48a13cfed192d92d4290b07db68da4734bb82630d761ec831";
    			$data['token'] = "eyJhbGciOiJIUzI1NiJ9.IjAyODVjNTg4Yjg1YTRmMTRiNWQ2NmQ5OGYxYjRkNDQ5ZjM3NDVkN2VhMmI2NDZkYTkwMTNiM2UyYjAyODA1NTMi.Ikn2rndbBxcOjEldgPNd5CtFmoK1XS1WHVXcK50Rk7Q";
    			break;
			default:
				$data['ruta'] = "";
    			$data['token'] = "";
				break;
		}
		
		return $data;
	}
}
?>