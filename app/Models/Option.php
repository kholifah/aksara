<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{

    protected $table = 'options';
    protected $fillable = ['key', 'value'];
    public $timestamps = false;

    public function validate($data)
    {
        $rules = [
            'key' => 'required|max:40',
        ];

        return \Validator::make($data, $rules);
    }

    public static function delete_options($key = FALSE)
    {
        // Checking key can't be empty
        if (!$key)
        {
            return FALSE;
        }

        // Get option data from db
        $option = Option::where('key', $key)->first();
        if ($option)
        {
            // Delete option if data option valid
            $option->delete();
        } else {
            return FALSE;
        }
        return TRUE;
    }

    // Function for get option data
    public static function get_options($key = FALSE, $default = false)
    {
        // Checking key can't be empty
        if (!$key)
        {
            return FALSE;
        }

        // Get option data from db
        $option = Option::where('key', $key)->first();

        if ($option)
        {
            // Checking value data to unserialize or change string to array data
            $dataUnserialize = @unserialize($option->value);

            if ($dataUnserialize !== false) {
                return $dataUnserialize;
            } else {
                return $option->value;
            }

        }
        else if ($default !== false)
          return $default;

        return FALSE;

    }

    // Function for set option data
    public static function set_options($key = FALSE, $value = FALSE, $serialize = true)
    {
        // Checking key can't be empty
        if (!$key)
        {
            return FALSE;
        }

        // Get data option from db
        $option = Option::where('key', $key)->first();
        $data = '';

        // Checking value data to serialize or change array data to string

        $dataSerialize = @serialize($value);

        if ($data !== false)
            $data = $dataSerialize;
        else
          $data = $value;

        $save = [
            'key' => $key,
            'value' => $data,
        ];

        if ($option)
        {
            // Checking data input
            $validator = $option->validate($save);
            if ($validator->fails())
            {
                return back()->withErrors($validator)->withInput();
            }

            // Checking data if empty
            if ($data != '')
            {
                $option->key = $save['key'];
                $option->value = $save['value'];
                if ($option->save())
                    return TRUE;
                else
                    return FALSE;
            } else {
                 if ($option->delete())
                    return TRUE;
                else
                    return FALSE;
            }
        } else {
            // If option data not in db, create new data
            $option = new Option;
            //Checking data input
            $validator = $option->validate($save);
            if ($validator->fails())
            {
                return back()->withErrors($validator)->withInput();
            }
            $option->key = $save['key'];
            $option->value = $save['value'];
            if ($option->save())
                return TRUE;
            else {
                admin_notice('danger', 'Data gagal disimpan.');
                return FALSE;
            }
        }
    }

}
