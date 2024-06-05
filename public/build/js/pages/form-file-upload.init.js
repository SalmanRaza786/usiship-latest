/*
Template Name: Velzon - Admin & Dashboard Template
Author: Themesbrand
Website: https://Themesbrand.com/
Contact: Themesbrand@gmail.com
File: Form file upload Js File
*/

// Dropzone
var dropzonePreviewNode = document.querySelector("#dropzone-preview-list");
dropzonePreviewNode.id = "";
if(dropzonePreviewNode){
    var previewTemplate = dropzonePreviewNode.parentNode.innerHTML;
    dropzonePreviewNode.parentNode.removeChild(dropzonePreviewNode);
    var dropzone = new Dropzone(".dropzone", {
        url: route('packaging.images.store'),
        method: "get",
        maxFilesize: 2,
        acceptedFiles: ".jpeg,.jpg,.png,.gif",
        timeout: 50000,
        previewTemplate: previewTemplate,
        previewsContainer: "#dropzone-preview",
        success: function(file, response) {
            console.log(response);
            toast.success(response.message);
        },
        error: function(file, response) {
            console.log(response);
            toast.error(response.message);
            return false;
        }
    });
}

