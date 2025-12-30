<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PopularPlace extends Model
{
    use HasFactory;

    protected $table = 'popular_places';

    protected $fillable = [
        'name',
        'status',
        'image_url',
        'image_path',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'image_path',
    ];

    public static function rules($id = null)
    {
        $rules = [
            'user_id'     => 'nullable|exists:users,id',
            'name' => 'required|string|unique:popular_places,name,' . $id,
            'status'      => 'required|in:Active,Inactive',
        ];

        if (is_null($id)) {
            // Rule for create (if $id is null)
            $rules['image'] = 'required|image|mimes:jpg,jpeg,png|max:5120';
        } else {
            // Rule for update (if $id is not null)
            $rules['image'] = 'nullable|image|mimes:jpg,jpeg,png|max:5120';
        }

        return $rules;
    }
    public function hotel(): HasOne
    {
        return $this->hasOne(Hotel::class, 'popular_place_id', 'id');
    }
}
