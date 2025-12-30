<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Validation\Rule;

class Package extends Model
{
    use HasFactory;

    protected $table = 'packages';

    protected $fillable = [
        'name',
        'duration',
        'price',
        'status',
    ];

    public static function rules($id = null)
    {
        $rules = [
            'name' => ['required', 'string', 'max:45', 'unique:packages,name,' . $id],
            'duration' => 'required|string|max:191|in:monthly',
            'price' => 'required|numeric|min:1',
            'status' => 'required|in:Active,Inactive',
        ];

        return $rules;
    }
    public function hotels(): HasOne
    {
        return $this->hasOne(Hotel::class);
    }
}
