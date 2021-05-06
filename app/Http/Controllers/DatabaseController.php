<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DatabaseController extends Controller
{
    // function all_exercise() {
    //     $url = "http://babasama.me/all_exercise";
    //     $json = json_decode(file_get_contents($url), true);
    //     return $json;
    // }

// getting user data and user has exercise data to create a new user has exercise data
    function add_user_has_exercise_data(Request $req) {
        // checking url inputs
        $user_id = isset($req['user_id']) ? $req['user_id'] : 0;
        $username = isset($req['username']) ? $req['username'] : '';
        $user_password = isset($req['user_password']) ? $req['user_password'] : '';
        $user_has_exercise_id = isset($req['user_has_exercise_id']) ? $req['user_has_exercise_id'] : 0;
        $sets = isset($req['sets']) ? $req['sets'] : 0;
        $reps = isset($req['reps']) ? $req['reps'] : 0;
        $weight = isset($req['weight']) ? $req['weight'] : 0;
        $date = isset($req['date']) ? $req['date'] : '';
        $proceed = false;
        $array = array();

        // checking inputs have data
        if (!($user_id || $username || $user_password || $user_has_exercise_id || $sets || $reps || $weight || $date)) {
            $array['output'] = 'Invalid Parameters';
            return [$array];
        }

        // login check
        $loginurl = "http://babasama.me/user/username/$username/user_password/$user_password";
        $result = json_decode(file_get_contents($loginurl), true);
        if ($result == null) {
            $array['output'] = "Username or Password Wrong";
            return [$array];
        } 
        //check whether 
        $check_user_has_exercise = "http://babasama.me/user_has_exercise/user_id/$user_id/user_password/$user_password";
        $result_check = json_decode(file_get_contents($check_user_has_exercise), true);
        foreach ($result_check as $i) {
            $proceed = ($i['user_has_exercise_id'] == $user_has_exercise_id) ? false : true;
        }
        if ($proceed) {
            $url = "http://babasama.me/add_user_has_exercise_data/user_has_exercise_id/$user_has_exercise_id/sets/$sets/reps/$reps/weight/$weight/date/$date";
            $json = json_decode(file_get_contents($url), true);
            if ($json['affectedRows'] == 0) {
                $array['output'] = "Adding Failed";
                return [$array];
            }
            $array['output'] = "Successfully added";
            return [$array];
        } 
        $array['output'] = "User does not process such exercise";
        return [$array];
    }

// getting user data and user has exercise data to make delete on user_has_exercise_data table
    function delete_user_has_exercise_data(Request $req) {
        // checking url inputs
        $username = isset($req['username']) ? $req['username'] : '';
        $user_password = isset($req['user_password']) ? $req['user_password'] : '';
        $data_id = isset($req['data_id']) ? $req['data_id'] : 0;
        $date = isset($req['date']) ? $req['date'] : '';
        $array = array();

        // checking url inputs having values
        if (!($username || $user_password || $user_has_exercise_id || $date)) {
            $array['output'] = "Invalid Parameters";
            return [$array];
        }

        // checking whether username and user_password correct
        $loginurl = "http://babasama.me/user/username/$username/user_password/$user_password";
        $result = json_decode(file_get_contents($loginurl), true);
        if ($result == null) {
            $array['output'] = "Username or Password Wrong";
            return [$array];
        } 
        // delete data base on the user_has_exercise_id and the date of the exercise
        $url = "http://babasama.me/delete_user_has_exercise_data/data_id/$data_id/date/$date";
        $json = json_decode(file_get_contents($url), true);
        if ($json['affectedRows'] == 0) {
            $array['output'] = "Already Deleted";
            return [$array];
        }
        $array['output'] = "Successfully Deleted";
        return [$array];
    }

// getting user data and exercise data and make an update on user_has_exercise_data table
    function edit_user_has_exercise_data(Request $req) {
        // checking url inputs
        $username = isset($req['username']) ? $req['username'] : '';
        $user_password = isset($req['user_password']) ? $req['user_password'] : '';
        $data_id = isset($req['data_id']) ? $req['data_id'] : 0;
        $sets = isset($req['sets']) ? $req['sets'] : 0;
        $reps = isset($req['reps']) ? $req['reps'] : 0;
        $sets_done = isset($req['sets_done']) ? $req['sets_done'] : 0;
        $weight = isset($req['weight']) ? $req['weight'] : 0;
        $date = isset($req['date']) ? $req['date'] : '';
        $array = array();

        // checking whether inputs have value 
        if (!($username || $user_password || $data_id || $sets || $reps || $sets_done || $weight || $date)) {
            $array['output'] = "Invalid Parameters";
            return [$array];
        }

        // checking whether username and user_password correct
        $loginurl = "http://babasama.me/user/username/$username/user_password/$user_password";
        $result = json_decode(file_get_contents($loginurl), true);
        if ($result == null) {
            $array['output'] = "Username or Password Wrong";
            return [$array];
        }
        // edit the exercise with the user_has_exercise_id, sets, reps, sets_done, weight and date
        $url = "http://babasama.me/edit_user_has_exercise_data/data_id/$data_id/sets/$sets/reps/$reps/sets_done/$sets_done/weight/$weight/date/$date";
        $json = json_decode(file_get_contents($url), true);
        if ($json['affectedRows'] == 0) {
            $array['output'] = "Editing failed";
            return [$array];
        }
        $array['output'] = "Successfully Edited";
        return [$array];
    }

    function new_set_done(Request $req) {
        $data_id = isset($req['data_id']) ? $req['data_id'] : 0;
        $sets_done = isset($req['sets_done']) ? $req['sets_done'] : 0;
        $date = isset($req['date']) ? $req['date'] : '';
        $username = isset($req['username']) ? $req['username'] : '';
        $user_password = isset($req['user_password']) ? $req['user_password'] : '';
        $array = array();

        // checking whether inputs have values
        if (!($data_id || $sets_done || $date || $username || $user_password)) {
            $array['output'] = "Invalid Parameters";
            return [$array];
        }

        // checking whether username and user_password correct
        $loginurl = "http://babasama.me/user/username/$username/user_password/$user_password";
        $result = json_decode(file_get_contents($loginurl), true);
        if ($result == null) {
            $array['output'] = "Username or Password Wrong";
            return [$array];
        } 

        $url = "http://babasama.me/new_set_done/data_id/$data_id/sets_done/$sets_done/date/$date";
        $json = json_decode(file_get_contents($url), true);
        if ($json['affectedRows'] == 0) {
            $array['output'] = "update failed";
            return $array;
        }
        $array['output'] = "Successfully updated";
        return [$array];
    }

// getting exercise data and user data and binding on user_has_exercise table
    function new_exercise(Request $req) {
        // checking url inputs
        $exercise_name = isset($req['exercise_name']) ? $req['exercise_name'] : '';
        $exercise_image = isset($req['exercise_image']) ? $req['exercise_image'] : '';
        $user_id = isset($req['user_id']) ? $req['user_id'] : 0;
        $username = isset($req['username']) ? $req['username'] : '';
        $user_password = isset($req['user_password']) ? $req['user_password'] : '';
        $exercise_id = 0;
        $user_has_exercise_id = 0;
        $proceed = true;
        $array = array();

        // checking whether inputs have values
        if (!($exercise_name || $exercise_image || $user_id || $username || $user_password)) {
            $array['output'] = "Invalid Parameters";
            return [$array];
        }

        // checking whether username and user_password correct
        $loginurl = "http://babasama.me/user/username/$username/user_password/$user_password";
        $result = json_decode(file_get_contents($loginurl), true);
        if ($result == null) {
            $array['output'] = "Username or Password Wrong";
            return [$array];
        } 
        // checking whether same exercise name and image exist
        $exerciseurl = "http://babasama.me/all_exercise";
        $exerciseresult = json_decode(file_get_contents($exerciseurl), true);
        foreach ($exerciseresult as $i) {
            if ($i['exercise_name'] == $exercise_name && $i['exercise_image'] == $exercise_image) {
                $array['output'] = "Exercise already been inserted";
                return [$array];
            }
        }
        // adding new exercise into exercise table
        $insert_exercise_url = "http://babasama.me/new_exercise/exercise_name/$exercise_name/exercise_image/$exercise_image";
        $result_of_insert = json_decode(file_get_contents($insert_exercise_url), true);
        if ($result_of_insert['affectedRows'] == 0) {
            $array['output'] = "Exercise Already Exist";
            return [$array];
        }
        // getting back the exercise_id
        $result_of_exercise = json_decode(file_get_contents($exerciseurl), true);
        foreach ($result_of_exercise as $i) {
            $exercise_id = ($i['exercise_name'] == $exercise_name && $i['exercise_image'] == $exercise_image )? $i['exercise_id'] : 0;
        }
        if (!$exercise_id) {
            $array['output'] = "Exercise does not exist";
            return [$array];
        }
        // adding the newly added exercise to the user
        $new_user_has_exercise = "http://babasama.me/user_has_new_exercise/user_id/$user_id/exercise_id/$exercise_id";
        $result_user_has_exercise = json_decode(file_get_contents($new_user_has_exercise), true);
        if ($result_user_has_exercise['affectedRows'] == 0) {
            $array['output'] = "Exercise already been bind";
            return [$array];
        }
        $array['output'] = "Exercise have been successfully bind";
        return [$array];
        
    }

// getting user data and create a new user in user table and bind default exercise data to user_has_exercise table
    function new_user(Request $req) {
        // checking url inputes
        $username = isset($req['username']) ? $req['username'] : '';
        $user_email = isset($req['user_email']) ? $req['user_email'] : '';
        $user_password = isset($req['user_password']) ? $req['user_password'] : '';
        $user_id = 0;
        $array = array();

        // checking whether inputs have data
        if (!($username || $user_email || $user_password)) {
            $array['output'] = "Invalid Parameters";
            return [$array];
        } 

        // checking whether is there existing username 
        $loginurl = "http://babasama.me/user/username/$username/user_password/$user_password";
        $result = json_decode(file_get_contents($loginurl), true);
        if ($result != null) {
            $array['output'] = "User already exist";
            return [$array];
        }
        // adding new user into user table
        $new_user_url = "http://babasama.me/new_user/username/$username/user_email/$user_email/user_password/$user_password";
        $result_new_user = json_decode(file_get_contents($new_user_url), true);
        if ($result_new_user['affectedRows'] == 0) {
            $array['output'] = "Creation failed";
            return [$array];
        }
        // getting the user_id that was just created
        $getting_user_id = "http://babasama.me/user/username/$username/user_password/$user_password";
        $result_user_id = json_decode(file_get_contents($getting_user_id), true);
        if ($result_user_id == null) {
            $array['output'] = "I dont even know if it can even return null but im going just to put something here.";
            return [$array];
        } 
        $user_id = $result_user_id[0]['user_id'];
        // adding default exercise into user_has_exercise table
        $url = "http://babasama.me/new_user_has_exercise/user_id/$user_id";
        $json = json_decode(file_get_contents($url), true);
        if ($json['affectedRows'] == 0) {
            $array['output'] = "Adding exercise failed";
            return [$array];
        }
        return $result_user_id;
    }

// getting exercises that is bind to the user
    function user_has_exercise(Request $req) {
        // checking url inputs
        $user_id = isset($req['user_id']) ? $req['user_id'] : 0;
        $user_password = isset($req['user_password']) ? $req['user_password'] : '';
        $array = array();
        // checking whether inputs have data
        if (!($user_id || $user_password)) {
            $array['output'] = "Invalid Parameters";
            return [$array];
        }

        // just getting data since database backend already checking for user_id and password
        $url = "http://babasama.me/user_has_exercise/user_id/$user_id/user_password/$user_password";
        $json = json_decode(file_get_contents($url), true);
        if ($json == null) {
            $array['output'] = "User has no exercise being bind to him";
            return [$array];
        }
        return $json;
    }

// getting user has exercise data
    function user_has_exercise_data(Request $req) {
        // checking url inputs
        $user_id = isset($req['user_id']) ? $req['user_id'] : 0;
        $user_password = isset($req['user_password']) ? $req['user_password'] : '';
        $day = isset($req['day']) ? $req['day'] : 'today';
        $array = array();
        $today = date('y-m-d');
        $tmr = date('y-m-d', mktime(0, 0, 0, date('m'), date('d')+1, date('y')));
        
        //checking whether inputs have data
        if (!($user_id || $user_password)) {
            $array['output'] = "Invalid Parameters";
            return [$array];
        }

        // getting data back
        $url = "http://babasama.me/user_has_exercise_data/user_id/$user_id/user_password/$user_password";
        $json = json_decode(file_get_contents($url), true);
        if ($json == null) {
            $array['output'] = "There is no data being stored";
            return [$array];
        }

        //filter day
        foreach($json as $i) {
            $date = (($i['date'] * 1000 + 978307200000) / 1000);
            if ($day == 'today' && $today == date('y-m-d', $date)) {
                $array[] = $i;
            } else if ($day == 'tomorrow' && $tmr == date('y-m-d', $date)) {
                $array[] = $i;
            } else if ($day == 'everyday' && date('y-m-d', $date) >= $today) {
                $array[] = $i;
            }
        }

        return $array;
    }

// getting username and password and return user data.
    function user(Request $req) {
        // checking url inputs
        $username = isset($req['username']) ? $req['username'] : '';
        $user_password = isset($req['user_password']) ? $req['user_password'] : '';
        $array = array();

        // checking whether url inputs have data
        if (!($username || $user_password)) {
            $array['output'] = "Invalid Parameters";
            return [$array];
        }

        // get data from backend database url and return to the frontend https page.
        $url = "http://babasama.me/user/username/$username/user_password/$user_password";
        $json = json_decode(file_get_contents($url), true);
        if ($json == null) {
            return 'Username or Password Wrong';
        }
        return $json;
    }
}