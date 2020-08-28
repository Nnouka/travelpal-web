<?php

namespace App\Http\Controllers;

use App\Payment;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    private $host_email = "quinevertm8@gmail.com"; // your merchant email
    public function pay(Request $request) {
        $query = $request->all();
        try{
            $client = new Client([
                'base_uri' => 'https://developer.mtn.cm/OnlineMomoWeb/faces/transaction/transactionRequest.xhtml',
                'timeout' => 50.0,
                'verify' => false,
            ]);

            $response = $client->request('GET', '', [
                'query' => [
                    'idbouton' => 2,
                    'typebouton' => 'PAIE',
                    '_amount' => $query['amount'],
                    '_tel' => $query['phone'],
                    '_clP' => '',
                    '_email' => $this->host_email,
                ]
            ]);
            $code = $response->getStatusCode();
            $reason = $response->getReasonPhrase();
            if (intval($code) == 200){
                $body = $response->getBody()->getContents();
                $body_array = json_decode($body, true);
                dd($body_array);
                if (intval($body_array['StatusCode']) == 1){
                    $payment = Payment::create([
                        'payment_channel' => 'MTNMomo',
                        'transaction_id' => $body_array['TransactionID'],
                        'sender_number' => $body_array['SenderNumber'],
                        'amount' => $body_array['Amount'],
                        'status_description' => $body_array['StatusDesc'],
                        'Op_comment' => $body_array['OpComment'],
                        'receiver_number' => $body_array['ReceiverNumber'],

                    ]);
                    Session::flash('success', 'Payment Successful!');
                    return redirect()->route('payment.details', ['transaction_id' => $payment->id]);
                }else{
                    Session::flash('error', 'Payment unsuccessful!');
                }
            }else{
                Session::flash('error', 'Error reaching server! Please try again.');
            }
        }catch (RequestException $exception){
            Session::flash('error', 'Connection timeout. Please check your internet connection and retry!');
        }catch (ClientException $exception){
            Session::flash('error', 'Bad Request! Resource not found');
        }
    }
}
