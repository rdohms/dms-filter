# DMS Filter Bundle

This bundle makes DMS/Filter available for use in your application for input filtering.

## Install

### 1. Impor libraries  

Option A) Use the vendors script.

Add this to the `deps` file.

	[DMSFilterBundle]
	    git=https://github.com/rdohms/DMSFilterBundle.git
	    target=/bundles/DMS/Bundles/FilterBundle
	
    [DMSFilter]
        git=https://github.com/rdohms/DMS-Filter.git
        target=/DMS/Filter

Option B) Use submodules

	git submodule add https://github.com/rdohms/DMSFilterBundle.git /bundles/DMS/Bundles/FilterBundle
    git submodule add https://github.com/rdohms/DMS-Filter.git /DMS/Filter
    git submodule update --init

### 2. Prepare the autoloader

Add this to `autoload.php`

	'DMS' => __DIR__.'/../src',

### 3. Enable Bundle

Add this to your `AppKernel.php`

	new DMS\Bundles\FilterBundle\DMSFilterBundle(),

### 4. Configure

...

## Usage

Use the `dms.filter` service along with annotations in the Entity to filter data.

	public function indexAction()
	{
        
	    $entity = new \Acme\DemoBundle\Entity\SampleEntity();
	    $entity->name = "My <b>name</b>";
	    $entity->email = " email@mail.com";
        
	    $oldEntity = clone $entity;
        
	    $filterService = $this->get('dms.filter');
	    $filterService->filter($entity);
        
	    return array('entity' => $entity, "old" => $oldEntity);
	}

To add annotations to your entity, import the namespace and add them like this:

	<?php

	namespace App\Entity;

	//Import Annotations
	use DMS\Filter\Rules as Filter;

	class User
	{

		/**
		* @Filter\StripTags()
		* @Filter\Trim()
		* @Filter\StripNewlines()
		*
		* @var string
		*/
		public $name;
	
		/**
		* @Filter\StripTags()
		* @Filter\Trim()
		* @Filter\StripNewlines()
		*
		* @var string
		*/
		public $email;

	}    