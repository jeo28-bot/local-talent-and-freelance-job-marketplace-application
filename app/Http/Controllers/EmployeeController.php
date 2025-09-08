<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
  public function index() {
        return view('employee.index');
    }
  public function postings()
    {
        return view('employee.postings');
    }
  public function transactions()
    {
        return view('employee.transactions');
    }
  public function applying()
    {
        return view('employee.applying');
    }
  public function saved()
    {
        return view('employee.saved');
    }
  public function messages()
    {
        return view('employee.messages');
    }
   public function notifications()
    {
        return view('employee.notifications');
    }
}
