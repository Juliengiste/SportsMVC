<?php
/*******************************
Version : 1.0.0.0
Revised : vlundi 10 novembre 2023, 10:23:58 (UTC+0200)
 *******************************/
namespace Core\Models;

use PDO;
use \Core\Models\Vacances;

class VacancesManager extends Manager {
	protected $table = "vacances";
	protected $pk = "idvacances";

public function deleteVacances($id) {
    $this->delete($id, $this->table); // Call the protected delete method from the parent class
	}
}