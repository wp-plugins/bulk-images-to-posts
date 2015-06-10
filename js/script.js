jQuery(document).ready(function($){
	
   $('#bip-upload-form').submit(function() { 
      $(this).ajaxSubmit({
         success: function(){
            $('#saveResult').html("<div id='saveMessage' class='successModal'></div>");
            $('#saveMessage').append("<p>Changes saved...</p>").show();
         }, 
         timeout: 5000
      }); 
      setTimeout("jQuery('#saveMessage').hide('slow');", 5000);
      return false; 
   });
    
		
    $('.check:button').click(function(){
        $('input:checkbox').removeAttr('checked'); 
        $(".checkbox-container input[type='checkbox']").each(function() {
            $(this).parent("li").children("ul").hide(600);
                  $('#bip-upload-form').ajaxSubmit({
         success: function(){
            $('#saveResult').html("<div id='saveMessage' class='successModal'></div>");
            $('#saveMessage').append("<p>Changes saved...</p>").show();
         }, 
         timeout: 5000
      }); 
      setTimeout("jQuery('#saveMessage').hide('slow');", 5000);
      return false; 
         });
    })

   $(".checkbox-container input[type='checkbox']").each(function() {
        if ($(this).is(':checked')) { 
            $(this).parent("li").children("ul").css('display', 'block');;
           }
    }); 

 $(".checkbox-container input[type='checkbox']").change(function() {
        if ($(this).is(':checked')) { 
            $(this).parent("li").children("ul").show(600);
            var checkBox = $(this);

          $('#bip-upload-form').ajaxSubmit({
         success: function(){
                checkBox.parent("li").addClass('saved');
                setTimeout(function () { 
                    checkBox.parent("li").removeClass('saved');
                }, 2000);
            }, 
         timeout: 5000
      });

           } else {  
            $(this).parent("li").children("ul").hide(600);
            $(this).parent("li").children("ul").find('input:checkbox').each(function() {
              $(this).removeAttr('checked');   
            });
            var checkBox = $(this);
$('#bip-upload-form').ajaxSubmit({
         success: function(){
                checkBox.parent("li").addClass('removed');
                setTimeout(function () { 
                    checkBox.parent("li").removeClass('removed');
                }, 2000);
            }, 
         timeout: 5000
      });
            }
    });    
});

// Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
var previewNode = document.querySelector("#template");
previewNode.id = "";
var previewTemplate = previewNode.parentNode.innerHTML;
previewNode.parentNode.removeChild(previewNode);
 
var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
  url: "/target-url", // Set the url
  thumbnailWidth: 80,
  thumbnailHeight: 80,
  parallelUploads: 20,
  previewTemplate: previewTemplate,
  autoQueue: false, // Make sure the files aren't queued until manually added
  previewsContainer: "#previews", // Define the container to display the previews
  clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
});
 
myDropzone.on("addedfile", function(file) {
  // Hookup the start button
  file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file); };
});
 
// Update the total progress bar
myDropzone.on("totaluploadprogress", function(progress) {
  document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
});
 
myDropzone.on("sending", function(file) {
  // Show the total progress bar when upload starts
  document.querySelector("#total-progress").style.opacity = "1";
  // And disable the start button
  file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
});
 
// Hide the total progress bar when nothing's uploading anymore
myDropzone.on("queuecomplete", function(progress) {
  document.querySelector("#total-progress").style.opacity = "0";
});
 
// Setup the buttons for all transfers
// The "add files" button doesn't need to be setup because the config
// `clickable` has already been specified.
document.querySelector("#actions .start").onclick = function() {
  myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
};
document.querySelector("#actions .cancel").onclick = function() {
  myDropzone.removeAllFiles(true);
};