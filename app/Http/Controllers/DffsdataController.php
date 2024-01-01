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
       // Check if a file is present in the request
       if (!$request->hasFile('file')) {
        return response()->json(['error' => 'No file provided.'], 400);
    }

    // Get the file from the request
    $file = $request->file('file');
    $userId = $request->input('userId');
    // Check if the file is valid
    if (!$file->isValid()) {
        return response()->json(['error' => 'Invalid file.'], 400);
    }
        $file = $request->file('file');

        // IPFS daemon endpoint
        $ipfsEndpoint = 'http://127.0.0.1:5001/api/v0';

        // Create a Guzzle HTTP client
        $client = new Client();

        // Add the file to IPFS using the HTTP API
        $response = $client->post("$ipfsEndpoint/add", [
            'multipart' => [
                [
                    'name'     => 'file',
                    'contents' => fopen($file->getPathname(), 'r'),
                ],
            ],
        ]);

        // Get the response body (JSON) and decode it
        $result = json_decode($response->getBody(), true);

        // Get the IPFS hash of the added file
        $ipfsHash = $result['Hash'];

        $data = new dffsdata([
            'ipfsHash' => $ipfsHash,
            'userId' => $userId,
        ]);
        $data->save();

        return back()->with('message',"File Uploaded Successfully");
    }
 

    public function retrieveFromIPFS(Request $request){
        // Get the user ID if the user is logged in
        $userId = Auth::id();
    
        // IPFS daemon endpoint
        $hash = $request->input('hash');
        $ipfsEndpoint = 'http://127.0.0.1:5001/api/v0';
    
        // Retrieve all records from the 'ipfs_files' table based on the user's ID
        $ipfsFiles = dffsdata::where('userId', $userId)->get();
    
        // If files are found for the user
        if ($ipfsFiles->isNotEmpty()) {
            // You can now loop through each file and process them
            foreach ($ipfsFiles as $ipfsFile) {
                // Get the associated IPFS hash for each file
                $ipfsHash = $ipfsFile->ipfs_hash;
    
                // Create a Guzzle HTTP client
                $client = new Client();
    
                // Retrieve the file from IPFS using the HTTP API
                $response = $client->get("$ipfsEndpoint/cat/$ipfsHash");
    
                // Get the content of the file
                $fileContent = $response->getBody();
    
                // You can now use $fileContent as needed, such as displaying it or storing it in your application.
    
                // Optionally, you can pass the user ID to the view for further customization
                // You may want to aggregate $fileContent for all files or handle each file separately based on your use case
                // Here, we are passing an array of file contents to the view
                $fileContents[] = $fileContent;
            }
           
            return view('home', ['fileContents' => $fileContents, 'userId' => $userId]);
        }
    
        // Handle the case where no records are found for the user
        return response()->json(['error' => 'No files found for the user.'], 404);
    }
    
}
