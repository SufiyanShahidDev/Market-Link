<?php
namespace App\Models;
class User {
    public static function find(int $id): ?array {
        $st=\db()->prepare('SELECT * FROM users WHERE id=?'); $st->execute([$id]); return $st->fetch() ?: null;
    }
}
