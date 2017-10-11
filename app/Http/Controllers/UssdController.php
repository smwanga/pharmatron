<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UssdController extends Controller
{
    /**
     * undocumented function.
     *
     * @author
     **/
    public function __invoke(Request $request)
    {
        // Reads the variables sent via POST from our gateway
        $sessionId = $request->get('sessionId');
        $serviceCode = $request->get('serviceCode');
        $phoneNumber = str_replace('+', '', $request->get('phoneNumber'));
        $text = $request->get('text');
        // Here we assume that the data comes from the backend
        $users = [
            (object) [
                 'phoneNumber' => '+254711000000',
                 'name' => 'John Doe',
                 'account' => 'ACC001',
                 'balance' => 35000,
                 'currency' => 'KES',
            ],
            (object) [
                 'phoneNumber' => '+254711000001',
                 'name' => 'Mary Doe',
                 'account' => 'ACC002',
                 'balance' => 27000,
                 'currency' => 'KES',
            ],
        ];
        $collection = collect($users);
        //Let us check if the user exists in our records
        $user = $collection->where('phoneNumber', $phoneNumber)->first();
        //This is our first USSD Step
        if ($text == '') {
            if (null == $user) {
                $response = 'END We are sorry but you are not registered with us';
            } else {
                $response = "CON Welcome {$user->name}. What do you want to do\n";
                $response .= "1. My Account \n";
                $response .= '2. Check Balance';
            }
        } elseif (null != $user && $text !== '') {
            // We are go
            switch ($text) {
                case '1*1':
                    $account = "Name : {$user->name} \n";
                    $account .= "Account : {$user->account} \n";
                    $account .= "Currency : {$user->currency} \n";
                    $response = "END You Account Details \n";
                    $response .= $account;
                    break;
                case '1*2':
                    $balance = $user->currency.' '.number_format($user->balance, 2);
                    $response = "END Your account balance is {$balance} \n";
                    break;

                default:
                     $response = 'END Sorry but you choice is invalid';
                    break;
            }
        }
        // Handle skiped steps above
        else {
            $response = 'END Bad request';
        }
            // Print the response onto the page so that our gateway can read it
            return response($response, 200)->header('Content-type', 'text/plain');
            // DONE!!!
    }
}
