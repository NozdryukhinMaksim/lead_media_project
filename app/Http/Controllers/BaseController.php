<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class BaseController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = $this->getService();
    }

    abstract protected function getService();
}
