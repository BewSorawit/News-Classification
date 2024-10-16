<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Work extends Model
{
    use HasFactory;





    public static function createWork($id)
    {
        
        DB::insert('INSERT INTO workfinder ( userID) VALUES (?)',[$id]);
        $results = DB::table('workfinder')->where( 'userID' , $id)->first();
        DB::insert('INSERT INTO workcontact (workfinderID) VALUES (?);',[$results->workfinderID]);
        DB::insert('INSERT INTO workaddress (workfinderID) VALUES (?)',[$results->workfinderID]);
        
    }

    public static function getAll(){
        return DB::table('workfinder')->get();
    }
    public static function findWorkByWorkId($id)
    {
        return DB::table('workfinder')->where( 'workfinderID' , $id)->first();

    }
    public static function findUserByworkID($id)
    {
        return DB::table('users')->where( 'id' , $id)->first();

    }
    public static function findWorkById($id)
    {
        return DB::table('workfinder')->where( 'userID' , $id)->first();

    }
    public static function findAddressById($id)
    {
        return DB::table('workaddress')->where( 'workfinderID' , $id)->first();

    }
    public static function findContactById($id)
    {
        return DB::table('workcontact')->where( 'workfinderID' , $id)->first();

    }
    
    public static function updateWork($id,$data)  {
        $w =  DB::table('workfinder')->where( 'userID' , $id)->first();
        $a =  DB::table('workaddress')->where( 'workfinderID' , $w->workfinderID)->first();
        $c =  DB::table('workcontact')->where( 'workfinderID' , $w->workfinderID)->first();


        DB::table('workfinder')->where( 'userID' , $id)->update([
            'firstname'=> $data->firstname,
            'surname'=> $data->surname,
            'sex'=> $data->sex,
            'nation'=> $data->nation,
            'religion'=> $data->religion,
            'phone'=> $data->phone,
            'birthdate' => $data->birthdate,
            'workType' => $data->workType,

        ]);
        
        DB::table('workcontact')->where( 'workfinderID' , $w->workfinderID)->update([
            'position' => $data->position,
            'line' => $data->line,

        ]);

        DB::table('workaddress')->where( 'workfinderID' , $w->workfinderID)->update([
            'province' => $data->province,
            'addressDetails' => $data->addressDetails,
            'postcode' => $data->postcode,
        
        ]);
        
    }
    public static function uploadProfile($id,$data){
        DB::table('users')->where('id',$id)->update([
            'namePicture'=> $data,
        ]);
    }

    public static function uploadResume($id,$data){
        DB::table('workfinder')->where('workfinderID',$id)->update([
            'nameResume'=> $data,
        ]);
    }

    public static function searchUser($workType,$province,$position){
        
        $users = DB::table('workaddress')
        ->leftjoin( 'workcontact', 'workaddress.workfinderID', '=', 'workcontact.workfinderID')
        ->leftjoin('workfinder', 'workaddress.workfinderID', '=', 'workfinder.workfinderID')
        ->select('workfinder.*', 'workcontact.position', 'workaddress.province')
        ->where('workfinder.workType',$workType)
        ->where('workaddress.province',($province != '')? '=':'like',($province != '')? $province:'%%')
        ->where('workcontact.position','like','%'.$position.'%')
        ->get();

        return $users;

    }

}

