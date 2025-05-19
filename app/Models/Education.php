<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;
    protected $table = 'education';
    protected $fillable = [
        'passing_year',
        'result',
        'user_id',
        'education_level',
        'major_subject',
        'degree_title',
        'person_id',
        'education_institute',
        'education_board_universities',
        ];
    public function education_levels()
    {
        return $this->hasMany(EducationLevel::class);
    }
    public function education_board_universities()
    {
        return $this->hasMany(EducationBoardUniversity::class);
    }
    public function education_institutes()
    {
        return $this->hasMany(EducationInstitute::class);
    }
}
