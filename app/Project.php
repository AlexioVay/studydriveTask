<?php
namespace App;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Project {

    public function index() {
        $weekday = true;
        if ($this->isWeekend(Carbon::now()))
            $weekday = false;

        // Override manual user selection:
        if (isset($_GET['weekend']) && $_GET['weekend'] == 1)
            $weekday = false;
        else if (isset($_GET['weekday']) && $_GET['weekday'] == 1)
            $weekday = true;

        return $weekday;
    }


    public function initialize() {
        // Check if "photos" table already has entries. Skip this process if true.
        $results = DB::table('photos')->limit(1)->get();
        $count = count($results);

        if ($count < 1) {
            // Table "photos" is empty, get JSON file and fill table with it:
            $source = 'http://jsonplaceholder.typicode.com/photos';
            $sourceData = file_get_contents($source);
            $response = json_decode($sourceData);

            $save = null;
            $i = 1;
            foreach ($response as $photo) {
                $save[$i]['title'] = $photo->title;
                $save[$i]['url'] = $photo->thumbnailUrl;
                $save[$i]['created_at'] = Carbon::now();
                $i++;
            }
            // Fill table "photos":
            DB::table('photos')->insert($save);
        }
    }

    private function isWeekend($date) {
        return (date('N', strtotime($date)) >= 6);
    }



}