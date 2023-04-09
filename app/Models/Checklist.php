<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vlesson;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;


class Checklist extends Model implements Sortable
{
    use HasFactory, SortableTrait;

    public $table = 'checklists';

    protected $fillable = ['name','description','status','approved'];

    public function vlessons()
    {
        return $this->belongsTo(VLesson::class);
    }

    public function users() {
        return $this->belongsToMany(User::class, 'checklist_user')->withPivot('status', 'approved');
    }

    public function getVlessonURL($lesson_id) {

            $lesson = Vlesson::find($lesson_id);
            if($lesson) {
            return '/ovlesson/'.$lesson->permalink;
            } else {
                return '#';
            }

    }
    
}
