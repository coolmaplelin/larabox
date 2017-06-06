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
        // your additional operations before save here
        $redirect_location = parent::storeCrud();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

 }