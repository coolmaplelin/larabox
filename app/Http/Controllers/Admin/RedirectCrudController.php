<?php 

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\Admin\RedirectStoreCrudRequest as StoreRequest;
use App\Http\Requests\Admin\RedirectStoreCrudRequest as UpdateRequest;

class RedirectCrudController extends CrudController {

	public function setup() {
        $this->crud->setModel("App\Models\Redirect");
        $this->crud->setRoute("admin/redirect");
        $this->crud->setEntityNameStrings('redirect', 'redirects');

        $this->crud->addFilter([ // dropdown filter
            'name' => 'type',
            'type' => 'dropdown',
            'label'=> 'Type'
        ], [
          'system' => 'System',
          'original' => 'Original',
        ], function($value) { 
            $this->crud->addClause('where', 'type', $value);
        });

        $this->crud->setColumns([
        	[
	            'name' => 'type',
	            'label' => 'Type',
            ],
            [
	            'name' => 'from',
	            'label' => 'From',
            ],
            [
                'name' => 'to',
                'label' => 'To',
            ],
    	]);

        $this->crud->addFields([
			[
	            'name'  => 'type',
	            'label' => 'Type',
	            'type'  => 'select_from_array',
                'options' => ['original' => 'Original', 'system' => 'System'],
	        ],
            [
                'name'  => 'from',
                'label' => 'From URL',
                'type'  => 'text',
            ],
            [
                'name'  => 'to',
                'label' => 'To URL',
                'type'  => 'text',
            ],
		]);
    }


	public function store(StoreRequest $request)
	{
		$this->crud->hasAccessOrFail('create');

        // insert item in the db
        $item = $this->crud->create(\Request::except(['save_action']));

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

        $dataToUpdate = \Request::except(['save_action']);

        
        // update the row in the db
        $this->crud->update(\Request::get('id'), $dataToUpdate);

        // show a success message
        \Alert::success(trans('backpack::crud.update_success'))->flash();

        // redirect the user where he chose to be redirected
        switch (\Request::input('save_action')) {
            case 'save_and_edit':
                return \Redirect::to($this->crud->route.'/'.\Request::get('id').'/edit');
            case 'save_and_new' :
                return \Redirect::to($this->crud->route.'/create');
            default:
                return \Redirect::to($this->crud->route);
        }
        
		//return parent::updateCrud();
	}

 }