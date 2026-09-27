<?php
namespace App\Models;
class Order {
    public static function find(int $id): ?array {
        $st=\db()->prepare('SELECT * FROM orders WHERE id=?'); $st->execute([$id]); return $st->fetch() ?: null;
    }
}
