<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="field-preview" class="readonly_label">
<?php echo $value; ?>
</div>
<script type="text/javascript">
$(function() {
    $('#crudForm').change(function(event) {
            // get the values:
            var title = $('#field-title').val(),
                authors = $('#field-authors').val(),
                editors = $('#field-editors').val(),
                publication = $('#field-publication').val(),
                volume = $('#field-volume').val(),
                year = $('#field-year').val(), 
                places = $('#field-places').val(), 
                publishingHouse = $('#field-publishingHouse').val(), 
                year = $('#field-year').val(), 
                pages = $('#field-pages').val(), 
                preview = '';

            // This algorithm is a copy of the corresponding php function
            // toFormattedString() in Document_model, keep in mind, when
            // changing the php code.
            // FIXME: preview should be generated on the server by 
            // the same function.

            // If document is a monography without page indication
            if((editors.length + pages.length + publication.length) == 0){
                preview += authors;
                preview += " (";
                preview += year;
                preview += "): <i>";
                preview += title;
                preview += "</i>";
                if(volume.length > 0){
                    preview += " ";
                    preview += volume;
                }
                preview += ", ";
                preview += places;
                preview += ": ";
                preview += publishingHouse;
                preview += ".";
            }
            // If document is a monography with page indication
            else if((editors.length + publication.length) == 0 && pages.length > 0){
                preview += authors;
                preview += " (";
                preview += year;
                preview += "): <i>";
                preview += title;
                preview += "</i>";
                if(volume.length > 0){
                    preview += " ";
                    preview += volume;
                }
                preview += ", ";
                preview += places;
                preview += ": ";
                preview += publishingHouse;
                preview += ", ";
                preview += pages;
                preview += ".";
            }
            // If document is a chapter of a book
            else if(editors.length == 0 && places.length > 0 && publishingHouse.length > 0){
                preview += authors;
                preview += " (";
                preview += year;
                preview += "): \"";
                preview += title;
                preview += "\", in: ";
                preview += authors;
                preview += ": <i>";
                preview += publication;
                preview += "</i>";
                if(volume.length > 0){
                    preview += " ";
                    preview += volume;
                }
                preview += ", ";
                preview += places;
                preview += ": ";
                preview += publishingHouse;
                preview += ", ";
                preview += pages;
                preview += ".";
            }
            // If document is a magazine article
            else if((editors.length + places.length + publishingHouse.length) == 0){
                preview += authors;
                preview += " (";
                preview += year;
                preview += "): \"";
                preview += title;
                preview += "\", in: <i>";
                preview += publication;
                preview += "</i>";
                if(volume.length > 0){
                    preview += " ";
                    preview += volume;
                }
                preview += ", ";
                preview += pages;
                preview += ".";
            }
            // If document is an article in a book
            else if(title.length != 0 &&
                    authors.length != 0 &&
                    publication.length != 0 &&
                    editors.length != 0 &&
                    places.length != 0 &&
                    publishingHouse.length != 0 &&
                    pages.length != 0){
                preview += authors;
                preview += " (";
                preview += year;
                preview += "): \"";
                preview += title;
                preview += "\", in: ";
                preview += editors;
                preview += ": <i>";
                preview += publication;
                preview += "</i>";
                if(volume.length > 0){
                    preview += " ";
                    preview += volume;
                }
                preview += ", ";
                preview += places;
                preview += ": ";
                preview += publishingHouse;
                preview += ", ";
                preview += pages;
                preview += ".";
            } else {
                preview = 'Vorschau konnte nicht generiert werden.';
            }
            $('#field-preview').html(preview);
        })
    });
</script>
<?php
/* End of file preview_field.php */
/* Location: ./application/views/crud/preview_field.php */
?>