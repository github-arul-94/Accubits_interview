<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Module;

use Illuminate\Support\Facades\DB;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index',['success'=>'']);
        
    }
    public function uploadFile(Request $request){

        if ($request->input('submit') != null ){
    
          $file = $request->file('file');
    
          $filename = $file->getClientOriginalName();
          $extension = $file->getClientOriginalExtension();
          $tempPath = $file->getRealPath();
          $fileSize = $file->getSize();
          $mimeType = $file->getMimeType();
    
          $valid_extension = array("csv");
    
          // 2MB in Bytes
          $maxFileSize = 2097152; 
    
          // Check file extension
          $errors = array();
          if(in_array(strtolower($extension),$valid_extension)){
    
                $location = 'public/uploads';
    
              $file->move($location,$filename);
    
              $filepath = public_path("/uploads/".$filename);
    
              // Reading file
              $file = fopen($filepath,"r");
    
              $importData_arr = array();
              $i = 0;
    
              while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                 $num = count($filedata );
                 for ($c=0; $c < $num; $c++) {
                    $importData_arr[$i][] = $filedata [$c];
                 }
                 $i++;
              }
              fclose($file);
              
              
              $code_error_array = array();
              $name_error_array = array();
              $term_error_array = array();
              $heading_error_array = array();
              
              $validation_flag  = 0;
              
              if($num < 3 OR $num >3){
                array_push($errors,'ERROR : Must be used 3 columns  in csv file');
                $validation_flag  = 1; 
              }
    
              foreach($importData_arr as $i=> $importData){
                if($i == 0){
                    if($importData[0] != 'Module Code'){
                        array_push($errors,'Header column (Module Code at 1st column) is incorrect in csv file'); 
                        $validation_flag  = 1; 
                    }
                    if($importData[1] != 'Module Name'){
                        array_push($errors,'Header column (Module Name at 2nd column) is incorrect in csv file'); 
                        $validation_flag  = 1; 
                    }
                    if($importData[2] != 'Module Term'){
                        array_push($errors,'Header column (Module term at 3rd column) is incorrect in csv file'); 
                        $validation_flag  = 1; 
                    }
                }
                else{
                    if($importData[0] == ''){
                        array_push($code_error_array,$i);
                        $validation_flag  = 1;
                    }
                    if($importData[1] == ''){
                        array_push($name_error_array,$i);
                        $validation_flag  = 1;
                    }
                    if($importData[2] == ''){
                        array_push($term_error_array,$i);
                        $validation_flag  = 1;
                    }
                }
              }
              if($validation_flag == 1){
                if(count($code_error_array) >0){
                    $error_list1 = implode(', ', $code_error_array);
                    $str1 = 'Module Code contains symbols at row '.$error_list1;
                    array_push($errors,$str1); 
                }
                if(count($name_error_array) >0){
                    $error_list2 = implode(', ', $name_error_array);
                    $str2 = 'Module Name contains symbols at row '.$error_list2;
                    array_push($errors,$str2); 
                }
                if(count($code_error_array) >0){
                    $error_list3 = implode(', ', $code_error_array);
                    $str3 = 'Module Term contains symbols at row '.$error_list3;
                    array_push($errors,$str3); 
                }
                return view('index',['errors'=>$errors,'success'=>'']);
              }
              else{
                foreach($importData_arr as $importData){
                    $modules = new Module([
                        "module_code"=>$importData[0],
                       "module_name"=>$importData[1],
                       "module_term"=>$importData[2]
                    ]);
                    $modules->save();
                }
                return view('index',['success'=>'Uploaded Successfully']);
                //return redirect('/')->with('success','Uploaded Successfully!');
              }
          }else{
             array_push($errors,'ERROR : Invalid File Extension.');
             return view('index',['errors'=>$errors,'success'=>'']);
          }
    
        }
        else{
            return redirect('/');
        }
        
  }

    
}
