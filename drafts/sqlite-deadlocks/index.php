<?php

//phpinfo();
//exit;

use Laminas\Db\Sql\Ddl;
use Laminas\Db\Sql\Ddl\Column;
use Laminas\Db\Sql\Ddl\Constraint;
use Laminas\Db\Sql\Sql;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-Type: text/plain");
echo (new DateTime())->format("c");
echo "\r\n";

require './vendor/autoload.php';

$adapter = new Laminas\Db\Adapter\Adapter([
    'driver'   => 'Pdo_Sqlite',
    'database' => './sqlite.db',
]);

$createTable = function ($adapter) {
    $table = new Ddl\CreateTable('test_table');

    $column = new Column\Integer('id');
    $column->setOption('AUTO_INCREMENT', true);
    $table->addColumn($column);
    $table->addConstraint(new Constraint\PrimaryKey('id'));

    $table->addColumn(new Column\Varchar('name', 255));
    $table->addColumn(new Column\Varchar('process', 255));

    $sql = new Sql($adapter);
    $adapter->query(
        $sql->buildSqlString($table),
        $adapter::QUERY_MODE_EXECUTE
    );
};

$command = ($_GET['c'] ?? '');

if ($command == 'create') {
    $createTable($adapter);
    exit;
} elseif ($command == "select") {
    $sql = new Sql($adapter);

    $select = $sql->select();
    $select->from('test_table');
    $select->where->like("name", '%af%')->or->like("name", '%xs%');

    $statement = $sql->prepareStatementForSqlObject($select);
    $results = $statement->execute();

    foreach ($results as $result) {
        echo $result["name"];
    }
} else {
    $sql = new Sql($adapter);
    $process = ($_GET['p'] ?? uniqid());

    for ($i = 0; $i < 3000; $i++) {
        $insert = $sql->insert()
            ->into('test_table')
            ->values([
                "name" => md5(uniqid()) . md5(uniqid()) . md5(uniqid()) . md5(uniqid()) . md5(uniqid()) . md5(uniqid()) . md5(uniqid()) . md5(uniqid()),
                "process" => $process
            ]);

        $queryString = $sql->buildSqlString($insert);
        $adapter->query($queryString, $adapter::QUERY_MODE_EXECUTE);

        $update = $sql->update()
            ->table('test_table')
            ->set(["name" => md5(uniqid()) . md5(uniqid()) . md5(uniqid()) . md5(uniqid()) . md5(uniqid()) . md5(uniqid()) . md5(uniqid()) . md5(uniqid())]);

        $queryString = $sql->buildSqlString($update);
        $adapter->query($queryString, $adapter::QUERY_MODE_EXECUTE);

        $select = $sql->select();
        $select->from('test_table');
        $select->where(['id' => 2]);

        $statement = $sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();

        foreach ($results as $result) {
            echo $result["name"];
        }
    }
}

echo (new DateTime())->format("c");
echo "\r\n";
