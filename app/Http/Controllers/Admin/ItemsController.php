<?php
/**
 * Created by PhpStorm.
 * User: Redwan-PC
 * Date: 3/13/2019
 * Time: 12:02 PM
 */

namespace App\Http\Controllers\Admin;


use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ItemsController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        parent::$data['active_menu'] = 'items';
    }
    //////////////////////////
    public function getIndex()
    {
        return view('admin.items.view', parent::$data);
    }
    /////////////////////////////////////////
    public function getList(Request $request)
    {
        $item = new Item();

        $length = $request->get('length');
        $start = $request->get('start');
        $name = $request->get('name');

        $info = $item->getItemsPaginated($start, $length, $name);
        $count = $item->countItemsPaginated($name);
        $datatable = Datatables::of($info)->setTotalRecords($count);

        $datatable->editColumn('type', function ($row) {
            if ($row->type == 1)
            {
                return 'Goods';
            }
            else
            {
                return 'Service';
            }
        });

        $datatable->editColumn('status', function ($row)
        {
            $data['id'] = $row->id;
            $data['status'] = $row->status;

            return view('admin.items.parts.status', $data)->render();
        });

        $datatable->addColumn('actions', function ($row)
        {
            $data['id_hash'] = $row->id_hash;
            $data['btn_edit'] = parent::$data['btn_edit'];

            return view('admin.items.parts.actions', $data)->render();
        });
        $datatable->escapeColumns(['*']);
        return $datatable->make(true);
    }
    ////////////////////////
    public function getAdd()
    {
        return view('admin.items.add', parent::$data);
    }
    /////////////////////////////////////////
    public function postAdd(Request $request)
    {
        $name = $request->get('name');
        $description = $request->get('description');
        $type = $request->get('type');
        $price = $request->get('price');
        $status = (int)$request->get('status');

        $validator = Validator::make([
            'name' => $name,
            'description' => $description,
            'type' => $type,
            'price' => $price,
            'status' => $status
        ], [
            'name' => 'required|unique:items,name,0,id,deleted_at,NULL',
            'description' => 'required',
            'type' => 'required|numeric|in:1,2',
            'price' => 'required|numeric',
            'status' => 'required|numeric|in:0,1'
        ]);
        ////////////////////////
        if ($validator->fails())
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), $validator->messages()->first(), null,null);
        }
        //////////////////////////
        $item = new Item();
        $add = $item->addItem($name, $description, $type, $price, $status);
        if (!$add)
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), trans('messages.error'), null,null);
        }
        return $this->respondGeneral(true, 200, trans('alert.success'), trans('messages.added'), null, $add);
    }
    //////////////////////////////////////////////
    public function getEdit(Request $request, $id)
    {
        $id = $this->decrypt($id);

        $item = new Item();
        $info = $item->getItem($id);
        if (!$info)
        {
            $request->session()->flash('danger', trans('messages.not_found'));
            return redirect(route('admin.items.view'));
        }
        parent::$data['info'] = $info;
        return view('admin.items.edit', parent::$data);
    }
    ///////////////////////////////////////////////
    public function postEdit(Request $request, $id)
    {
        $id = $this->decrypt($id);

        $item = new Item();
        $info = $item->getItem($id);
        if (!$info)
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), trans('messages.not_found'), null,null);
        }

        $name = $request->get('name');
        $description = $request->get('description');
        $type = $request->get('type');
        $price = $request->get('price');
        $status = (int)$request->get('status');

        $validator = Validator::make([
            'name' => $name,
            'description' => $description,
            'type' => $type,
            'price' => $price,
            'status' => $status
        ], [
            'name' => 'required|unique:items,name,' . $id . ',id,deleted_at,NULL',
            'description' => 'required',
            'type' => 'required|numeric|in:1,2',
            'price' => 'required|numeric',
            'status' => 'required|numeric|in:0,1'
        ]);
        ////////////////////////
        if ($validator->fails())
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), $validator->messages()->first(), null,null);
        }
        //////////////////////////////////////////////////////////
        $update = $item->updateItem($info, $name, $description, $type, $price, $status);
        if (!$update)
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), trans('messages.error'), null,null);
        }
        return $this->respondGeneral(true, 200, trans('alert.success'), trans('messages.updated'), null, $update);
    }
    //////////////////////////////
    public function getDelete($id)
    {
        $id = $this->decrypt($id);
        ///////////////////////////
        $item = new Item();
        $info = $item->getItem($id);
        if (!$info)
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), trans('messages.not_found'), null,null);
        }
        $delete = $item->deleteItem($info);
        if (!$delete)
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), trans('messages.error'), null,null);
        }
        return $this->respondGeneral(true, 200, trans('alert.success'), trans('messages.deleted'), null,null);
    }
    ///////////////////////////////////
    public function postItemInfo(Request $request)
    {
        $item_id = $request->get('item_id');
        ////////////////////////////////
        $item = new Item();
        $info = $item->getItemInfo($item_id);

        return response()->json(['status' => 'success', 'message' => null, 'items' => $info]);
    }
}