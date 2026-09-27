<?php
namespace App\Models;
class Category {
    public static function active(): array {
        return \db()->query("SELECT * FROM categories WHERE status='active' ORDER BY name")->fetchAll();
    }
}
