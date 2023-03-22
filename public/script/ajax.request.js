function getRequestDetails(id) {
   return $.ajax({
       url: "/qcu-ocad/academic_document/details",
       type: "POST",
       data: {
           id: id
       }
   });
}

function getAcademicDocumentRequestCount() {
   return $.ajax({
        url: "/qcu-ocad/academic_document/get_requests_count",
        type: "GET",
        data: {}
    });
}

function getGoodMoralRequestCount() {
   return $.ajax({
        url: "/qcu-ocad/good_moral/get_requests_count",
        type: "GET",
        data: {}
    });
}

function getGuidanceConsultationRequestCount() {
   return $.ajax({
        url: "/qcu-ocad/consultation/get_guidance_request_count",
        type: "GET",
        data: {}
    });
}

function getClinicConsultationRequestCount() {
   return $.ajax({
        url: "/qcu-ocad/consultation/get_clinic_request_count",
        type: "GET",
        data: {}
    });
}


function getProfessorConsultationRequestCount(id) {
   return $.ajax({
        url: "/qcu-ocad/consultation/get_professor_request_count",
        type: "POST",
        data: {id}
    });
}


function getSOARequestCount() {
   return $.ajax({
        url: "/qcu-ocad/student_account/get_requests_count",
        type: "GET",
        data: {}
    });
}


function checkAllConsultationsIfHasUnseenMessage(user, role) {
   return $.ajax({
        url: "/qcu-ocad/consultation/check_all_consultation_if_has_unseen_messages",
        type: "POST",
        data: { id: user, role: role }
    });
}

function checkConsultationIfHasUnseenMessage(consultation, user) {
   return $.ajax({
        url: "/qcu-ocad/consultation/check_consultation_if_has_unseen_messages",
        type: "POST",
        data: { consultation, user }
    });
}

 function getAlumniById(id) {
   return $.ajax({
        url: "/qcu-ocad/alumni/get_alumni_by_id",
        type: "POST",
        data: { id }
   });
 }

 function addAlumni(details) {
     return $.ajax({
          url: "/qcu-ocad/alumni/add",
          type: "POST",
          data: details,
          contentType: false,
          processData: false
     });
 }

 function editAlumniDocumentRequest(details) {
    return $.ajax({
          url: "/qcu-ocad/alumni/edit_request",
          type: "POST",
          data: details,
          contentType: false,
          processData: false
     });  
 }

 function cancelAlmuniDocumentRequest(id) {
    return $.ajax({
          url: "/qcu-ocad/alumni/cancel_request",
          type: "POST",
          data: {id}
     });  
 }

 function getAllActivitiesByActorAndActionAndYear(details) {
    return $.ajax({
          url: "/qcu-ocad/activity/get_all_activities_by_actor_year_action",
          type: "POST",
          data: details,
          async: false
     });
 }

 function getAllDocumentActivitiesByActorAndActionAndYear(details) {
    return $.ajax({
        url: "/qcu-ocad/activity/get_all_document_activities_by_actor_year_action",
        type: "POST",
        data: details,
        async: false
    });
 }

 function getAllActivitiesByActorAndYear(details) {
    return $.ajax({
        url: "/qcu-ocad/activity/get_all_activities_by_actor_year",
        type: "POST",
        data: details,
        async: false
    });  
 }

 function getRequestFrequencyOfAlumni(id) {
    return $.ajax({
        url: `/qcu-ocad/alumni/get_request_frequency/${id}`,
        type: "GET",
        async: false
    });  
 }

 function getRequestAvailabilityOfAlumni(id) {
    return $.ajax({
        url: `/qcu-ocad/alumni/get_request_availability/${id}`,
        type: "GET",
        async: false
    });  
 }

 function updateAlumniProfile(details) {
    return $.ajax({
          url: "/qcu-ocad/alumni/profile",
          type: "POST",
          data: details,
          contentType: false,
          processData: false
     });  
 }

 function getStudentDetails(id) {
    return $.ajax({
        url: "/qcu-ocad/user/get_student_details",
        type: "POST",
        data: { id }
    });
 }

 function getAlumniDetails(id) {
    return $.ajax({
        url: "/qcu-ocad/user/get_alumni_details",
        type: "POST",
        data: { id }
    });  
 }


 function getAdminDetails(id) {
    return $.ajax({
        url: "/qcu-ocad/user/get_admin_details",
        type: "POST",
        data: { id }
    });  
 }

 function getProfessorDetails(id) {
    return $.ajax({
        url: "/qcu-ocad/user/get_professor_details",
        type: "POST",
        data: { id }
    });  
 }

 function validateStudentAccountDetails(details) {
    return $.ajax({
        url: "/qcu-ocad/student/validate_account_details",
        type: "POST",
        data: details,
        contentType: false,
        processData: false
    });
}

function validateStudentPersonalDetails(details) {
    return $.ajax({
        url: "/qcu-ocad/student/validate_personal_details",
        type: "POST",
        data: details,
        contentType: false,
        processData: false
    });
}


 function validateAlumniAccountDetails(details) {
    return $.ajax({
        url: "/qcu-ocad/alumni/validate_account_details",
        type: "POST",
        data: details,
        contentType: false,
        processData: false
    });
}

function validateAlumniPersonalDetails(details) {
    return $.ajax({
        url: "/qcu-ocad/alumni/validate_personal_details",
        type: "POST",
        data: details,
        contentType: false,
        processData: false
    });
}

function getStudentDetails(id) {
    return $.ajax({
        url: "/qcu-ocad/student/details",
        type: "POST",
        data: {
            id: id
        }
    });
}

function getAlumniDetails(id) {
    return $.ajax({
        url: "/qcu-ocad/alumni/details",
        type: "POST",
        data: {
            id: id
        }
    });
}