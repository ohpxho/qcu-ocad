$(document).ready(function() {
	tinymce.init({
	    selector: 'textarea[name="problem"]',
	    plugins: [
	      'checklist','lists'
	    ],
	    toolbar: 'bullist numlist checklist outdent indent',
	    menubar: false
  	});
});