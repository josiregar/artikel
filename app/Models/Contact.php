<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mail;
use App\Mail\ContactMail;

class Contact extends Model
{
    use HasFactory;

    public $fillable = ['name', 'email', 'subject', 'keterangan'];
    
    public static function boot() {
        
        parent::boot();

        static::created (function ($item) {

            $adminEmail = "josadisiregar200109@gmail.com";
            Mail::to($adminEmail)->send(new ContactMail($item));

        });
    }
}
