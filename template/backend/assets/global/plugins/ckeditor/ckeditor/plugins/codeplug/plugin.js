/**
 * Basic sample plugin inserting abbreviation elements into CKEditor editing area.
 *
 * Created out of the CKEditor Plugin SDK:
 * http://docs.ckeditor.com/#!/guide/plugin_sdk_sample_1
 */

// Register the plugin within the editor.
CKEDITOR.plugins.add( 'codeplug', {

	// Register the icons.
	icons: 'codeplug',

	// The plugin initialization logic goes inside this method.
	init: function( editor ) 
    {

		// Define an editor command that opens our dialog.
		editor.addCommand( 'codeplug', new CKEDITOR.dialogCommand( 'codeplugDialog' ) );

		// Create a toolbar button that executes the above command.
		editor.ui.addButton( 'Codeplug', {
			// The text part of the button (if available) and tooptip.
			label: 'Chèn code',

			// The command to execute on click.
			command: 'codeplug',
		});
		if ( editor.contextMenu ) 
        {
			editor.addMenuGroup( 'codeplugGroup' );
			editor.addMenuItem( 'codeplugItem', {
				label: 'codeplug',
				icon: this.path + 'icons/codeplug.png',
				command: 'codeplug',
				group: 'codeplugGroup'
			});

			editor.contextMenu.addListener( function( element ) {
				if ( element.getAscendant( 'codeplug', true ) ) {
					return { abbrItem: CKEDITOR.TRISTATE_OFF };
				}
			});
		}

		// Register our dialog file. this.path is the plugin folder path.
		CKEDITOR.dialog.add( 'codeplugDialog', this.path + 'dialogs/codeplug.js' );
	}
});

