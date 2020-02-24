<?php

namespace App\Http\Controllers;

use App\Services\JwtService;
use Illuminate\Http\Request;

class JwtController extends Controller
{

    private $jwtService;
    /**
     * JwtController constructor.
     */
    public function __construct()
    {
        $this->jwtService = new JwtService();
    }

    public function test(Request $request) {
        return $this->jwtService->generateTest($request);
    }
}
