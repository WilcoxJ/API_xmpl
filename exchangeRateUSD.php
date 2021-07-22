<?php
class ExchangeRateUSD{

	private $conn;
	private $table_name = "exchange_rate_USD";

	public $currency;
	public $rate;

	public function __construct($db) {
		$database = new Database();
		$db = $database->getConnection();
		$this->conn = $db;
	}

	function read() {
		$query = "SELECT id, date_updated, uts_updated, currency, rate
					FROM " . $this->table_name . " ORDER BY id";
		$stmt = sqlsrv_query($this->conn, $query);
		return $stmt;
	}

	function create() {
		$query = "INSERT INTO " . $this->table_name . "([date_updated],[uts_updated],[currency],[rate]) 
					VALUES (CONVERT(char(10), GetDate(),126), DATEDIFF(SECOND,'1970-01-01', GETUTCDATE()), ?, ?)";
		
		$params = array($this->currency, $this->rate);
		$stmt = sqlsrv_query($this->conn, $query, $params);

		if($stmt) {
			return true;
		}

		return false;
		
	}

	function readOne() {
		$database = new Database();
		$db = $database->getConnection();

		$query = "SELECT TOP 1 id, date_updated, uts_updated, currency, rate
				FROM " . $this->table_name . " WHERE id = ?";

		$params = array($this->id);
		$stmt = sqlsrv_query($db, $query, $params);
		$row = sqlsrv_fetch_array($stmt);

		$this->id = $row['id'];
		$this->currency = $row['currency'];
		$this->rate = $row['rate'];

		return $stmt;

	}

	function update() {
		$query = "UPDATE" . $this->table_name . 
				"SET currency = :currency, rate = :rate WHERE id = :id";

		$stmt = $this->conn->prepare($query);

		$this->currency=htmlspecialchars(strip_tags($this->currency));
		$this->rate=htmlspecialchars(strip_tags($this->rate));
		$this->id=htmlspecialchars(strip_tags($this->id));

		$stmt->bindParam(':currency', $this->currency);
		$stmt->bindParam(':rate', $this->rate);
		$stmt->bindParam(':id', $this->id);

		if($stmt->execute()) {
			return true;
		}

		return false;
	}

	public function count() {
		$database = new Database();
		$db = $database->getConnection();
		$query = "SELECT COUNT(*) as 'total_rows' FROM " . $this->table_name . "";

		$stmt = sqlsrv_query($db, $query);
		$row = sqlsrv_fetch_array($stmt);

		return $row['total_rows'];
		
	}

}
?>
