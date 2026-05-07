<?php

namespace App\Http\Controllers;

use App\HomeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;
use DB;
use View;
use Session;

class HomeServicesController extends Controller
{
    protected $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function index()
    {
        $loged = session()->get('user');
        if (!$loged) {
            Session::flash('message', 'Please Login Properly!');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }

        if (!$this->canManage($loged)) {
            Session::flash('message', 'You Are Not Access This Module!');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }

        $page = 'Settings';
        $services = HomeService::orderBy('priority', 'ASC')->orderBy('id', 'ASC')->get();

        return View::make('settings.home_services.manage_services')->with(compact('services', 'page'));
    }

    public function store(Request $request)
    {
        $loged = session()->get('user');
        if (!$loged) {
            Session::flash('message', 'Please Login Properly!');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }

        if (!$this->canManage($loged)) {
            Session::flash('message', 'You Are Not Access This Module!');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }

        $validator = Validator::make($request->all(), [
            'service_title' => 'required|array',
            'service_description' => 'required|array',
            'service_image' => 'nullable|array',
            'service_priority' => 'nullable|array',
            'service_status' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return redirect()->route('manage_home_services')->withErrors($validator);
        }

        foreach ((array) $request->service_title as $key => $title) {
            if (!$title && empty($request->service_description[$key])) {
                continue;
            }

            $service = null;
            if (!empty($request->service_id[$key])) {
                $service = HomeService::find($request->service_id[$key]);
            }

            if (!$service) {
                $service = new HomeService();
            }

            $service->title = $title;
            $service->description = $request->service_description[$key] ?? null;
            $service->priority = $request->service_priority[$key] ?? null;
            $service->is_block = isset($request->service_status[$key]) && $request->service_status[$key] == 1 ? 1 : 0;

            if ($request->hasFile("service_image.$key")) {
                $file = $request->file("service_image.$key");
                $fileName = time() . '_' . $file->getClientOriginalName();
                $date = date('M-Y');
                $filePath = 'images/home_services/' . $date;
                $file->move($filePath, $fileName);
                $service->image = $filePath . '/' . $fileName;
            } elseif (isset($request->old_service_image[$key])) {
                $service->image = $request->old_service_image[$key];
            }

            $service->save();
        }

        Session::flash('message', 'Services Updated Successfully!');
        Session::flash('alert-class', 'alert-success');

        return redirect()->route('manage_home_services');
    }

    public function delete(Request $request)
    {
        $service = HomeService::find($request->id);
        if ($service && $service->delete()) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

    private function canManage($loged)
    {
        return DB::table('previlages as A')
            ->leftJoin('modules as B', 'A.module', '=', 'B.id')
            ->select('A.id as pid', 'A.*', 'B.id as mid', 'B.*')
            ->where('B.module_name', '=', 'Footer Settings')
            ->where('A.role', '=', $loged->user_type)
            ->where(function ($query) {
                $query->where('A.edit', '=', 1)
                    ->orWhere('A.add', '=', 1);
            })
            ->first();
    }
}
