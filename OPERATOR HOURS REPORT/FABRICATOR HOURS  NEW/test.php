<?php
// tests/SQLProductionTableTest.php
use PHPUnit\Framework\TestCase;
 include './SQL_production_table.php';

class SQLProductionTableTest extends TestCase
{
    protected $conn;

    protected function setUp(): void
    {
        // Initialize the PDO connection here
        $dsn = 'mysql:host=KPTSVSP;dbname=KENTSTAINLESS';
        $username = 'sa';
        $password = 'SAPB1Admin';
        $this->conn = new PDO("sqlsrv:Server=KPTSVSP;Database=KENTSTAINLESS","sa","SAPB1Admin");
    }

    public function testFetchOperatorHoursPivotData()
    {
        global $sql_operator_hours_pivot;
        $getResults = $this->conn->prepare($sql_operator_hours_pivot);
        $getResults->execute();
        $operator_hours_pivot_data = $getResults->fetchAll(PDO::FETCH_BOTH);

        $this->assertIsArray($operator_hours_pivot_data);
        $this->assertNotEmpty($operator_hours_pivot_data);
    }

    public function testFetchOperatorEntriesData()
    {
        global $sql_operator_entries;
        $getResults = $this->conn->prepare($sql_operator_entries);
        $getResults->execute();
        $operator_entries_data = $getResults->fetchAll(PDO::FETCH_BOTH);

        $this->assertIsArray($operator_entries_data);
        $this->assertNotEmpty($operator_entries_data);
    }
}
