<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use League\CommonMark\CommonMarkConverter;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Answer extends Model
{
    use HasFactory;

    /**
     * Relation to Question model
     * 
     * @return
     */
    public function question() {
        return $this->belongsTo(Question::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function getBodyHtmlAttribute() {
		$markdown = new CommonMarkConverter(['allow_unsafe_links' => false]);
		return $markdown->convertToHtml($this->body);
    }
}
