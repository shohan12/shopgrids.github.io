<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
 

    use HasFactory;
    private static $category;
    private static $image;
    private static $imageName;
    private static $imageUrl;
    private static $directory;

    public static function getImageurl($request){
        self::$image = $request->file('image');
        self::$imageName=self::$image->getClientOriginalName();
        self::$directory='category-images/';
        self::$image->move(self::$directory,  self::$imageName);
        self::$imageUrl=self::$directory.self::$imageName;
        return self::$imageUrl;

    }

    public static function newCategory($request){
      self::$category = new Category();
      self::$category->name=$request->name;
      self::$category->description=$request->description;
      self::$category->image=self::getImageurl($request);
      self::$category->save();

    }

 public static function updateCategory($request, $id){
      self::$category=Category::find($id);
      if($request->file('image')){
        if(file_exists(self::$category->image)){
            unlink(self::$category->image);
        }
        self::$imageUrl=self::getImageurl($request);
      }
      else{
        self::$imageUrl = self::$category->image;
      }
     self::$category->name=$request->name;
     self::$category->description=$request->description;
     self::$category->image=self::$imageUrl;
     self::$category->save(); 

 }
 


 public function subCategories(){
  return $this->hasMany('App\Models\subcategory');
}


}
