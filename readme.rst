###################
Reactor
###################

Reactor is a php project boilerplate built with the Code Igniter framework. Reactor helps you create a back-end CMS quickly by automatically building a web interface for your database tables. 
Reactor is meant to be the starting point for you Code Igniter projects and not to attach to existing projects.

**************************
Changelog and New Features
**************************

First public version posted to git-hub

*******************
Server Requirements
*******************

-  PHP version 5.2.4 or newer.

************
Installation
************

Please see the `installation section <http://codeigniter.com/user_guide/installation/index.html>`_
of the CodeIgniter User Guide.

************
Setup
************

This assumes that you have a working knowledge of Code Igniter. 

- Reactor works like any other CodeIgniter project. Once your project is set up, point your browser to <project url>/admin. The default login is "admin:admin". This is the base Reactor CMS.
- The idea behind reactor is to set up a back-end CMS for your project as quickly as possible. As such, you begin by defining your database Model in Reactor rather than the database itself. You will find 2 sample models in the application/Models folder: name_model.php and address_model.php. Copy either of these files and rename to begin defining your project table.
- Reactor models come with all of the basic CRUD functions written using CodeIgniter's Active Record class. Begin by editing the variables at the top of the file to suit your table structure.

::

	var $table = "tblPage";
	var $pk = "pageId";
	var $ds = "pageTimeStamp";  //Default sortby field 
	var $rq = "pageFbId";		//Required field (you'll need to mod the form validation if there isn't one)
	var $fields = array(
		 'pageFbId' => array('label'=>'Facebook Id','type'=>'varchar','constraint'=>50),
		 'pageUrl' => array('label'=>'Url','type'=>'varchar','constraint'=>200),
		 'pageLanguageCode' => array('label'=>'Language','type'=>'varchar','constraint'=>10),
		 'testId' => array('label'=>'Test','type'=>'int'),
		);
	
- All reactor tables assume a minimum of 3 fields: Id, TimeStamp, and one required field. All field names should be prefixed with the table name (the exception to this is join fields which have the same name as the id field of the table joined). This is not mandatory but is required for some CMS features.
- Once you have edited the values at the top of the model file, return to the admin console in your browser. 
- Click on the "Builder" tab. This will present you with a list of all models which do not yet have associated controllers. From the pulldown menu, select the model you just created and click the "Generate Scaffold" button.
- You should see a new tab with the same name as your model appear in the main navigation of the admin console. Reactor has automatically created your database table for you, as well as a controller and views to list, add, edit, and delete records in that table.
- Once your scaffold is generated, you are free to edit the controller and views as needed for your project. Please note that at this point any changes you make to the model must be manually done in the database.
- If you need to generate another clean scaffold, you must first delete the controller and view files associated with your model.

*********
Code Igniter Resources
*********

-  `User Guide <http://codeigniter.com/user_guide/>`_
-  `Community Forums <http://codeigniter.com/forums/>`_
-  `Community Wiki <http://codeigniter.com/wiki/>`_
-  `Community IRC <http://ellislab.com/codeigniter/irc>`_
