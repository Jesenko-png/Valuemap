<?php

declare(strict_types=1);

if ($argc < 3) {
    fwrite(STDERR, "Usage: php scripts/export-sqlite-to-mysql.php input.sqlite output.sql\n");
    exit(1);
}

$pdo = new PDO('sqlite:'.$argv[1]);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$quote = static fn (string $value): string => '`'.str_replace('`', '``', $value).'`';
$literal = static function (mixed $value): string {
    if ($value === null) return 'NULL';
    if (is_bool($value) || is_int($value)) return (string) (int) $value;
    return "'".str_replace(["\\", "'", "\r", "\n"], ["\\\\", "\\'", '\\r', '\\n'], (string) $value)."'";
};

$output = "-- ValueMap SQLite to MySQL export\nSET FOREIGN_KEY_CHECKS=0;\n\n";
$tables = $pdo->query("SELECT name, sql FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%' ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);

foreach ($tables as $table) {
    $name = $table['name'];
    $definition = preg_replace('/\binteger primary key autoincrement\b/i', 'BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY', $table['sql']);
    $definition = preg_replace('/\bboolean\b/i', 'TINYINT(1)', $definition);
    $definition = preg_replace('/\bdatetime\b/i', 'DATETIME', $definition);
    $definition = preg_replace('/\btext\b/i', 'LONGTEXT', $definition);
    $definition = preg_replace('/\bvarchar\b/i', 'VARCHAR', $definition);
    $definition = str_replace('"', '`', $definition);
    $definition = preg_replace('/^CREATE TABLE\s+([^\s(]+)/i', 'CREATE TABLE IF NOT EXISTS '.$quote($name), $definition);
    $output .= $definition." ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;\n\n";

    $columns = $pdo->query('PRAGMA table_info('.$quote($name).')')->fetchAll(PDO::FETCH_ASSOC);
    $columnNames = array_map(fn (array $column): string => $quote($column['name']), $columns);
    $rows = $pdo->query('SELECT * FROM '.$quote($name))->fetchAll(PDO::FETCH_ASSOC);
    foreach (array_chunk($rows, 100) as $chunk) {
        $values = array_map(fn (array $row): string => '('.implode(',', array_map($literal, array_values($row))).')', $chunk);
        $output .= 'INSERT INTO '.$quote($name).' ('.implode(',', $columnNames).') VALUES '.implode(',', $values).';\n';
    }
    $output .= "\n";
}

$output .= "SET FOREIGN_KEY_CHECKS=1;\n";
file_put_contents($argv[2], $output);
