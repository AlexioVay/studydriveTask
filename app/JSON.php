<?php

namespace App;

use Illuminate\Support\Facades\DB;

class JSON {

    public function output() {
        if (isset($_GET['weekday']) && $_GET['weekday'] == 1)
            $data = $this->weekday();
        else
            $data = $this->weekend();

        $output = $data['data'];
        $output += ['totalPages' => $data['totalPages']];

        return $output;
    }

    private function getResults($weekday, $entriesPerPage) {
        $offset = 0;
        if (isset($_GET['page']) && $_GET['page'] > 1) {
            $offset = $_GET['page'] * $entriesPerPage - $entriesPerPage;
        }
        if ($weekday) {
            $results = DB::table('photos')
            ->select(DB::raw('SQL_CALC_FOUND_ROWS photos.id, photos.title, photos.url, 
            (SELECT COUNT(*) FROM photos_likes WHERE photo_id = photos.id) AS favs'))
            ->join('photos_likes', 'photos_likes.photo_id', '=', 'photos.id', 'left')
            ->groupBy('photos.id')
            ->orderByRaw('favs DESC')
            ->offset($offset)
            ->limit($entriesPerPage)
            ->get();
        } else {
            $results = DB::table('users')
            ->select(DB::raw('SQL_CALC_FOUND_ROWS users.name, users.email, 
            (SELECT COUNT(*) FROM photos_likes WHERE user_id = users.id) AS favs'))
            ->join('photos_likes', 'photos_likes.user_id', '=', 'users.id', 'left')
            ->groupBy('users.id')
            ->orderByRaw('favs DESC')
            ->offset($offset)
            ->limit($entriesPerPage)
            ->get();
        }
        $found = DB::select(DB::raw("SELECT FOUND_ROWS() AS totalCount"));
        $return['results'] = $results;
        $return['totalCount'] = $found[0]->totalCount;

        return $return;
    }

    public function weekday()  {
        $entriesPerPage = 12;
        // Select "photos" table
        $return = $this->getResults(true, $entriesPerPage);
        // Collect and output a limited (based on $entriesPerPage) array:
        $data = Array();
        $i = 1;
        foreach($return['results'] as $photo) {
            if ($i <= $entriesPerPage) {
                $data[$i]['id'] = $photo->id;
                $data[$i]['title'] = $photo->title;
                $data[$i]['url'] = $photo->url;
                $data[$i]['favs'] = $photo->favs;

                $i++;
            } else {
                break;
            }
        }
        $output['data'] = $data;
        $output['totalPages'] = round($return['totalCount'] / $entriesPerPage);

        return $output;
    }

    public function weekend()  {
        $entriesPerPage = 4;
        // Select "users" table
        $return = $this->getResults(false, $entriesPerPage);
        // Collect and output a limited (based on $entriesPerPage) array:
        $data = Array();
        $i = 1;
        foreach($return['results'] as $user) {
            if ($i <= $entriesPerPage) {
                $data[$i]['name'] = $user->name;
                $data[$i]['email'] = $user->email;
                $data[$i]['favs'] = $user->favs;

                $i++;
            } else {
                break;
            }
        }
        $output['data'] = $data;
        $output['totalPages'] = round($return['totalCount'] / $entriesPerPage);

        return $output;
    }

}