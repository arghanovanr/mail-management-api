<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maillog extends Model
{
    use HasFactory;
    protected $table = "maillogs";
    protected $fillable = ['sender', 'recipient', 'recipients_cc', 'recipients_bcc', 'content'];
}
