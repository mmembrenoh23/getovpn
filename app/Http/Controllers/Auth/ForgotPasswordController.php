<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestFor() {
    }

    public function sendResetLinkEmail() {

    }

    public function showLinkRequestForm() {

        return view("authentication.forgot-password");

    }
}
