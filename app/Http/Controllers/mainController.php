<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Session;

use App\User;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use Illuminate\Support\Facades\Redirect;
use Auth;

class mainController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		Session::set('bb_to_remove_array', null);
		Session::set('bb_to_remove_array_tr', null);

		//
		$msg = '';
		$user = User::find(Auth::id());

		
		if (isset($user)) {
			if ($user->is('admin')) { 
			    // if user has at least one role
			    $msg = "Hi admin";
			    // return redirect('/');
			    return view('first',compact('msg'));
			}

			if ($user->is('modul')) { 
			    // if user has at least one role
			    $msg = "Hi  module/line";
			    return redirect('/production');
			}

			if ($user->is('magacin')) { 
			    // if user has at least one role
			    $msg = "Hi  magacin";
				return view('first',compact('msg'));
			}

			if ($user->is('cutting')) { 
			    // if user has at least one role
			    $msg = "Hi  cutting";
				return redirect('/prepare');
			}	

			if ($user->is('guest')) { 
			    // if user has at least one role
			    $msg = "Hi Guest";
			    return redirect('/');
			}	

			// dd($msg);
		}

		// dd($msg);
		return view('first');
	}



}
