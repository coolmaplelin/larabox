<?php 

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\Admin\UserStoreCrudRequest as StoreRequest;
use App\Http\Requests\Admin\UserUpdateCrudRequest as UpdateRequest;

class UserCrudController extends CrudController {

	public function setup() {
        $this->crud->setModel("App\Models\User");
        $this->crud->setRoute("admin/user");
        $this->crud->setEntityNameStrings('user', 'users');

        //$this->crud->setColumns(['first_name', 'last_name', 'email']);
        $this->crud->setColumns([
        	[
	            'name' => 'first_name',
	            'label' => 'First Name',
            ],
            [
	            'name' => 'last_name',
	            'label' => 'Last Name',
            ],
            [
	            'name' => 'email',
	            'label' => 'email',
            ],
    	]);
        

        $this->crud->addFields([
			[
	            'name'  => 'first_name',
	            'label' => 'First name',
	            'type'  => 'text',
                'tab' => 'User Detail'
	        ],
	        [
	            'name'  => 'last_name',
	            'label' => 'Last name',
	            'type'  => 'text',
                'tab' => 'User Detail'
	        ],
	        [
                'name'  => 'email',
                'type'  => 'email',
                'tab' => 'User Detail'
            ],
            [ 
                'name' => 'account_type',
                'label' => "Account Type",
                'type' => 'select_from_array',
                'options' => config('constants.users_account_type'),
                'allows_null' => false,
                'tab' => 'Access'
            ],
            [
                'name'  => 'password',
                'type'  => 'password',
                'hint' => 'Leave it if you don\'t want to change. ',
                'tab' => 'Access'
            ],
            [
                'name'  => 'phone',
                'label' => 'Phone',
                'type'  => 'text',
                'tab' => 'Other'
            ],
            [ 
                'name' => "photo",
                'label' => "Profile Image",
                'type' => 'image',
                'upload' => true,
                'crop' => true, // set to true to allow cropping, false to disable
                'aspect_ratio' => 1, // ommit or set to 0 to allow any aspect ratio
                'tab' => 'Other'
            ]
		]);
    }

	public function store(StoreRequest $request)
	{
		$this->crud->hasAccessOrFail('create');

        // insert item in the db
        if ($request->input('password')) {
            $item = $this->crud->create(\Request::except(['save_action']));

            // now bcrypt the password
            $item->password = bcrypt($request->input('password'));
            $item->save();
        } else {
            $item = $this->crud->create(\Request::except(['save_action', 'password']));
        }

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // redirect the user where he chose to be redirected
        switch (\Request::input('save_action')) {
            case 'save_and_edit':
                return \Redirect::to($this->crud->route.'/'.$item->id.'/edit');
            case 'save_and_new' :
                return \Redirect::to($this->crud->route.'/create');
            default:
                return \Redirect::to($this->crud->route);
        }

		//return parent::storeCrud();
	}

	public function update(UpdateRequest $request)
	{
		//encrypt password and set it to request
        $this->crud->hasAccessOrFail('update');

        $dataToUpdate = \Request::except(['save_action', 'password']);

        //encrypt password
        if ($request->input('password')) {
            $dataToUpdate['password'] = bcrypt($request->input('password'));
        }

        // update the row in the db
        $this->crud->update(\Request::get('id'), $dataToUpdate);

        // show a success message
        \Alert::success(trans('backpack::crud.update_success'))->flash();

        return \Redirect::to($this->crud->route);
        
		//return parent::updateCrud();
	}
}