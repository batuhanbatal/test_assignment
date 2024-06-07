<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\Responseable;
use Illuminate\Http\Request;

class ChatControlller extends Controller
{
    use Responseable;

    public function index()
    {
        $exampleMessage = 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Adipisci laboriosam sapiente a excepturi voluptatem alias odit esse dolore! Soluta, exercitationem dicta optio laudantium est laborum ipsum iste rerum nobis vitae.';

        return Responseable::success($exampleMessage, 'Chat message fetched.');
    }
}
