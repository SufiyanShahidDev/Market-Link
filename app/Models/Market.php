<?php
namespace App\Models;
class Market {
    public static function active(): array {
        return \db()->query("SELECT * FROM markets WHERE status='active' ORDER BY name")->fetchAll();
    }
}
