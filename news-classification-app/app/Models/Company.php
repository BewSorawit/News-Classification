<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Company extends Model
{
    use HasFactory;

    // กำหนดชื่อของตารางหากชื่อไม่เป็นพหูพจน์ของ Model
    protected $table = 'company';

    // กำหนด primary key
    protected $primaryKey = 'compID';

    // กำหนดว่าตารางไม่มี timestamps
    public $timestamps = false;

    // กำหนด fillable fields
    protected $fillable = [
        'compName',
        'provinceID',
        'districtID',
        'subdistrictID',
        'companyTypeID',
        'compDescription',
        'compModel',
        'compAddress',
        'compPhone',
        'compEmail',
        'compWebsite',
        'compContactName',
        'compContactPosition',
        'userID',
    ];

    // ความสัมพันธ์กับตารางอื่น ๆ

    public function companyType()
    {
        return $this->belongsTo(CompanyType::class, 'companyTypeID');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'provinceID');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'districtID');
    }

    public function subdistrict()
    {
        return $this->belongsTo(Subdistrict::class, 'subdistrictID');
    }


    public static function createComp($id)
    {
        
        DB::insert('INSERT INTO company ( userID) VALUES (?)',[$id]);
        
    }
    public static function findByUserId($id)
    {
        
        return DB::table('company')->where('userID',$id)->first();
        
    }



}
