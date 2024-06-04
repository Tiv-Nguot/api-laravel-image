<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $fillable = ['name','image'];

    public static function list(){
        return self::all();
    }

    public static function store($request, $id = null){
        $data = $request->only('name');
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $data['image'] = $imageName;
        }
    
        $data = self::updateOrCreate(['id' => $id], $data);
        return $data;
    }
}
