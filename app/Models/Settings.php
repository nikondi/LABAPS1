<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    public static function set(string $name, string $value): void
    {
        static::updateOrCreate(compact('name'), compact('value'));
    }
    public static function getValue(string $name) {
        return ($inst = static::where('name', $name)->first())?$inst->value:null;
    }
    public static function getAll() {
        $res = [];
        foreach(static::all() as $item)
            $res[$item->name] = $item->value;
        return $res;
    }
    protected $fillable = [
        'name', 'value'
    ];
}
