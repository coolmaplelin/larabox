<?php 

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\Admin\CustomFormStoreCrudRequest as StoreRequest;
use App\Http\Requests\Admin\CustomFormStoreCrudRequest as UpdateRequest;

class CustomFormCrudController extends CrudController {

	public function setup() {
        $this->crud->setModel("App\Models\CustomForm");
        $this->crud->setRoute("admin/customform");
        $this->crud->setEntityNameStrings('custom form', 'custom forms');

        $this->crud->addButton('line', 'view entry', 'view', 'admin.custom_form.buttons.view_entry', 'beginning');

        $this->crud->setColumns([
        	[
	            'name' => 'name',
	            'label' => 'Form Name',
            ],
            [
	            'name' => 'slug',
	            'label' => 'Slug',
            ],
            [
                'name' => 'active',
                'label' => 'Active',
                'type' => 'boolean',
            ],
    	]);

        $this->crud->addFields([
            [
                'name'  => 'name',
                'label' => 'Form name',
                'type'  => 'text',
                'tab' => 'Form Details',
            ],
            [
                'name'  => 'active',
                'label' => 'Active',
                'type'  => 'checkbox_toggle',
                'tab' => 'Form Details',
            ],
            [
                'name' => 'emails',
                'label' => 'Emails',
                'type'  => 'textarea',
                'hint' => 'Supports multiple emails',
                'tab' => 'Form Details',
            ],
            [
                'name' => 'instructions',
                'label' => 'Instructions',
                'type'  => 'wysiwyg',
                'tab' => 'Form Details',
            ],
            [
                'name' => 'form_fields',
                'label' => 'Fields',
                'type'  => 'form_fields_panel',
                'tab' => 'Form Elements',
            ],
            [
                'name' => 'thankyou_title',
                'label' => 'Thankyou Title',
                'type'  => 'text',
                'tab' => 'Thankyou Page',
            ],
            [
                'name' => 'thankyou_content',
                'label' => 'Thankyou Content',
                'type' => 'wysiwyg',
                'placeholder' => 'Your content here',
                'tab' => 'Thankyou Page',
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