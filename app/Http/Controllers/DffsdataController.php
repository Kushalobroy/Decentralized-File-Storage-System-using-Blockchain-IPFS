<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Models\dffsdata;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;


class DffsdataController extends Controller
{
    public function addToIPFS(Request $request){
       if (!$request->hasFile('file')) {
        return response()->json(['error' => 'No file provided.'], 400);
    }
    $file = $request->file('file');
    $userId = $request->input('userId');
    if (!$file->isValid()) {
        return response()->json(['error' => 'Invalid file.'], 400);
    }
        $file = $request->file('file');
        $ipfsEndpoint = 'http://127.0.0.1:5001/api/v0';
        $client = new Client();
        $response = $client->post("$ipfsEndpoint/add", [
            'multipart' => [
                [
                    'name'     => 'file',
                    'contents' => fopen($file->getPathname(), 'r'),
                ],
            ],
        ]);
        $result = json_decode($response->getBody(), true);
        $ipfsHash = $result['Hash'];

        $data = new dffsdata([
            'ipfsHash' => $ipfsHash,
            'userId' => $userId,
        ]);
        $data->save();

        return back()->with('message',"File Uploaded Successfully");
    }

 
    
}
