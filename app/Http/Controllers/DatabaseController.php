<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DatabaseController extends Controller
{
    function login(Request $req) {
        $username = $req->username ?? '';
        $password = $req->password ?? '';

        if (!($username || $password)) {
            return [['output' => "Invalid params"]];}
        
        $data = DB::table('gym_planner.User')->where([['username', "$username"], ['user_password', "$password"]])->get();
        foreach($data as $i) {
            return [$i];}
    }

    function signup(Request $req) {
        $username = $req->username ?? '';
        $password = $req->password ?? '';
        $email = $req->email ?? '';

        if (!($username || $email || $password)) {
            return [['output' => "Invalid params"]];}

        $result = DB::table('gym_planner.User')->insertOrIgnore([
            'username' => "$username",
            'user_email' => "$email",
            'user_password' => "$password"]);

        if ($result == 1) {
            $user = DB::table('gym_planner.User')->where([['username', "$username"], ['user_password', "$password"]])->get();
            foreach($user as $i) {
                DB::table('gym_planner.User_Has_Exercise')->insert([
                    ['user_id' => $i->user_id, 'exercise_id' => 1], 
                    ['user_id' => $i->user_id, 'exercise_id' => 2], 
                    ['user_id' => $i->user_id, 'exercise_id' => 3], 
                    ['user_id' => $i->user_id, 'exercise_id' => 4], 
                    ['user_id' => $i->user_id, 'exercise_id' => 5], 
                    ['user_id' => $i->user_id, 'exercise_id' => 6]
                ]);
                return $user;
            }} return [['output' => 'user already exist']];
    }

    function get_user_exercise(Request $req) {
        $username = $req->username ?? '';
        $password = $req->password ?? '';

        if (!($username || $password)) {
            return [['output' => "Invalid params"]];}

        $user = DB::table('gym_planner.User')->where([['username', "$username"], ['user_password', "$password"]])->get();
        foreach($user as $i) {
            return DB::table('gym_planner.User_Has_Exercise')->where('user_id', $i->user_id)->get();}
    }

    function get_user_exercise_data(Request $req) {
        $username = $req->username ?? '';
        $password = $req->password ?? '';
        $date = $req->date ?? time();
        $user_id;
        $user_has_exercise_data = array();

        if (!($username || $password)) {
            return [['output' => "Invalid params"]];}

        $date = date('Y-m-d', $date);

        $userData = DB::table('gym_planner.User')->where([['username', "$username"], ['user_password', "$password"]])->get();
        foreach ($userData as $i) {
            $user_id = $i->user_id;}

        if ($user_id != 0) {
            $data = DB::table(DB::raw('gym_planner.User_Has_Exercise_Data UHED'))
            ->join(DB::raw('gym_planner.User_Has_Exercise UHE'), 'UHED.user_has_exercise_id', '=', 'UHE.user_has_exercise_id')
            ->select('UHED.*')
            ->where('UHED.date', "$date")
            ->get();
            foreach($data as $i) {
                $i->date = strtotime($i->date) + 978307200;
                $user_has_exercise_data[] = $i;
            }
            return $user_has_exercise_data;
        } return [['output' => 'user credentials wrong']];
    }

    function get_all_future_exercise_data(Request $req) {
        $username = $req->username ?? '';
        $password = $req->password ?? '';
        $date = date('Y-m-d', time());
        $user_id;
        $user_has_exercise_data = array();

        if (!($username || $password)) {
            return [['output' => "Invalid params"]];}

        $userData = DB::table('gym_planner.User')->where([['username', "$username"], ['user_password', "$password"]])->get();
        foreach ($userData as $i) {
            $user_id = $i->user_id;}

        if ($user_id != 0) {
            $data = DB::table(DB::raw('gym_planner.User_Has_Exercise_Data UHED'))
            ->join(DB::raw('gym_planner.User_Has_Exercise UHE'), 'UHED.user_has_exercise_id', '=', 'UHE.user_has_exercise_id')
            ->select('UHED.*')
            ->where('UHED.date', '>=', "$date")
            ->get();
            foreach($data as $i) {
                $i->date = strtotime($i->date) + 978307200;
                $user_has_exercise_data[] = $i;
            }
            return $user_has_exercise_data;
        } return [['output' => 'user credentials wrong']];
    }

    function add_edit_exercise_data(Request $req) {
        $username = $req->username ?? '';
        $password = $req->password ?? '';
        $user_id;
        $user_has_exercise_id = $req->user_has_exercise_id ?? 0;
        $user_has_exercise_id_true = false;
        $sets = $req->sets ?? 0;
        $reps = $req->reps ?? 0;
        $weight = $req->weight ?? 0;
        $date = $req->date ?? time();

        if (!($username || $password || $user_has_exercise_id || $sets || $reps || $date)) {
            return [['output' => "Invalid params"]];}

        $date = date('Y-m-d', $date);

        $userData = DB::table('gym_planner.User')->where([['username', "$username"], ['user_password', "$password"]])->get();
        foreach ($userData as $i) {
            $user_id = $i->user_id;}

        if ($user_id != 0) {
            $user_has_exercise = DB::table('gym_planner.User_Has_Exercise')->where([['user_has_exercise_id', $user_has_exercise_id], ['user_id', $user_id]])->get();
            foreach($user_has_exercise as $i) {
                if ($i->user_has_exercise_id == $user_has_exercise_id) {
                    $user_has_exercise_id_true = true;
                }}

            if ($user_has_exercise_id_true) {
                $data = DB::table('gym_planner.User_Has_Exercise_Data')
                ->updateOrInsert(
                    ['user_has_exercise_id' => $user_has_exercise_id, 'date' => $date], 
                    ['sets' => $sets, 'reps' => $reps, 'weight' => $weight]);
                
                if ($data > 0) {
                    return [['output' => 'updated']];
                } return [['output' => 'fail to update']];
            } return [['output' => 'user_exercise_id does not exist or is not binded to your account']];
        } return [['output' => 'user credentials wrong']];
    }

    function add_new_exercise(Request $req) {
        $username = $req->username ?? '';
        $password = $req->password ?? '';
        $user_id;
        $exercise_name = $req->exercise_name ?? '';
        $exercise_image = $req->exercise_image ?? '';
    
        if (!($username || $password || $exercise_name || $exercise_image)) {
            return [['output' => "Invalid params"]];}

        $userData = DB::table('gym_planner.User')->where([['username', "$username"], ['user_password', "$password"]])->get();
        foreach ($userData as $i) {
            $user_id = $i->user_id;
        }

        if ($user_id > 0) {
            $exercise_id = DB::table('gym_planner.Exercise')->insertGetId(
                ['exercise_name' => "$exercise_name", 'exercise_image' => "$exercise_image"]
            );
            $insert = DB::table('gym_planner.User_Has_Exercise')->insert([
                'user_id' => $user_id, 'exercise_id' => $exercise_id
            ]);
            if ($insert > 0) {
                return [['output' => 'successfully inserted']];
            } return [['output' => 'insertation failed']];
        } return [['output' => 'user credentials wrong']];
    }

    function delete_exercise_data(Request $req) {
        $username = $req->username ?? '';
        $password = $req->password ?? '';
        $data_id = $req->data_id ?? 0;
        $date = $req->date ?? time();

        if (!($username || $password || $exercise_name || $exercise_image)) {
            return [['output' => "Invalid params"]];}

        $date = date('Y-m-d', $date);
        
        $userData = DB::table('gym_planner.User')->where([['username', "$username"], ['user_password', "$password"]])->get();
        foreach ($userData as $i) {
            $user_id = $i->user_id;
        }

        if ($user_id > 0) {
            $value = DB::table('gym_planner.User_Has_Exercise_Data')->where([['data_id', $data_id], ['date', $date]])->delete();
            if ($value > 0) {
                return [['output' => 'successfully deleted']];
            } return [['output' => 'delete failed']];
        } return [['output' => 'user credentials wrong']];
    }

    function new_set_done(Request $req) {
        $username = $req->username ?? '';
        $password = $req->password ?? '';
        $data_id = $req->data_id ?? 0;
        $date = $req->date ?? time();

        if (!($username || $password || $data_id || $date)) {
            return [['output' => "Invalid params"]];}

        $date = date('Y-m-d', $date);
        
        $userData = DB::table('gym_planner.User')->where([['username', "$username"], ['user_password', "$password"]])->get();
        foreach ($userData as $i) {
            $user_id = $i->user_id;}

        if ($user_id > 0) {
            $data = DB::table('gym_planner.User_Has_Exercise_Data')->select('sets', 'sets_done')->where([['data_id', $data_id], ['date', $date]])->get();
            foreach($data as $i) {
                if ($i->sets_done < $i->sets) {
                    DB::table('gym_planner.User_Has_Exercise_Data')->where([['data_id', $data_id], ['date', $date]])->increment('sets_done', 1);
                    return [['output' => 'update complete']];
                } return [['output' => 'exercise already complete']];
            } return [['output' => 'exercise not found']];
        } return [['output' => 'user credentials wrong']];
    }
}