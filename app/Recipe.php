<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\RecipeIngredient;
use App\RecipeDirection;
class Recipe extends Model
{
    protected $fillable = [
      'name', 'description', 'image'
    ];

    public function user() {
      return $this->belongsTo('App\User');
    }

    public function ingredients() {
      return $this->hasMany('App\RecipeIngredient');
    }
    public function directions() {
      return $this->hasMany('App\RecipeDirection');
    }

    public static function form() {
      return [
        'name' => '',
        'description' => '',
        'image' => '',
        'ingredirents' => [
          RecipeIngredient::form()
        ],

        'directions' => [
          RecipeDirection::form(),
          RecipeDirection::form()
        ]
      ];
    }
}
