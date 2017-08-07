/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
    config.toolbar=[
        ['Source','Save','Preview','Find','Replace','-','SelectAll','RemoveFormat',        
        'Bold','Italic','Underline','NumberedList','BulletedList','-','Outdent','Indent'],
        ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','Link','Unlink','HorizontalRule','Smiley','Maximize'],
        ['Image','Flash','Table','Styles','Format','Font','FontSize','TextColor','BGColor','Blockquote']
    ];
};
