function redirectIfDataIsFound(type) {
	const ID = localStorage.getItem('alumni-student-id');

	switch(type) {
		case 'PAGE_IN_INITIAL':
			if(ID != null) window.location.assign("<?php echo URLROOT.'/alumni/profile' ?>");
			break;		
		case 'PAGE_IN_MAIN':
			if(ID == null) window.location.assign("<?php echo URLROOT.'/alumni/index' ?>");
			break;
	}	
}