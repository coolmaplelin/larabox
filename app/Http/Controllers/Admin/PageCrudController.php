<?php 

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\Admin\PageStoreCrudRequest as StoreRequest;
use App\Http\Requests\Admin\PageUpdateCrudRequest as UpdateRequest;

class PageCrudController extends CrudController {

	public function setup() {
        $this->crud->setModel("App\Models\Page");
        $this->crud->setRoute("admin/page");
        $this->crud->setEntityNameStrings('page', 'pages');

        $this->crud->addFilter([ // dropdown filter
            'name' => 'is_live',
            'type' => 'dropdown',
            'label'=> 'Live'
        ], [
          0 => 'No',
          1 => 'Yes',
        ], function($value) { // if the filter is live
            $this->crud->addClause('where', 'is_live', $value);
        });

        $this->crud->setColumns([
        	[
	            'name' => 'name',
	            'label' => 'Page Name',
            ],
            [
	            'name' => 'slug',
	            'label' => 'Slug',
            ],
            [
                'name' => 'is_live',
                'label' => 'Live',
                'type' => 'boolean',
            ],
    	]);

        $this->crud->removeButtonFromStack('update', 'line');
        $this->crud->removeButtonFromStack('delete', 'line');
        $this->crud->addButton('line', 'update', 'view', 'crud::buttons.update', 'end');
        $this->crud->addButton('line', 'gallery', 'view', 'crud::buttons.fileupload', 'end');
        $this->crud->addButton('line', 'delete', 'view', 'crud::buttons.delete', 'end');
        //$this->crud->setButtonsOrder('line', ['edit', 'gallery', 'delete']);

        $this->crud->addFields([
			[
	            'name'  => 'name',
	            'label' => 'Page name',
	            'type'  => 'text',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
                'tab' => 'Page Detail'
	        ],
            [
                'name'  => 'title',
                'label' => 'Page title',
                'type'  => 'text',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
                'tab' => 'Page Detail'
            ],
            [
                'name'  => 'parent_id',
                'label' => 'Parent',
                'type'  => 'parent_selector',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-12 has-clear',
                ],
                'tab' => 'Page Detail',
                'hint' => 'Expand blow page tree to select a parent page',
                'data_source' => '/api/pages.json'
            ],
            [
                'name' => 'content',
                'label' => 'Content',
                'type' => 'wysiwyg',
                'placeholder' => 'Your content here',
                'tab' => 'Page Detail'
            ],
	        [
	            'name'  => 'is_live',
	            'label' => 'Live',
	            'type'  => 'checkbox_toggle',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
                'tab' => 'Page Status'
	        ],
	        [   // DateTime
                'name' => 'published_at',
                'label' => 'Published At',
                'type' => 'datetime_picker',
                // optional:
                'datetime_picker_options' => [
                    'format' => 'DD/MM/YYYY HH:mm',
                    'language' => 'en'
                ],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
                'tab' => 'Page Status'
            ],
            [
                'name' => 'meta_title',
                'label' => 'Meta Title',
                'type' => 'text',
                'tab' => 'Metas'
            ],
            [
                'name' => 'meta_description',
                'label' => 'Meta Description',
                'type' => 'textarea',
                'tab' => 'Metas'
            ],
            // [   // Upload
            //     'name' => 'gallery',
            //     'label' => 'Gallery Images',
            //     'type' => 'jquery_file_upload',
            //     'tab' => 'Gallery Images'
            // ],
            
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

    public function gallery($id)
    {
        $this->crud->hasAccessOrFail('update');

        // get the info for that entry
        $this->data['entry'] = $this->crud->getEntry($id);
        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = $this->getSaveAction();
        $this->data['fields'] = $this->crud->getUpdateFields($id);
        $this->data['title'] = trans('backpack::crud.edit').' '.$this->crud->entity_name;

        $this->data['id'] = $id;


        return view('admin.page.gallery', $this->data);
        //return view($this->crud->getEditView(), $this->data);
    }
}