<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class FileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function create(Request $request){
      if ($request->hasFile('data')) {
        $file = $request->file('data');
        $filename = $file->getClientOriginalName(); // this will be store in database to check against a checksummed file.
        $find_file = DB::table('files')->where('filename', '=', $filename)->first();
        $file_checksum = md5_file($file); // checksum of the file
        $data = Storage::disk('local')->exists($file_checksum); // check if the there are identical checksummed files
        if ($data || $find_file){
          return response()->json(['status' => 'file exists']);
        } else {
          DB::table('files')->insert([
            ['hashed_filename' => $file_checksum, 'filename' => $filename ]
          ]);
          Storage::disk('local')->put($file_checksum, File::get($file));
          return response()->json(['status' => 'success']);
        }
      }
    }

    public function delete(Request $request){
      $filename = $request->filename;
      $find_file = DB::table('files')->where('filename', '=', $filename)->first();
      if (!empty($find_file)){
        $hashed_filename = $find_file->hashed_filename;
        $exists = Storage::disk('local')->exists($hashed_filename);
        if ($exists){
          Storage::disk('local')->delete($hashed_filename);
          DB::table('files')->where('filename', '=', $filename)->delete();
          return response()->json(['status' => 'successfully deleted file']);
        }
      } else {
          return response()->json(['status' => 'file not found']);
      }
    }

    public function show(Request $request){
      $filename = $request->filename;
      $find_file = DB::table('files')->where('filename', '=', $filename)->first();
      if(!empty($find_file)){
        $hashed_filename = $find_file->hashed_filename;
        $exists = Storage::disk('local')->exists($hashed_filename);
        if ($exists){
          $file = Storage::disk('local')->getDriver()->getAdapter()->applyPathPrefix($hashed_filename);
          $headers = array(
            'Content-Type' => ['*/*']
          );
          return response()->download($file, $filename, $headers);
        } 
      } else {
         return response()->json(['status' => 'file not found']);
      }
    }
}
