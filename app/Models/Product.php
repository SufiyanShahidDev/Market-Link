<?php
namespace App\Models;
class Product {
    public static function find(int $id): ?array {
        $st = \db()->prepare('SELECT * FROM products WHERE id=?');
        $st->execute([$id]);
        return $st->fetch() ?: null;
    }
    public static function delete(int $id, ?int $farmerId = null): bool {
        $sql = 'DELETE FROM products WHERE id=?'; $p=[$id];
        if ($farmerId !== null) { $sql .= ' AND farmer_id=?'; $p[]=$farmerId; }
        return \db()->prepare($sql)->execute($p);
    }
}
