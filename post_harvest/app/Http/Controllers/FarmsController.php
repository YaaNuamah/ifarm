<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Farm;

class FarmsController extends Controller
{
    //parameters to connect to hubtel SMS API
    private $api = "https://api.hubtel.com/v1/messages/send?";
    private $client_id = "dnymazlw";
    private $client_secret = "hqynfckc";
    private $registered_delivery = "true";
    private $from = "iFarm";

    //ensures to access this page, the user must be authenticated
    public function __construct()
    {
        $this->middleware('auth');
    }

    //function to send a text message 
    public function sendMessage($number='', $message=''){
        //encoding message to send as a st
        $encoded_message = urlencode($message); 

        //url to make request to send sms
        $url_to_api = "{$this->api}From={$this->from}&To={$number}&Content={$encoded_message}"
                    . "&ClientId={$this->client_id}&ClientSecret={$this->client_secret}"
                    . "&RegisteredDelivery={$this->registered_delivery}";

        //making a GET http request with GuzzleHttp to url
        $hubtel_sms_client = new Client();
        $response = $hubtel_sms_client->get($url_to_api);
        $result = $response->getBody()->getContents();
        $result = json_decode($result, true);
        return $result['Status'];
    }

    public function notify(){
        $farm = Farm::where('farmer_id', \Auth::user()->id)->first();
        
        $username = \Auth::user()->name;
        $farm_crop = $farm->crop;
        $farm_location = $farm->gps;
        $farm_date = gmdate("D d, m Y", strtotime($farm->date_harvest));
        $farm_size = $farm->size;
        $message = "Dear {$username},\n"
                ."Your {$farm_size} acre {$farm_crop} farm located at {$farm_location} id due for harvesting on {$farm_date}"
                ."To facilitate easier harvesting, you can use 3 combine harvestors to cover the full acreage."
                ."\n\n iFarm, your smart farm aid.";
        $request_status = $this->sendMessage(\Auth::user()->telephone,$message);
        return redirect('/home');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $farms = Farm::where('farmer_id',  \Auth::user()->id)->get();
        return view('home', compact('farms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() //renders the view to display the form to create a Farm
    {
        //
        return view('farms.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) //saves the inputs from the Create Farm page to DB
    {
        $harvest_date = gmdate("Y-m-d", strtotime("+".mt_rand(2,100)." days", strtotime(request('date_started'))));
        Farm::create(array_merge(request(['crop', 'date_started', 'farmer_id', 'size', 'gps']),
                                 array('date_harvest'=> $harvest_date)));
        $crop = request('crop');
        $gps = request('gps');
        $size = request('size');
        $username = \Auth::user()->name;
        $message = "Dear {$username},\n"
                    ."Your {$size} acre {$crop} farm located at {$gps} has been added to iFarm successfully."
                    ."We would continue to give you tips and reminders through the reminder of the farming season."
                    ."\n\n iFarm, your smart farm aid.";
        $requestStatus = $this->sendMessage(\Auth::user()->telephone, $message);
        return redirect('/home');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
