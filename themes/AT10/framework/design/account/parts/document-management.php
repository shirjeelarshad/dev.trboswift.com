<?php

   /* 
   * Theme: TURBOBID CORE FRAMEWORK FILE
   * Url: www.turbobid.ca
   * Author: Md Nuralam
   *
   * THIS FILE WILL BE UPDATED WITH EVERY UPDATE
   * IF YOU WANT TO MODIFY THIS FILE, CREATE A CHILD THEME
   *
   * http://codex.wordpress.org/Child_Themes
   */


?>



<div class="documentManagementBody d-none">
     <button id="closeBody" type="button" class="btn btn-light rounded-pill"
            style="position: absolute; right: 30px; top: 15px; z-index:5;"><i class="fal fa-times"></i></button>
    <div class="documentManagementContainer position-relative" style="max-height:80vh; overflow-y:scroll;">
       
        <h1 id="documentManageTitle">Upload Document</h1>
        <div class="sendDocumentSection">
            <div class="col-12">
                <div class="custom-file-drop" id="documentUploadDropArea">
                    <!-- <p>Upload document or image</p> -->
                    <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/08/Group-1321315199.svg" /><br />
                    <span class="small">Upload documents or images.</span>
                    <br />

                    <div class="text-center my-2">
                        <button class="upload-upload-btn btn btn-outline-primary px-2 py-1"
                            style="width: 130px; font-size: 12px">
                            Browse
                        </button>
                    </div>

                    <input id="documentUploadFileInput" type="file" name="files[]" style="display: none" multiple />
                    <input type="hidden" id="documentId" name="documentId">
                    <input type="hidden" id="uploadName" name="uploadName">
                </div>

                <div class="mt-3 d-flex flex-wrap py-3" id="documentInsertedPreviewContainer">
                    <div class="col-12 px-0">
                        <!-- <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/09/image-144.png"
                            style="width: 100%; height: 100%" /> -->
                    </div>
                </div>
            </div>

            <button id="submitDocumentToServer">Submit Documents</button>
        </div>
        <div class="documentViewSection" style="display: none"></div>
    </div>
</div>





<script>
jQuery(document).on('click', '.dropdown-item.upload, .dropdown-item.request', function(e) {
    e.preventDefault();

    var row = jQuery(this).closest('tr');
    var documentId = row.data('document-id');
    var uploadName = row.data('upload-name');

    // Set the document ID and name in the modal
    jQuery('#documentId').val(documentId);
    jQuery('#uploadName').val(uploadName);

    checkBoldSignDocument(documentId, uploadName);

});

function checkBoldSignDocument(documentId, uploadName) {
    var dealId = sessionStorage.getItem('@deal-entry-id');
    var formId = sessionStorage.getItem('@deal-form-id');

    

    var formData = new FormData();
    formData.append("action", "get_documents_from_server");
    formData.append("form_id", formId); // Replace with your form ID
    formData.append("entry_id", dealId);
    formData.append('documentId', documentId);
    formData.append('documentName', uploadName);
    addAdditionalDealData(formData)
        .done(function(res) {
            // Handle the response from the AJAX call
            if (res.success) {
                console.log('get_documents_from_server:', res.data);
                // alert('Successfully get Document');
                var document = Array.isArray(res.data) && res.data.length > 0 ? res.data[res.data.length - 1] :
                    null;
                console.log('get_documents_from_server: ', res.data);
                if (document.templateId != null) {
                    getBoldSignTemplateStatus(uploadName, document.templateId, document.templateUrl);
                } else {
                    createBoldSignTemplate(uploadName);
                }

            } else {
                createBoldSignTemplate(uploadName)
            }
        })
        .fail(function(error) {
            console.log("Error:", error);
            createBoldSignTemplate(uploadName)
        });
}

