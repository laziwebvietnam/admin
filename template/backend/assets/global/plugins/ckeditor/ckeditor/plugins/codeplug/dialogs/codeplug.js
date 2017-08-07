/**
 * The abbr dialog definition.
 *
 * Created out of the CKEditor Plugin SDK:
 * http://docs.ckeditor.com/#!/guide/plugin_sdk_sample_1
 */

// Our dialog definition.
CKEDITOR.dialog.add( 'codeplugDialog', function( editor ) {
	return {

		// Basic properties of the dialog window: title, minimum size.
		title: 'Code plugin PHP/C#/JS/CSS/HTML',
		minWidth: 400,
		minHeight: 200,

		// Dialog window contents definition.
		contents: [
			{
				// Definition of the Basic Settings dialog tab (page).
				id: 'tab-basic',
				label: 'Basic Settings',

				// The tab contents.
				elements: [
					{
						// Text input field for the abbreviation text.
						type: 'text',
						id: 'title',
						label: 'Title',

						// Validation checking whether the field is not empty.
						validate: CKEDITOR.dialog.validate.notEmpty( "Please type file path/name ^^!" ),

						// Called by the main setupContent call on dialog initialization.
						setup: function( element ) {
							this.setValue( element.getAttribute( "title" ));
						},

						// Called by the main commitContent call on dialog confirmation.
						commit: function( element ) {
							element.setAttribute( "title",this.getValue());
						}
					},
					{
						// Text input field for the abbreviation title (explanation).
						type: 'textarea',
						id: 'codeplug',
						label: 'Code',
						validate: CKEDITOR.dialog.validate.notEmpty( "Code Cannot empty" ),

						// Called by the main setupContent call on dialog initialization.
						setup: function( element ) {
							this.setValue(element.getText());
						},

						// Called by the main commitContent call on dialog confirmation.
						commit: function( element ) {
							element.setText(this.getValue());
						}
					}
				]
			}
		],

		// Invoked when the dialog is loaded.
		onShow: function() {

			// Get the selection in the editor.
			var selection = editor.getSelection();

			// Get the element at the start of the selection.
			var element = selection.getStartElement();

			// Get the <code> element closest to the selection, if any.
			if ( element )
				element = element.getAscendant( 'code', true );

			// Create a new <abbr> element if it does not exist.
			if ( !element || element.getName() != 'code' ) {
				element = editor.document.createElement( 'code' );

				// Flag the insertion mode for later use.
				this.insertMode = true;
			}
			else
				this.insertMode = false;

			// Store the reference to the <code> element in an internal property, for later use.
			this.element = element;

			// Invoke the setup methods of all dialog elements, so they can load the element attributes.
			if ( !this.insertMode )
				this.setupContent( this.element );
		},

		// This method is invoked once a user clicks the OK button, confirming the dialog.
		onOk: function() {

			// The context of this function is the dialog object itself.
			// http://docs.ckeditor.com/#!/api/CKEDITOR.dialog
			var dialog = this;

			// Creates a new <abbr> element.
			var abbr = this.element;
            
			// Invoke the commit methods of all dialog elements, so the <abbr> element gets modified.
			this.commitContent( abbr );

			// Finally, in if insert mode, inserts the element at the editor caret position.
			if ( this.insertMode )
				editor.insertElement( abbr );
		}
	};
});