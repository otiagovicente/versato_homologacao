<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\ImportCustomer;

class ImportCustomer extends Model
{
   public $fillable = ['code', 'name', 'fantasyName', 'document', 'email', 'phone'];
}