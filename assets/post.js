import tinymce from '../vendor/tinymce/tinymce'

import '../vendor/tinymce/tinymce/themes/silver/theme';
import '../vendor/tinymce/tinymce/icons/default/icons';
import '../vendor/tinymce/tinymce/plugins/image';

require ("../vendor/tinymce/tinymce/skins/ui/oxide/skin.min.css");
require ("../vendor/tinymce/tinymce/skins/ui/oxide/content.min.css");
require ("../vendor/tinymce/tinymce/skins/content/default/content.css" );

let form = document.querySelector("#tinymce_editor")

tinymce.init({
    selector: '#news_content',
    menubar: false,
    plugins: "image link",
    toolbar: 'undo redo | styleselect | forecolor | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link image ',
    relative_urls : true,
    image_class_list: [
      {title: 'Dostosuj wielkość', value: 'img-fluid'},
      ],
    automatic_uploads: true,
    images_upload_url: '/attachment/' + form.dataset.newsId,
    file_picker_types: 'images file',
    file_picker_callback: function (cb, value, meta) {
        var input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');
    
        input.onchange = function () {
          var file = this.files[0];
    
          var reader = new FileReader();
          reader.onload = function () {

            var id = 'blobid' + (new Date()).getTime();
            var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
            var base64 = reader.result.split(',')[1];
            var blobInfo = blobCache.create(id, file, base64);
            blobCache.add(blobInfo);
    
            cb(blobInfo.blobUri(), { title: file.name });
          };
          reader.readAsDataURL(file);
        };
        input.click();
      },
  });