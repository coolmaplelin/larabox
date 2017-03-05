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
            //     'type' => 'textarea',
            //     'tab' => 'Gallery Images'
            // ],
            
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

	public function update(StoreRequest $request)
	{
		//encrypt password and set it to request
        $this->crud->hasAccessOrFail('update');

        $dataToUpdate = \Request::except(['save_action']);

        
        // update the row in the db
        $this->crud->update(\Request::get('id'), $dataToUpdate);

        // show a success message
        \Alert::success(trans('backpack::crud.update_success'))->flash();

        return \Redirect::to($this->crud->route);
        
		//return parent::updateCrud();
	}
}