<?php
/**
 * Created by PhpStorm.
 * User: Mohamed Hosny
 * Date: 4/2/2019
 * Time: 12:36 AM
 * @property GoodDB Instance
 */


class GoodDB
{
	public static $Instance = NULL;

	protected $conn;

	/* QueryBuilder constants */
	const QUERY_SELECT = "SELECT";
	const QUERY_WHERE = "WHERE";
	const QUERY_FROM = "FROM";
	const QUERY_JOIN = "JOIN";
	const QUERY_DELETE = "DELETE";
	const QUERY_ORDER = "ORDER BY";
	const QUERY_LIMIT = "LIMIT";
	const QUERY_UPDATE = "UPDATE";

	/* QueryBuilder */
	protected $queryString;
	protected $queryResult;
	protected $queryRules;
	protected $queryParams;


	public static function getInstance()
	{
		return self::$Instance;
	}

	public function __construct($dbCfg)
	{
		if (self::$Instance == NULL)
			self::$Instance = $this;

		$options = [
			PDO::ATTR_ERRMODE      => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_CASE         => PDO::CASE_NATURAL,
			PDO::ATTR_ORACLE_NULLS => PDO::NULL_EMPTY_STRING
		];
		$this->conn = new PDO("mysql:server=$dbCfg[host];dbname=$dbCfg[database]",
		                      $dbCfg['user'], $dbCfg['pass'],
		                      $options);
	}


	public function query($string, $params = [])
	{
		if (!$this->conn) return;
		$q = $this->conn->prepare($string);
		$q->execute($params);
		return $q;
	}

	public function select($select)
	{
		$this->queryRules[GoodDB::QUERY_SELECT] = $select;
		return $this;
	}

	public function from($from)
	{
		$this->queryRules[GoodDB::QUERY_FROM] = $from;
		return $this;
	}

	public function where($where = [])
	{
		if (!is_array($where)) return $this;

		$whereClause = "";
		foreach ($where as $key => $val)
			$whereClause .= "$key='$val' and ";

		$whereClause = substr($whereClause, 0, strlen($whereClause) - 4);

		if (!array_key_exists(GoodDB::QUERY_WHERE, $this->queryRules))
			$this->queryRules[GoodDB::QUERY_WHERE] = "";
		// key exists add comma before wtf
		$whereClause = !empty($this->queryRules[GoodDB::QUERY_WHERE]) ? ", " . $whereClause : $whereClause; // xD
		$this->queryRules[GoodDB::QUERY_WHERE] .= $whereClause;

		return $this;
	}

	public function join($op, $table1, $table2, $column1, $column2)
	{
		$op = ucwords($op);
		$joinStatement = "$op JOIN $table1 ON $table1.$column1=$table2.$column2 ";
		$this->queryRules[GoodDB::QUERY_JOIN] .= $joinStatement;
		return $this;
	}

	public function order_by($column, $order)
	{
		$order = ucwords($order);
		$statement = "$column $order";
		$this->queryRules[GoodDB::QUERY_ORDER] = $statement;
		return $this;
	}

	public function limit($limit, $offset = 0)
	{
		$statement = "$offset, $limit";
		$this->queryRules[GoodDB::QUERY_LIMIT] = $statement;
		return $this;
	}

	public function insert($table, $vals)
	{
		$insertStatement = "INSERT INTO $table (" . implode(",", array_keys($vals)) . ") ";
		$insertStatement .= "VALUES (";

		for ($i = 0; $i < count($vals); ++$i)
			$insertStatement .= "?,";

		$insertStatement = substr($insertStatement, 0, strlen($insertStatement) - 1);
		$insertStatement .= ")";

		$query = $this->query($insertStatement, array_values($vals));
		$this->ClearQuery();
		return $query;
	}

	public function delete($table, $id)
	{
		return $this->query("DELETE FROM $table where id = ?", [ $id ]);
	}

	public function update($table, $vals)
	{
		$updateStatement = "$table SET ";

		for ($i = 0; $i < count($vals); ++$i)
			$updateStatement .= array_keys($vals)[$i] . "=?,";

		$updateStatement = substr($updateStatement, 0, strlen($updateStatement) - 1);

		$this->queryRules[GoodDB::QUERY_UPDATE] = $updateStatement;

		$this->queryParams = array_values($vals);

		return $this;
	}


	public function build()
	{
		$queryString = "";
		foreach ($this->queryRules as $key => $val)
			$queryString .= "$key $val" . PHP_EOL;

		$this->queryString = $queryString;

		//echo $this->queryString . PHP_EOL;
		return $this;
	}

	public function execute()
	{
		$this->queryResult = $this->query($this->queryString, $this->queryParams);
		$this->ClearQuery();
		return $this->queryResult;
	}

	public function result()
	{
		// forgot to implement pdo statements(?)
		$this->queryResult = $this->query($this->queryString, []);
		$this->ClearQuery();
		return $this->queryResult->fetchAll(PDO::FETCH_ASSOC);
	}

	private function ClearQuery()
	{
		$this->queryString = "";
		$this->queryParams = NULL;
		$this->queryRules = [];
	}

}