function createBoldSignTemplate(uploadName) {
    // Create a FormData object for multipart form submission
    var dealId = sessionStorage.getItem('@deal-entry-id');
    var formId = sessionStorage.getItem('@deal-form-id');
    var meta = JSON.parse(sessionStorage.getItem('@deal-data' + dealId));

    console.log('meta keys', JSON.stringify(meta));

    var formData = new FormData();
    formData.append('action', 'boldsign_request'); // Action for WordPress AJAX handler
    formData.append('uploadName', uploadName);
    formData.append('meta', JSON.stringify(meta)); // Serialize meta object to JSON

    // Send AJAX request to WordPress backend
    jQuery.ajax({
        url: '<?php echo admin_url('admin-ajax.php'); ?>', // This is automatically available in WordPress for admin-ajax.php
        type: 'POST',
        processData: false, // Important for FormData to work properly
        contentType: false, // Important for FormData to work properly
        data: formData,
        success: function(response) {
            console.log('Response from backend:', response);
            if (response.success) {
                var documentId = response.data.documentId;
                var sendUrl = response.data.sendUrl;
                // console.log('Document ID:', documentId, 'Send URL:', sendUrl);

                // Example function to use the documentId and URL
                if (documentId && sendUrl) {
                    submitBoldSignTemplate(documentId, sendUrl);
                }
            } else {
                console.error('Error from backend:', response.data);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', error);
        }
    });
}

function getBoldSignTemplateStatus(uploadName, boldDocumentId, templateUrl) {
    // Create a FormData object for multipart form submission
    var formData = new FormData();
    formData.append('action', 'boldsign_get_document_status'); // Action for WordPress AJAX handler
    formData.append('boldDocumentId', boldDocumentId);

    // Send AJAX request to WordPress backend
    jQuery.ajax({
        url: '<?php echo admin_url('admin-ajax.php'); ?>', // Use the WordPress ajaxurl variable
        type: 'POST',
        processData: false, // Important for FormData to work properly
        contentType: false, // Important for FormData to work properly
        data: formData,
        success: function(response) {
            console.log('Response from backend:', response);
            if (response.success) {
                var status = response.data.status;
                if (status === "Draft") {
                    openBoldSignModal(templateUrl);
                } else if (status === "InProgress") {
                    getBoldSignTemplateAndDownload(boldDocumentId)
                } else {
                    alert(uploadName + ' status is: ' + status);
                }

            } else {
                console.error('Error from backend:', response.data.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', error);
        }
    });
}



function submitBoldSignTemplate(templateId, templateUrl) {
    {

        var entryId = sessionStorage.getItem('@deal-entry-id');
         var formId = sessionStorage.getItem('@deal-form-id');

        var documentId = jQuery('#documentId').val();
        var documentName = jQuery('#uploadName').val();

        var formData = new FormData();
        formData.append("action", "submit_document_deal");
        formData.append("form_id", formId); // Replace with your form ID
        formData.append("entry_id", entryId); // Replace with your entry ID
        formData.append("data_meta", "deal_client_document");
        formData.append('form_name', 'Client Deal Document');
        formData.append('form_title', 'Client Deal ' + documentName + ' Document Submit');
        formData.append('documentId', documentId);
        formData.append('documentName', documentName);
        formData.append('templateId', templateId);
        formData.append('templateUrl', templateUrl);

        addAdditionalDealData(formData)
            .done(function(res) {
                jQuery('#loadingSpinner').hide();
                console.log('Response from backend:', res);
                // Handle the response from the AJAX call
                openBoldSignModal(templateUrl);
                changeDocumentStatus(documentId, documentName);
            })
            .fail(function(error) {
                console.log('Error updated seal information', error)
            });


    }
}


function openBoldSignModal(url) {
    // Hide the document management title
    jQuery('.documentManagementBody #documentManageTitle').hide();

    // Adjust modal container classes for full-screen view
    jQuery('.documentManagementBody .documentManagementContainer')
        .removeClass('p-3 customModalWidthHalf')
        .addClass('p-0 border-0 customModalWidthFull');

    // Hide the send document section and show the document view section
    jQuery('.documentManagementBody .sendDocumentSection')
        .removeClass('d-block')
        .addClass('d-none');

    jQuery('.documentManagementBody .documentViewSection')
        .removeClass('d-none')
        .addClass('d-block');

    // Inject the iframe into the documentViewSection with the provided URL
    jQuery('.documentManagementBody .documentViewSection').html(`
        <iframe id="documentViewer" width="100%" height="100%"  style="min-height: 80vh;"
                src="${url}" frameborder="0" 
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                allowfullscreen>
        </iframe>
    `);

    // Fix the close button's position
    jQuery('.documentManagementBody #closeBody').css({
        'top': 'auto',
        'bottom': '13px'
    });

    // Make the modal body visible by changing its display class
    jQuery('.documentManagementBody').removeClass('d-none').addClass('d-flex');
}


function changeDocumentStatus(docId, fileName) {
    jQuery('tr').each(function() {
        var row = jQuery(this);
        var documentId = row.data('document-id');
        var uploadName = row.data('upload-name');

        // Match document by ID and name
        if (docId == documentId && fileName === uploadName) {
            // If document is completed, update the status cell

            row.find('.doc-row-status').html(
                '<span class="turbo-success font-10 px-2 py-1 rounded-pill"><i class="fas fa-circle small mr-2"></i>Completed</span>'
            );

        }
    });
}




jQuery(document).on('click', '.dropdown-item.view-doc', function(e) {
    e.preventDefault();

    var row = jQuery(this).closest('tr');
    var documentId = row.data('document-id');
    var documentName = row.data('upload-name');

    // Set the document ID and name in the modal
    var paperwork = false;

    checkServerGetBoldSignDocumentFile(documentId, documentName, paperwork);

    // checkBoldSignDocument(documentId, uploadName)

});

jQuery(document).on('click', '.dropdown-item.view-paperwork-doc', function(e) {
    e.preventDefault();

    var row = jQuery(this).closest('tr');
    var documentId = row.data('document-id');
    var documentName = row.data('upload-name');

    // Set the document ID and name in the modal
    var paperwork = true;

    checkServerGetBoldSignDocumentFile(documentId, documentName, paperwork);

    // checkBoldSignDocument(documentId, uploadName)

});


function checkServerGetBoldSignDocumentFile(documentId, uploadName, paperwork) {
    var dealId = sessionStorage.getItem('@deal-entry-id');
    var formId = sessionStorage.getItem('@deal-form-id');

    var formData = new FormData();
    formData.append("action", "get_documents_from_server");
    formData.append("form_id", formId); // Replace with your form ID
    formData.append("entry_id", dealId);
    formData.append('documentId', documentId);
    formData.append('documentName', uploadName);
    addAdditionalDealData(formData)
        .done(function(res) {
            // Handle the response from the AJAX call
            if (res.success) {
                // alert('Successfully get Document');
                var document = Array.isArray(res.data) && res.data.length > 0 ? res.data[res.data.length - 1] :
                    null;
                console.log('get_documents_from_server:', res.data);

                if (document.templateId != null) {
                    getBoldSignTemplateAndDownload(document.templateId);
                } else if (!paperwork) {
                    createBoldSignTemplate(uploadName);
                } else {
                    alert('Error get document : ' + res.error);
                }
            } else {
                alert('Error get document : ' + res.error);
            }
        })
        .fail(function(error) {
            console.log("Error:", error);

        });
}


function getBoldSignTemplateAndDownload(boldDocumentId) {
    // Create a FormData object for multipart form submission
    var formData = new FormData();
    formData.append('action', 'boldsign_get_document_download'); // Action for WordPress AJAX handler
    formData.append('boldDocumentId', boldDocumentId);

    // Send AJAX request to WordPress backend
    jQuery.ajax({
        url: '<?php echo admin_url('admin-ajax.php'); ?>', // Use the WordPress ajaxurl variable
        type: 'POST',
        processData: false, // Important for FormData to work properly
        contentType: false, // Important for FormData to work properly
        data: formData,
        success: function(response) {
            console.log('Response from backend:', response);
            if (response.success) {
                // Open the document in an iframe
                openPdfForBoldSignModal(response.data.base64Pdf);
            } else {
                console.error('Error from backend:', response.data.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', error);
        }
    });
}


function openPdfForBoldSignModal(pdf) {
    // Hide the document management title
    jQuery('.documentManagementBody #documentManageTitle').hide();

    // Adjust modal container classes for full-screen view
    jQuery('.documentManagementBody .documentManagementContainer')
        .removeClass('p-3 customModalWidthHalf')
        .addClass('p-0 border-0 customModalWidthFull');

    // Hide the send document section and show the document view section
    jQuery('.documentManagementBody .sendDocumentSection')
        .removeClass('d-block')
        .addClass('d-none');

    jQuery('.documentManagementBody .documentViewSection')
        .removeClass('d-none')
        .addClass('d-block');

    // Inject the iframe into the documentViewSection with the provided PDF
    jQuery('.documentManagementBody .documentViewSection').html(`
        <iframe src="data:application/pdf;base64,${pdf}" width="100%" height="100%"  style="min-height: 80vh;" frameborder="0" 
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                allowfullscreen></iframe>
    `);

    // Fix the close button's position
    // jQuery('.documentManagementBody #closeBody').css({
    //     'top': 'auto',
    //     'bottom': '13px'
    // });

    // Make the modal body visible by changing its display class
    jQuery('.documentManagementBody').removeClass('d-none').addClass('d-flex');
}




jQuery(document).on('click', '.paperwork-item.upload', function(e) {
    e.preventDefault();



    var row = jQuery(this).closest('.paperwork-document');
    var documentId = row.data('document-id');
    var uploadName = row.data('upload-name');


    // Set the document ID and name in the modal
    jQuery('#documentId').val(documentId);
    jQuery('#uploadName').val(uploadName);

    // Open the modal
    jQuery('.documentManagementBody').removeClass('d-none').addClass('d-flex');

    if (jQuery('.documentManagementBody .goPaperworkBtn').length === 0) {
        var appendBtn = `
        <button class="btn btn-primary rounded-pill mt-2 goPaperworkBtn" style="position:absolute; left:13px; bottom:13px;">Go Paperwork</button>
    `;

        jQuery('.documentManagementBody').append(appendBtn);
    }

    checkBoldSignDocument(documentId, uploadName);
});



jQuery(document).on('click', '.paperwork-item.signature', function(e) {
    e.preventDefault();

    var row = jQuery(this).closest('.paperwork-document');
    var documentId = row.data('document-id');
    var uploadName = row.data('upload-name');


    // Set the document ID and name in the modal
    jQuery('#documentId').val(documentId);
    jQuery('#uploadName').val(uploadName);

    // Open the modal
    jQuery('.documentManagementBody').removeClass('d-none').addClass('d-flex');

    if (jQuery('.documentManagementBody .goPaperworkBtn').length === 0) {
        var appendBtn = `
        <button class="btn btn-primary rounded-pill mt-2 goPaperworkBtn" style="position:absolute; left:13px; bottom:13px;">Go Paperwork</button>
    `;

        jQuery('.documentManagementBody').append(appendBtn);
    }

    checkBoldSignDocumentSignature(documentId, uploadName);
});



function checkBoldSignDocumentSignature(documentId, uploadName) {
    var dealId = sessionStorage.getItem('@deal-entry-id');
    var formId = sessionStorage.getItem('@deal-form-id');

    var formData = new FormData();
    formData.append("action", "get_documents_from_server");
    formData.append("form_id", formId); // Replace with your form ID
    formData.append("entry_id", dealId);
    formData.append('documentId', documentId);
    formData.append('documentName', uploadName);
    addAdditionalDealData(formData)
        .done(function(res) {
            // Handle the response from the AJAX call
            if (res.success) {
                // alert('Successfully get Document');
                var document = Array.isArray(res.data) && res.data.length > 0 ? res.data[res.data.length - 1] :
                    null;
                console.log(res.data);
                if (document.templateId != null) {
                    userBoldSignTemplateLink(document.templateId);

                }
            }
        })
        .fail(function(error) {
            console.log("Error:", error);
        });
}


function userBoldSignTemplateLink(templateId) {
    // Create a FormData object for multipart form submission
    var clientEmail = sessionStorage.getItem('@deal-client-email');
    // var clientEmail = 'rancoded.it@gmail.com';
    var formData = new FormData();
    formData.append('action', 'boldsign_user_sign_link'); // Action for WordPress AJAX handler
    formData.append('boldDocumentId', templateId);
    formData.append('signerEmail', clientEmail);

    console.log('clientEmail:', clientEmail);


    // Send AJAX request to WordPress backend
    jQuery.ajax({
        url: '<?php echo admin_url('admin-ajax.php'); ?>', // This is automatically available in WordPress for admin-ajax.php
        type: 'POST',
        processData: false, // Important for FormData to work properly
        contentType: false, // Important for FormData to work properly
        data: formData,
        success: function(response) {
            console.log('Response from backend:', response);
            if (response.success) {
                var sendUrl = response.data.signLink;
                // console.log('Document ID:', documentId, 'Send URL:', sendUrl);
                openBoldSignModal(sendUrl);

            } else {
                alert('Error: ', response.error);
            }
        },
        error: function(xhr, status, error) {
            // console.error('AJAX error:', error);
        }
    });
}


jQuery(document).on('click', '.goPaperworkBtn', function(e) {
    var dealId = sessionStorage.getItem('@deal-entry-id');
    jQuery('.documentManagementBody').removeClass('d-none').addClass('d-flex');
    jQuery('.documentManagementBody .goPaperworkBtn').remove();
    dealPaperWorkDetails(dealId);

});




jQuery(document).on('click', '.dropdown-item.file-upload', function(e) {
    e.preventDefault();

    var row = jQuery(this).closest('tr');
    var documentId = row.data('document-id');
    var uploadName = row.data('upload-name');

    // Set the document ID and name in the modal
    jQuery('#documentId').val(documentId);
    jQuery('#uploadName').val(uploadName);

    // Open the modal
    jQuery('.documentManagementBody #documentManageTitle').show();
    jQuery('.documentManagementBody .documentManagementContainer').removeClass('p-0 customModalWidthFull')
        .addClass(
            'p-3 border-0 customModalWidthHalf');
    jQuery('.documentManagementBody .sendDocumentSection').removeClass('d-none').addClass('d-block');
    jQuery('.documentManagementBody .documentViewSection').removeClass('d-block').addClass('d-none');
    jQuery('.documentManagementBody').removeClass('d-none').addClass('d-flex');
    jQuery('.documentManagementBody #documentManageTitle').html('Upload Document');
});



jQuery(document).on('click', '.dropdown-item.view-file-doc', function(e) {
    e.preventDefault();
    var row = jQuery(this).closest('tr');
    var documentId = row.data('document-id');
    var documentName = row.data('upload-name');

    // Set the document ID and name in the modal


    fetchDocumentFiles(documentId, documentName);


});


function fetchDocumentFiles(documentId, documentName) {
    jQuery('#loadingSpinner').show();
    var entryId = sessionStorage.getItem('@deal-entry-id');
    var formId = sessionStorage.getItem('@deal-form-id');
    var formData = new FormData();
    formData.append("action", "get_documents_from_server");
    formData.append("form_id", formId); // Replace with your form ID
    formData.append("entry_id", entryId);
    formData.append('documentId', documentId);
    formData.append('documentName', documentName);
    addAdditionalDealData(formData)
        .done(function(res) {
            jQuery('#loadingSpinner').hide();
            // Handle the response from the AJAX call
            if (res.success) {
                // alert('Successfully get Document');
                displayDocuments(res.data);

            } else {
                alert('Cannot find deal documents')
            }
        })
        .fail(function(error) {
            alert('Error finding deal documents', error)
            console.error("Error:", error);
        });
}

function displayDocuments(documents) {
    jQuery('.documentManagementBody .documentManagementContainer').removeClass('p-3 customModalWidthFull').addClass(
        'p-3 border-0 customModalWidthHalf');
    jQuery('.documentManagementBody #documentManageTitle').show().html('View your documentation');
    jQuery('.documentManagementBody .sendDocumentSection').removeClass('d-block').addClass('d-none');
    jQuery('.documentManagementBody .documentViewSection').removeClass('d-none').addClass('d-block');

    let modalContent = '';

    documents.forEach(function(doc) {
        modalContent += '<div class="deal-document-entry">';
        modalContent += '<div class="d-flex justify-content-start align-items-center"><h4 class="mr-2">' + doc
            .doc_name + '</h4>';

        // Status badge
        if (doc.document_is_complete === "uncompleted") {
            modalContent +=
                '<span class="turbo-danger font-10 px-2 py-1 rounded-pill"><i class="fas fa-circle small mr-2"></i>Uncompleted</span>';
        } else {
            modalContent +=
                '<span class="turbo-success font-10 px-2 py-1 rounded-pill"><i class="fas fa-circle small mr-2"></i>Completed</span>';
        }

        // Delete button
        modalContent +=
            '<button type="button" class="btn btn-danger font-10 rounded-pill ml-2 delete-doc" data-doc-id="' +
            doc
            .doc_id + '" data-doc-name="' + doc.doc_name + '" data-entry-id="' + doc.entry_id +
            '">Delete</button>';

        // Toggle completion status button
        modalContent +=
            '<button type="button" class="btn btn-secondary font-10 rounded-pill ml-2 update-status" data-doc-id="' +
            doc.doc_id + '" data-doc-name="' + doc.doc_name + '" data-status="' + (doc.document_is_complete ===
                "completed" ? "uncompleted" :
                "completed") + '">Mark as ' + (doc.document_is_complete === "completed" ? "Uncompleted" :
                "Completed") + '</button>';

        modalContent += '</div>';

        // Loop through the document files and display links or previews
        doc.doc_files.forEach(function(fileUrl) {
            if (fileUrl.endsWith('.pdf')) {
                modalContent += '<a class="col-12 col-md-6" href="' + fileUrl +
                    '" target="_blank">View PDF file</a><br>';
                modalContent += '<pdf-viewer src="' + fileUrl + '"></pdf-viewer><br>';
            } else if (fileUrl.endsWith('.jpg') || fileUrl.endsWith('.jpeg') || fileUrl.endsWith(
                    '.png') || fileUrl.endsWith('.svg')) {
                modalContent += '<a class="col-12 col-md-6" href="' + fileUrl +
                    '" target="_blank"><img style="width:100%; height:100%; padding:10px; border-radius:10px;" src="' +
                    fileUrl + '" /></a><br>';
            } else {
                modalContent += '<a class="btn btn-primary rounded-pill" href="' + fileUrl +
                    '" target="_blank">View File</a><br>';
            }
        });

        modalContent += '</div>';
    });

    // Assuming you have a modal container with the class 'documentManagementBody'
    jQuery('.documentManagementBody .documentViewSection').html(modalContent);
    jQuery('.documentManagementBody').removeClass('d-none').addClass('d-flex');
}





jQuery(document).on('click', '.delete-file-doc', function() {
    var docId = jQuery(this).data('doc-id');
    var entryId = jQuery(this).data('entry-id');
    var docName = jQuery(this).data('doc-name');


    var formData = new FormData();
    formData.append("action", "delete_document_from_server");
    formData.append("form_id", 324878); // Replace with your form ID
    formData.append("entry_id", entryId);
    formData.append('doc_id', docId);
    formData.append('doc_name', docName);
    addAdditionalDealData(formData)
        .done(function(res) {
            jQuery('#loadingSpinner').hide();
            // Handle the response from the AJAX call
            if (res.success) {
                // alert('Successfully get Document');

                fetchDocumentFiles(docId, docName);

            } else {
                alert('Error deleting document: ' + response.data);
            }
        })
        .fail(function(error) {
            alert('Error finding deal documents', error)
            console.error("Error:", error);
        });
});


jQuery(document).on('click', '.update-status', function() {
    var docId = jQuery(this).data('doc-id');
    var newStatus = jQuery(this).data('status');
    var entryId = jQuery(this).data('entry-id');
    var docName = jQuery(this).data('doc-name');


    var formData = new FormData();
    formData.append("action", "update_document_status");
    formData.append("form_id", 324878); // Replace with your form ID
    formData.append("entry_id", entryId);
    formData.append('doc_id', docId);
    formData.append('document_is_complete', newStatus);
    addAdditionalDealData(formData)
        .done(function(res) {
            jQuery('#loadingSpinner').hide();
            // Handle the response from the AJAX call
            if (res.success) {
                // alert('Successfully get Document');

                fetchDocumentFiles(docId, docName);

            } else {
                alert('Error updating status: ' + response.data);
            }
        })
        .fail(function(error) {
            console.error('AJAX Error:', error);
        });

});







jQuery(document).on('click', '.documentManagementBody #closeBody', function() {
    jQuery('.documentManagementBody .goPaperworkBtn').remove();
    jQuery('.documentManagementBody').removeClass('d-flex').addClass('d-none');
});





jQuery("#submitDocumentToServer").on("click", function() {
    jQuery('#loadingSpinner').show();
    var entryId = sessionStorage.getItem('@deal-entry-id');
    var formId = sessionStorage.getItem('@deal-form-id');

    var $documentUploadFileInput = jQuery("#documentUploadFileInput");
    var documents = $documentUploadFileInput[0];

    var documentId = jQuery('#documentId').val();
    var documentName = jQuery('#uploadName').val();

    console.log(`documentUpload ${documents.files}`);

    if (documents.files.length > 0) {
        var formData = new FormData();
        formData.append("action", "submit_document_deal");
        formData.append("form_id", formId); // Replace with your form ID
        formData.append("entry_id", entryId); // Replace with your entry ID
        formData.append("data_meta", "deal_client_document");
        formData.append('form_name', 'Deal Client Document');
        formData.append('form_title', 'Deal Client Document Submit');
        formData.append('documentId', documentId);
        formData.append('documentName', documentName);

        jQuery.each(documents.files, function(index, file) {
            formData.append("images[]", file, file.name);
        });

        addAdditionalDealData(formData)
            .done(function(res) {
                jQuery('#loadingSpinner').hide();
                // Handle the response from the AJAX call
                if (res.success) {
                    getDealInfoAfterUpdateData();
                    alert('Successfully Updated Deal Document')
                } else {
                    alert('Error updated deal documents')
                }
            })
            .fail(function(error) {
                alert('Error updated seal information', error)
                console.error("Error:", error);
            });

    } else {
        alert("Please select files to upload.");
    }



});
</script>

<script>
// Example usage for different instances
initializeFileUploadHandler('#documentUploadDropArea', '#documentUploadFileInput', '#documentInsertedPreviewContainer',
    '.upload-upload-btn');
</script>

<style>
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap");

.documentManagementBody {
    display: flex;
    font-family: "Poppins", sans-serif;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    background-color: #565555b0;
    color: #000000;
    background-image: radial-gradient(circle at 25% 25%,
            rgba(255, 255, 255, 0.1) 2%,
            transparent 0%),
        radial-gradient(circle at 75% 75%,
            rgba(221, 221, 221, 0.1) 2%,
            transparent 0%);
    background-size: 60px 60px;
    z-index: 999;
    position: fixed;
    left: 0;
    top: 0;
    right: 0;
    bottom: 0;
}

.documentManagementContainer {
    background-color: rgba(255, 255, 255, 0.8);
    padding: 3rem;
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
    text-align: center;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    width: 100%;
}

@media (min-width: 768px) {
    .documentManagementContainer {
        max-width: 700px;
        max-height: 80vh;
        overflow-y: scroll;
    }
}

@media (min-width: 450px) and (max-width: 768px) {
    .documentManagementContainer {
        max-width: 400px;
        max-height: 80vh;
        overflow-y: scroll;
    }
}

@media (min-width: 250px) and (max-width: 450px) {
    .documentManagementContainer {
        max-width: 100%;
        margin: auto 10px;
        max-height: 80vh;
        overflow-y: scroll;
    }
}

h1 {
    margin-bottom: 1.5rem;
    color: #000000;
    font-weight: 600;
    font-size: 2rem;
}

p {
    margin-bottom: 2rem;
    font-weight: 300;
}


#submitDocumentToServer,
.goPaperworkBtn {
    background: linear-gradient(135deg,
            rgba(59, 99, 76, 1),
            rgb(95, 139, 114));
    color: rgb(255, 255, 255);
    border: 2px solid rgba(59, 99, 76, 1);
    padding: 12px 15px;
    font-size: 1rem;
    border-radius: 50px;
    cursor: pointer;
    margin: 5px;
    transition: all 0.3s ease;
    font-weight: 500;
    letter-spacing: 0.5px;
    min-width: 180px;
}


#submitDocumentToServer:hover {
    background: linear-gradient(135deg, rgba(59, 99, 76, 1), #191919);
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(2, 2, 2, 0.131);
}


#submitDocumentToServer:disabled {
    background: #cccccc;
    border-color: #999999;
    color: #666666;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

#documentInsertedPreviewContainer {
    overflow-y: scroll;
    max-height: 390px;
}

.remove-button {
    position: absolute;
    right: 5px;
    bottom: 5px;
    width: 25px;
    height: 25px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 100px;
}

.preview-item .card {
    height: 100%;
}
</style>