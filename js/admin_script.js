/**
=== Grid WUD ===
Contributors: wistudat.be
Plugin Name: Grid WUD
Description: Adds 100% responsive, customizable and dynamic grids to WordPress posts and pages.
Author: Danny WUD
Author URI: http://wistudat.be/
 */
 jQuery(document).ready(function($){

  var mediaUploader;

  $('#upload-button').click(function(e) {
    e.preventDefault();
    // If the uploader object has already been created, reopen the dialog
      if (mediaUploader) {
      mediaUploader.open();
      return;
    }
    // Extend the wp.media object
    mediaUploader = wp.media.frames.file_frame = wp.media({
      title: 'Choose Image',
      button: {
      text: 'Choose Image'
    }, multiple: false });

    // When a file is selected, grab the URL and set it as the text field's value
    mediaUploader.on('select', function() {
      attachment = mediaUploader.state().get('selection').first().toJSON();
	  $('#image-src').attr('src', attachment.url);
	  $('#image-url').val(attachment.url);
    });
    // Open the uploader dialog 
    mediaUploader.open();
  });
  
  $('#clear-button').click(function(e) {  
	$('#image-src').attr('src', '../wp-content/plugins/grid-wud//images/empty-grid.png');
	$('#image-url').val('');
  });
});