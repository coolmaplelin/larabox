<?php 

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;


class CustomFormEntryCrudController extends CrudController {

	public function setup() {
        $this->crud->setModel("App\Models\CustomFormEntry");
        $this->crud->setRoute("admin/customformentry");
        $this->crud->setEntityNameStrings('custom form entry', 'custom form entries');

        $this->crud->addFilter([ 
            'name' => 'form_id',
            'type' => 'select2',
            'label'=> 'Form',
        ], function() {
            return \App\Models\CustomForm::all()->pluck('name', 'id')->toArray();
        }, function($value) { 
            $this->crud->addClause('where', 'form_id', $value);
        });

        $this->crud->allowAccess('view');
        $this->crud->denyAccess(['create', 'update']);
        $this->crud->addButton('line', 'view', 'view', 'crud::buttons.view', 'beginning');

        $this->crud->setColumns([
        	[  // Select
               'label' => "Form",
               'type' => 'select',
               'name' => 'form_id', // the db column for the foreign key
               'entity' => 'custom_form', // the method that defines the relationship in your Model
               'attribute' => 'name', // foreign key attribute that is shown to user
               'model' => "App\Models\CustomForm" // foreign key model
            ],
            [
                'name' => 'is_actioned',
                'label' => 'Actioned',
                'type' => 'boolean',
            ],
            [
                'name' => 'created_at',
                'label' => 'Created At',
                'type' => 'datetime',
            ],
    	]);

    }


    public function view($id)
    {
        $this->crud->hasAccessOrFail('view');

        // get the info for that entry
        $this->data['entry'] = $this->crud->getEntry($id);
        $this->data['crud'] = $this->crud;
        $this->data['title'] = 'View '.$this->crud->entity_name;

        $this->data['id'] = $id;

        $this->data['form_fields'] = json_decode($this->data['entry']->form_fields, true);

        return view('admin.custom_form_entry.view', $this->data);
        //return view($this->crud->getEditView(), $this->data);
    }
}