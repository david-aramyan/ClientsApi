<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use App\Models\ClientPhone;
use App\Models\ClientEmail;

class ClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (request()->method == "PUT") {
            $parts = explode("/", request()->url());
            $id = end($parts);

            $rules =  [
                'name'                  => 'required',
                'lastname'              => 'required',
                'emails'                => 'required|array|min:1',
                'phone_numbers'         => 'required|array|min:1',
                'emails.*'              => 'email',
                'phone_numbers.*'       => ['regex:/^[0-9]+$/'],
            ];
            if ($this->emails) {
                $clientEmails = ClientEmail::whereIn('email', $this->emails)->get();
                $i = 0;
                foreach ($clientEmails as $key => $email) {
                    if ($id != $email->client_id) {
                        $rules = array_merge($rules, ['emails.' . $i  => 'email|unique:emails,email']);
                        $i++;
                    }
                }
            }
            if ($this->phone_numbers) {
                $clientPhones = ClientPhone::whereIn('number', $this->phone_numbers)->get();
                $j = 0;
                foreach ($clientPhones as $key => $phone) {
                    if ($id != $phone->client_id) {
                        $rules = array_merge($rules, ['phone_numbers.' . $j => 'unique:phone_numbers,number|regex:/^[0-9]+$/']);
                        $j++;
                    }
                }
            }
            return  $rules;
        } else {
            return [
                'name' => 'required',
                'lastname' => 'required',
                'emails' => 'required|array|min:1',
                'emails.*' => 'email|unique:emails,email',
                'phone_numbers' => 'required|array|min:1',
                'phone_numbers.*' => ['required', 'unique:phone_numbers,number', 'regex:/^[0-9]+$/'],
            ];
        }
    }
}
