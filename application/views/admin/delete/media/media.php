 <!-- <div class="col-lg-12"> -->
    <h1 class="page-header">Blank</h1>
                    
    <label class="control-label">Select File</label>
    <input class="file-loading" id="media_file" name="media_file[]" multiple type="file">
    
    <script>
        $("#media_file").fileinput({
            allowedFileExtensions : ["gif", "jpg", "png"],
            language : '<?php echo $language ?>', 
            previewFileType : 'any',
            uploadUrl : '<?php echo site_url() ?>/admin/<?php echo $page ?>/upload_ajax'
        });
    </script>
<!-- </div> -->
<!-- /.col-lg-12 -->