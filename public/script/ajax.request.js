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

function getProfessorConsultationRequestCount(id) {
   return $.ajax({
        url: "/qcu-ocad/consultation/get_professor_request_count",
        type: "POST",
        data: {id}
    });
}


function getSOARequestCount() {
   return $.ajax({
        url: "/qcu-ocad/soa_and_order_of_payment/get_requests_count",
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

 