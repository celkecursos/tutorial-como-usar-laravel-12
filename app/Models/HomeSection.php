<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSection extends Model
{

    // Indicar o nome da tabela
    protected $table = 'home_sections';

    // Indicar quais colunas podem ser manipuladas
    protected $fillable = [
        'main_title',            // Título principal
        'main_description',        // Descrição principal
        'feature_one_title',
        'feature_one_description',
        'feature_two_title',
        'feature_two_description',
        'feature_three_title',
        'feature_three_description',
    ];
}
