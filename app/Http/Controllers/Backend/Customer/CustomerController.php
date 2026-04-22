<?php

namespace App\Http\Controllers\Backend\Customer;

use App\Enums\Roles;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserLogin;
use App\Traits\Common;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    use Common;

    public function customerList()
    {
        $users = User::wherenotin('id', [4, 5])->where('role_id', Roles::Retailer)->get();
        return view('backend.admin.customer.customer', compact('users'));
    }

    function customerData()
    {
        try {
            $data = UserLogin::join('users as u', 'u.id', '=', 'user_logins.user_id')
                ->select([
                    'u.name as name',
                    'u.mobile as mobile',
                    'user_logins.login_at',
                    'user_logins.last_activity'
                ])
                ->whereNull('user_logins.logout_at')
                ->where('user_logins.last_activity', '>=', now()->subMinutes(240))
                ->orderBy('user_logins.last_activity', 'desc');

            return datatables()->of($data)

                // Search name from users table
                ->filterColumn('name', function ($query, $keyword) {
                    $query->where('u.name', 'like', "%{$keyword}%");
                })

                // Search mobile from users table
                ->filterColumn('mobile', function ($query, $keyword) {
                    $query->where('u.mobile', 'like', "%{$keyword}%");
                })

                ->make(true);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            return response()->json([
                'alert' => 'error',
                'message' => 'Something Went Wrong!'
            ]);
        }
    }

    function customerLogData(Request $request)
    {
        try {
            $data = UserLogin::join('users as u', 'u.id', '=', 'user_logins.user_id')
                ->select([
                    'u.id as user_id',
                    'u.name as name',
                    'u.mobile as mobile',
                    'user_logins.login_at',
                    'user_logins.logout_at'
                ]);

            if ($request->user_id && $request->user_id != 'all') {
                $data->where('u.id', $request->user_id);
            }

            if ($request->filled('from_date') && $request->filled('to_date')) {
                $from = Carbon::parse($request->from_date)->startOfDay();
                $to   = Carbon::parse($request->to_date)->endOfDay();

                $data->whereBetween('user_logins.login_at', [$from, $to]);
            }

            return datatables()->of($data)

                // Force search on users table
                ->filterColumn('name', function ($query, $keyword) {
                    $query->where('u.name', 'like', "%{$keyword}%");
                })

                ->filterColumn('mobile', function ($query, $keyword) {
                    $query->where('u.mobile', 'like', "%{$keyword}%");
                })

                ->editColumn('login_at', function ($row) {
                    return $row->login_at
                        ? Carbon::parse($row->login_at)->format('d-m-Y h:i A')
                        : '-';
                })

                ->editColumn('logout_at', function ($row) {
                    return $row->logout_at
                        ? Carbon::parse($row->logout_at)->format('d-m-Y h:i A')
                        : '-';
                })

                ->make(true);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            return response()->json([
                'alert' => 'error',
                'message' => 'Something Went Wrong!'
            ]);
        }
    }
}
