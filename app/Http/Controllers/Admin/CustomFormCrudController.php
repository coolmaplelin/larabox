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
                'name' => 'thankyou_title',
                'label' => 'Thankyou Title',
                'type'  => 'text',
                'tab' => 'Form Details',
            ],
            [
                'name' => 'thankyou_content',
                'label' => 'Thankyou Content',
                'type' => 'wysiwyg',
                'placeholder' => 'Your content here',
                'tab' => 'Form Details',
            ],
            [
                'name' => 'form_fields',
                'label' => 'Fields',
                'type'  => 'form_fields_panel',
                'tab' => 'Form Elements',
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

        return \Redirect::to($this->crud->route);
        
		//return parent::updateCrud();
	}

}