<?php

namespace App\Models;



use App\Models\Answer;
use App\Models\Categorie;
use App\Models\Difficultys;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;


    protected $fillable = ['categorie_id', 'question_text', 'difficultie_id', 'time_limit'];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }
    public function answers()
    {
        return $this->hasMany(Answer::class, 'question_id');
    }
    public function difficulty()
    {
        return $this->belongsTo(Difficulty::class, 'difficultie_id');
    }
}
